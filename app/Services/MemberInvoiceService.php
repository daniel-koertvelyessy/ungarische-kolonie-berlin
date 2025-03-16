<?php

namespace App\Services;

use App\Models\Accounting\AccountReport;
use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use App\Pdfs\AccountReportPdf;
use App\Pdfs\TransactionInvoicePdf;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MemberInvoiceService
{
    public function generate(Transaction $transaction, ?Member $member = null, string $locale = 'de'): string
    {
        $filename = 'Rechnung-' . $transaction->id . '.pdf';

        $pdf = new TransactionInvoicePdf($transaction, $member, $locale);
        \Log::debug('Starting PDF generation for transaction ' . $transaction->id);
        $pdf->generateContent();
        \Log::debug('Content generated for transaction ' . $transaction->id);

        $pdfContent = $pdf->Output($filename, 'S'); // 'S' to get as string
        \Log::debug('PDF content length: ' . strlen($pdfContent));

        return $pdfContent;
    }
}
