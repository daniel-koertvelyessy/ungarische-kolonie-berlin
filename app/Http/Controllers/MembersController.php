<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Membership\Member;
use App\Services\PdfGeneratorService;
use Exception;

final class MembersController extends Controller
{
    /**
     * @throws Exception
     */
    public function printApplication(Member $member): \Illuminate\Http\Response
    {
        $pdfContent = PdfGeneratorService::generatePdf('member-application', $member, null, false);

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"mitgliedsantrag-{$member->id}-".now()->format('Ymd').'.pdf"');
    }
}
