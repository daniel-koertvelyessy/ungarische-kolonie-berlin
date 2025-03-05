<?php

use App\Http\Controllers\RegisterController;
use App\Mail\SendMemberMassMail;
use App\Models\Event\Event;
use App\Models\Event\EventSubscription;
use App\Models\Membership\Member;
use App\Services\EventReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// use Spatie\Browsershot\Browsershot;

Route::get('/mailer-test', function () {
    app()->setLocale('hu');

    return view('emails.invitation', ['member' => Member::find(1)]);
})
    ->name('mail-tester');

Route::get('lang/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
});

Route::get('/', function () {
    return view('welcome', [
        'events' => \App\Models\Event\Event::with('venue')
            ->where('status', '=', \App\Enums\EventStatus::PUBLISHED)
            ->whereBetween('event_date', [
                Carbon::today(), Carbon::now()
                    ->endOfYear(),
            ])
            ->take(3)
            ->get(),
        'events_total' => \App\Models\Event\Event::whereBetween('event_date', [
            Carbon::today(), Carbon::now()
                ->endOfDecade(),
        ])
            ->where('status', '=', \App\Enums\EventStatus::PUBLISHED->value)
            ->get()
            ->count(),
        'articles' => \App\Models\Article::take(3)
            ->get(),
        'articles_total' => \App\Models\Article::all()
            ->count(),
    ]);
})
    ->name('home');

Route::get('/events', function () {
    return view('events.index', [
        'events' => \App\Models\Event\Event::orderBy('event_date')
            ->where('status', '=', \App\Enums\EventStatus::PUBLISHED->value)
            ->paginate(5),
        'locale' => App::getLocale(),
    ]);
})
    ->name('events');

Route::get('/events/{slug}', function (string $slug) {
    return view('events.show', [
        'event' => Event::with('venue')
            ->whereJsonContains('slug', $slug)
            ->firstOrFail(),
        'locale' => App::getLocale(),
    ]);
})
    ->name('events.show');

Route::get('/articles', \App\Livewire\Article\Index\Page::class)
    ->name('articles.index');

Route::get('/ics/{slug}', function (string $slug) {
    $locale = App::getLocale();

    // Find the event by JSON slug field
    $event = Event::whereJsonContains('slug', $slug)
        ->firstOrFail();
    // Combine the event_date with start_time to form a full DateTime string

    $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->event_date->format('Y-m-d').' '.$event->start_time->format('H:i:s'), 'Europe/Berlin');
    $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->event_date->format('Y-m-d').' '.$event->end_time->format('H:i:s'), 'Europe/Berlin');

    // Convert to UTC timezone
    $startDateTime->setTimezone('UTC');
    $endDateTime->setTimezone('UTC');

    // Format the dates in iCalendar format (YYYYMMDDTHHMMSSZ)
    $startFormatted = $startDateTime->format('Ymd\THis\Z');
    $endFormatted = $endDateTime->format('Ymd\THis\Z');

    $title = $event->title[$locale] ?? 'Untitled Event';
    $description = Str::limit($event->description[$locale], 50, ' ..', true);
    $location = $event->location ?? 'Event Location';

    // Generate a unique UID (could be based on event data or UUID)
    $uid = uniqid('event_', true).'@ungarische-kolonie-berlin.org';

    // Get current date and time for DTSTAMP
    $dtStamp = Carbon::now('UTC')
        ->format('Ymd\THis\Z');

    // Create ICS content with CRLF line breaks
    $icsContent = "BEGIN:VCALENDAR\r\n";
    $icsContent .= "VERSION:2.0\r\n";
    $icsContent .= "PRODID:-//Your Company//NONSGML v1.0//EN\r\n";
    $icsContent .= "BEGIN:VEVENT\r\n";
    $icsContent .= 'SUMMARY:'.$title."\r\n";
    $icsContent .= 'LOCATION:'.$location."\r\n";
    $icsContent .= 'DTSTART:'.$startFormatted."\r\n";
    $icsContent .= 'DTEND:'.$endFormatted."\r\n";
    $icsContent .= "DESCRIPTION:$description\r\n";
    $icsContent .= "STATUS:CONFIRMED\r\n";
    $icsContent .= 'DTSTAMP:'.$dtStamp."\r\n";  // Add DTSTAMP property
    $icsContent .= 'UID:'.$uid."\r\n";  // Add UID property
    $icsContent .= "END:VEVENT\r\n";
    $icsContent .= "END:VCALENDAR\r\n";

    // Create and store the .ics file
    $fileName = 'event_'.$event->event_date->format('Y-m-d').'.ics';
    //    Storage::disk('public')->put($fileName, $icsContent);

    // Alternatively, return the file as a response for immediate download
    return response($icsContent, 200)
        ->header('Content-Type', 'text/calendar')
        ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');
});

Route::get('/impressum', function () {
    return view('impressum');
})
    ->name('impressum');

Route::get('/der-verein', function () {
    return view('about-us');
})
    ->name('about-us');

