<?php

namespace App\Services;

use App\Models\Event\Event;
use Carbon\Carbon;
use Illuminate\Support\Str;

class IcsGeneratorService
{
    public function generate(string $slug) {
        $locale = app()->getLocale();
        $event = Event::whereJsonContains('slug', $slug)->firstOrFail();

        $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->event_date->format('Y-m-d').' '.$event->start_time->format('H:i:s'), 'Europe/Berlin');
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $event->event_date->format('Y-m-d').' '.$event->end_time->format('H:i:s'), 'Europe/Berlin');
        $startDateTime->setTimezone('UTC');
        $endDateTime->setTimezone('UTC');

        $startFormatted = $startDateTime->format('Ymd\THis\Z');
        $endFormatted = $endDateTime->format('Ymd\THis\Z');
        $title = $event->title[$locale] ?? 'Untitled Event';
        $description = Str::limit($event->description[$locale], 50, ' ..', true);
        $location = $event->location ?? 'Event Location';
        $uid = uniqid('event_', true).'@ungarische-kolonie-berlin.org';
        $dtStamp = Carbon::now('UTC')->format('Ymd\THis\Z');

        $icsContent = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Your Company//NONSGML v1.0//EN\r\nBEGIN:VEVENT\r\nSUMMARY:$title\r\nLOCATION:$location\r\nDTSTART:$startFormatted\r\nDTEND:$endFormatted\r\nDESCRIPTION:$description\r\nSTATUS:CONFIRMED\r\nDTSTAMP:$dtStamp\r\nUID:$uid\r\nEND:VEVENT\r\nEND:VCALENDAR\r\n";
        $fileName = 'event_'.$event->event_date->format('Y-m-d').'.ics';

        return response($icsContent, 200)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');
    }
}
