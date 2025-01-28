<?php

use App\Models\Event;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

Route::get('lang/{locale}', function ($locale)
{
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/', function ()
{
    return view('welcome', [
        'events' => \App\Models\Event::with('venue')
            ->where('starts_at', '>', now())
            ->take(3)
            ->get(),
        'total'  => \App\Models\Event::where('starts_at', '>', now())
            ->get()
            ->count(),
    ]);
})->name('home');

Route::get('/events', function ()
{
    return view('events.index', [
        'events' => \App\Models\Event::orderBy('starts_at')
            ->paginate(5),
        'locale' => App::getLocale()
    ]);
})
    ->name('events');

Route::get('/events/{slug}', function (string $slug)
{
    return view('events.show', [
        'event'  => Event::with('venue')
            ->whereJsonContains('slug', $slug)
            ->firstOrFail(),
        'locale' => App::getLocale()
    ]);
})
    ->name('events.show');

Route::get('/ics/{slug}', function (string $slug)
{
    $locale = App::getLocale();

    // Find the event by JSON slug field
    $event = Event::whereJsonContains('slug', $slug)
        ->firstOrFail();

    // Retrieve localized details
    $title = $event->title[$locale] ?? 'Untitled Event';
    $description = $event->description[$locale] ?? '';
    $location = $event->location ?? 'Event Location';

    // Format dates to UTC in iCalendar format (YYYYMMDDTHHMMSSZ)
    $start_date = gmdate('Ymd\THis\Z', strtotime($event->starts_at));
    $end_date = gmdate('Ymd\THis\Z', strtotime($event->ends_at));

    // Build the ICS file content
    $ics_data = "BEGIN:VCALENDAR\r\n";
    $ics_data .= "VERSION:2.0\r\n";
    $ics_data .= "PRODID:-//YourApp//NONSGML v1.0//EN\r\n";
    $ics_data .= "CALSCALE:GREGORIAN\r\n";
    $ics_data .= "METHOD:PUBLISH\r\n";
    $ics_data .= "BEGIN:VEVENT\r\n";
    $ics_data .= "UID:".uniqid()."@yourapp.com\r\n";
    $ics_data .= "SUMMARY:".addslashes($title)."\r\n";
    $ics_data .= "DESCRIPTION:".addslashes($description)."\r\n";
    $ics_data .= "LOCATION:".addslashes($location)."\r\n";
    $ics_data .= "DTSTART:".$start_date."\r\n";
    $ics_data .= "DTEND:".$end_date."\r\n";
    $ics_data .= "STATUS:CONFIRMED\r\n";
    $ics_data .= "END:VEVENT\r\n";
    $ics_data .= "END:VCALENDAR\r\n";

    $safeSlug = Str::slug($event->slug[$locale]);
    // Return as a downloadable response
    return response($ics_data)
        ->header('Content-Type', 'text/calendar; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename="'.$safeSlug.'.ics"');
});

Route::get('/impressum', function ()
{
    return view('impressum');
})
    ->name('impressum');

Route::get('/der-verein', function ()
{
    return view('about-us');
})
    ->name('about-us');

Route::get('/mitglied-werden', \App\Livewire\Member\Apply\Page::class)
    ->name('members.application');

Route::get('/print-member-application/{member}', function (\App\Models\Member $member)
{
    $html = view('pdf.membership-application', ['member' => $member])->render();
    $filename = __('members.apply.print.filename', ['tm' => date('YmdHis'), 'id' => $member->id]);
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetTitle( __('members.apply.print.title') );
    $pdf->SetSubject(__('members.apply.print.title'));
    $pdf->setMargins(24,10,10);
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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])
    ->group(function ()
    {
        Route::get('/members', \App\Livewire\Member\Index\Page::class)
            ->name('members');
        Route::get('/members/{member}', \App\Livewire\Member\Show\Page::class)
            ->name('members.show');


        Route::get('/dashboard', function ()
        {
            return view('dashboard');
        })
            ->name('dashboard');
    });