Route::get('/mitglied-werden', \App\Livewire\Member\Apply\Page::class)
    ->name('members.application');

Route::get('/print-member-application/{member}', function (\App\Models\Membership\Member $member) {
    $html = view('pdf.membership-application', ['member' => $member])->render();
    $filename = __('members.apply.print.filename', ['tm' => date('YmdHis'), 'id' => $member->id]);
    $pdf = new TCPDF;

    // Set document information
    $pdf->SetTitle(__('members.apply.print.title'));
    $pdf->SetSubject(__('members.apply.print.title'));
    $pdf->setMargins(24, 10, 10);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    // Add a page
    $pdf->AddPage();

    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the PDF as a download
    $pdf->Output($filename, 'D');

    return $this->redirect(route('home'));
    /*    $filePath = 'members/applications/tmp/'.$filename; // Define the file path
        Storage::disk('local')
            ->put($filePath, $pdf);
        if (Storage::disk('local')
            ->exists($filePath)) {
            return Storage::disk('local')
                ->download($filePath, $filename);
        }

        abort(404, 'File not found');*/
})
    ->name('members.print_application');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');
Route::post('/register', [RegisterController::class, 'create']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])
    ->group(function () {

        Route::get('/tools', \App\Livewire\App\Tool\Index\Page::class)
            ->name('tools.index');

        Route::get('/members', \App\Livewire\Member\Index\Page::class)
            ->name('members.index');

        Route::get('/members/{member}', \App\Livewire\Member\Show\Page::class)
            ->name('members.show');

        Route::get('/members-create', \App\Livewire\Member\Create\Page::class)
            ->name('members.create');

        Route::get('/members-import', \App\Livewire\Member\Import\Page::class)
            ->name('members.import');

        Route::get('/backend-events', \App\Livewire\Event\Index\Page::class)
            ->name('backend.events.index');

        Route::get('/backend-events/create', \App\Livewire\Event\Create\Page::class)
            ->name('backend.events.create');

        Route::get('/backend-events/{event}', \App\Livewire\Event\Show\Page::class)
            ->name('backend.events.show');

        Route::get('/backend-events/report/{event}', function (Event $event, EventReportService $reportService) {
            return $reportService->generate($event);
        })->name('backend.events.report');

        Route::get('/accounting', \App\Livewire\Accounting\Index\Page::class)
            ->name('accounting.index');

        Route::get('/transaction', \App\Livewire\Accounting\Transaction\Create\Page::class)
            ->name('transaction.create');

        Route::get('/transactions', \App\Livewire\Accounting\Transaction\Index\Page::class)
            ->name('transaction.index');

        Route::get('/account-report', \App\Livewire\Accounting\Report\Index\Page::class)
            ->name('accounts.report.index');

        Route::get('/account-report/print/{account_report}', function (\App\Models\Accounting\AccountReport $accountReport, \App\Services\AccountReportService $reportService) {
            return $reportService->generate($accountReport);
        })->name('accounts.report.print');

        Route::get('/account-report/audit/{account_report_audit}', function (\App\Models\Accounting\AccountReportAudit $accountReportAudit) {
            if (Auth::user()->id === $accountReportAudit->user_id) {
                return view('accounts.reports.audit', [
                    'accountReportAuditId' => $accountReportAudit->id,
                ]);
            } else {
                return redirect()->route('accounts.report.index');
            }
        })->name('account-report.audit');

        Route::get('/accounts', \App\Livewire\Accounting\Account\Index\Page::class)
            ->name('accounts.index');

        Route::get('/receipts', \App\Livewire\Accounting\Receipt\Index\Page::class)
            ->name('receipts.index');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/test-mail-preview', function () {
            $mailable = new SendMemberMassMail(
                'Daniel',
                request('subject'),
                request('message'),
                request('locale'),
                request('url'),
                request('url_label'),
                []
            );

            return $mailable->render();
        })->name('test-mail-preview');

        Route::get('/secure-image/{filename}', function (Request $request, $filename) {
            // Ensure user is authenticated
            if (! auth()->check()) {
                abort(403); // Forbidden
            }

            // Build full path
            $path = storage_path('app/private/accounting/receipts/previews/'.pathinfo($filename, PATHINFO_FILENAME).'.png');

            // Check if file exists
            if (! file_exists($path)) {
                abort(404);
            }

            // Serve the file as a response
            return Response::file($path, [
                'Content-Type' => 'image/png',
            ]);
        });
    });

Route::get('/event-subscription/confirm/{id}/{token}', function ($id, $token) {
    $subscription = EventSubscription::findOrFail($id);

    $storedToken = cache()->get("event_subscription_{$subscription->id}_token");

    if ($storedToken && $storedToken === $token) {
        $subscription->update(['confirmed_at' => now()]);
        cache()->forget("event_subscription_{$subscription->id}_token");

        session()->flash('status', 'Deine Anmeldung wurde bestätigt! 🎉');

        return view('events.show', ['event' => $subscription->event, 'locale' => app()->getLocale()]);
    }

    abort(403);
})
    ->name('event.subscription.confirm');
