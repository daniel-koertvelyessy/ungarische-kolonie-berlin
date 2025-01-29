<?php

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
//use Spatie\Browsershot\Browsershot;

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

Route::get('/ics_old/{slug}', function (string $slug)
{
    $locale = App::getLocale();

    // Find the event by JSON slug field
    $event = Event::whereJsonContains('slug', $slug)
        ->firstOrFail();

    // Retrieve localized details
    $title = $event->title[$locale] ?? 'Untitled Event';
    $description = Str::limit($event->description[$locale] , 50, ' ..', true);
    $location = $event->location ?? 'Event Location';

    // Format dates to UTC in iCalendar format (YYYYMMDDTHHMMSSZ)
    // Combine the event_date with start_time to form a full DateTime string

    $start= $event->event_date->format('Y-m-d') . ' ' . $event->start_time->format('H:i:s');
    $end = $event->event_date->format('Y-m-d') . ' ' . $event->end_time->format('H:i:s');

    $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $start);
    $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $end);

    // Convert to UTC timezone
    $startDateTime->setTimezone('UTC');
    $endDateTime->setTimezone('UTC');

    // Format the dates in iCalendar format (YYYYMMDDTHHMMSSZ)
    $startFormatted = $startDateTime->format('Ymd\THis\Z');
    $endFormatted = $endDateTime->format('Ymd\THis\Z');


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
    $ics_data .= "DTSTART:".$startFormatted."\r\n";
    $ics_data .= "DTEND:".$endFormatted."\r\n";
    $ics_data .= "STATUS:CONFIRMED\r\n";
    $ics_data .= "END:VEVENT\r\n";
    $ics_data .= "END:VCALENDAR\r\n";

    dd($ics_data);
    $safeSlug = Str::slug($event->slug[$locale]);
    // Return as a downloadable response
    return response($ics_data)
        ->header('Content-Type', 'text/calendar; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename="'.$safeSlug.'.ics"');
});

Route::get('/ics/{slug}', function (string $slug)
{
    $locale = App::getLocale();

    // Find the event by JSON slug field
    $event = Event::whereJsonContains('slug', $slug)
        ->firstOrFail();
    // Combine the event_date with start_time to form a full DateTime string


    $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->event_date->format('Y-m-d') . ' ' . $event->start_time->format('H:i:s'),'Europe/Berlin');
    $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->event_date->format('Y-m-d') . ' ' . $event->end_time->format('H:i:s'),'Europe/Berlin');



    // Convert to UTC timezone
    $startDateTime->setTimezone('UTC');
    $endDateTime->setTimezone('UTC');

    // Format the dates in iCalendar format (YYYYMMDDTHHMMSSZ)
    $startFormatted = $startDateTime->format('Ymd\THis\Z');
    $endFormatted = $endDateTime->format('Ymd\THis\Z');

    $title = $event->title[$locale] ?? 'Untitled Event';
    $description = Str::limit($event->description[$locale] , 50, ' ..', true);
    $location = $event->location ?? 'Event Location';

    // Generate a unique UID (could be based on event data or UUID)
    $uid = uniqid('event_', true) . '@ungarische-kolonie-berlin.org';

    // Get current date and time for DTSTAMP
    $dtStamp = Carbon::now('UTC')->format('Ymd\THis\Z');

    // Create ICS content with CRLF line breaks
    $icsContent = "BEGIN:VCALENDAR\r\n";
    $icsContent .= "VERSION:2.0\r\n";
    $icsContent .= "PRODID:-//Your Company//NONSGML v1.0//EN\r\n";
    $icsContent .= "BEGIN:VEVENT\r\n";
    $icsContent .= "SUMMARY:" . $title . "\r\n";
    $icsContent .= "LOCATION:" . $location . "\r\n";
    $icsContent .= "DTSTART:" . $startFormatted . "\r\n";
    $icsContent .= "DTEND:" . $endFormatted . "\r\n";
    $icsContent .= "DESCRIPTION:$description\r\n";
    $icsContent .= "STATUS:CONFIRMED\r\n";
    $icsContent .= "DTSTAMP:" . $dtStamp . "\r\n";  // Add DTSTAMP property
    $icsContent .= "UID:" . $uid . "\r\n";  // Add UID property
    $icsContent .= "END:VEVENT\r\n";
    $icsContent .= "END:VCALENDAR\r\n";


    // Create and store the .ics file
    $fileName = 'event_' . $event->event_date->format('Y-m-d') . '.ics';
//    Storage::disk('public')->put($fileName, $icsContent);

    // Alternatively, return the file as a response for immediate download
    return response($icsContent, 200)
        ->header('Content-Type', 'text/calendar')
        ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
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
            ->name('members.index');

        Route::get('/members/{member}', \App\Livewire\Member\Show\Page::class)
            ->name('members.show');

        Route::get('/backend-events', \App\Livewire\Event\Index\Page::class)
            ->name('backend.events.index');

        Route::get('/backend-events/{event}', \App\Livewire\Event\Show\Page::class)
            ->name('backend.events.show');


        Route::get('/dashboard', function ()
        {
            return view('dashboard');
        })
            ->name('dashboard');
    });

