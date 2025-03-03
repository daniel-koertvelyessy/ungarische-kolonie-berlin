<?php

namespace App\Services;

use App\Models\Accounting\AccountReport;
use App\Pdfs\AccountReportPdf;

class AccountReportService
{
    public function generate(AccountReport $accountReport)
    {

        $filename = 'Kassenbericht-'.$accountReport->period_start->format('Y-m').'.pdf';

        $pdf = new AccountReportPdf(
            $accountReport,
            app()->getLocale(),
            $filename
        );
        $pdf->generateContent();

        return $pdf->generatePdf($filename);

    }
}
