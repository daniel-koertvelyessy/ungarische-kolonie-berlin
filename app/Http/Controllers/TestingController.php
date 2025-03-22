<?php

namespace App\Http\Controllers;

use App\Models\Membership\Member;

class TestingController extends Controller
{
    /**
     * Temporary route for testing email template rendering.
     * TODO: Remove after testing is complete.
     */
    public function mailTest(): \Illuminate\View\View
    {
        app()->setLocale('hu');

        return view('emails.invitation', ['member' => Member::find(1)]);
    }
}
