<?php

namespace App\Http\Controllers;

use App\Models\Event\EventSubscription;
use App\Models\Membership\Member;
use App\Services\PdfGeneratorService;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function impressum() {
        return view('impressum');
    }

    public function aboutUs() {
        return view('about-us');
    }

}
