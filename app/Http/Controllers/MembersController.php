<?php

namespace App\Http\Controllers;

use App\Models\Membership\Member;
use App\Services\PdfGeneratorService;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function printApplication(Member $member, PdfGeneratorService $service) {
        return $service->generateMembershipApplication($member);
    }
}
