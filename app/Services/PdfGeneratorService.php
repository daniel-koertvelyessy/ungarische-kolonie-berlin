<?php

namespace App\Services;

use App\Models\Accounting\AccountReport;
use App\Models\Accounting\Transaction;
use App\Models\Event\Event;
use App\Models\Event\EventTransaction;
use App\Models\Event\EventVisitor;
use App\Models\Membership\Member;
use App\Pdfs\AccountReportPdf;
use App\Pdfs\EventReportPdf;
use App\Pdfs\MemberApplicationPdf;
use App\Pdfs\TransactionInvoicePdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use TCPDF;

class PdfGeneratorService
{
    /**
     * Generate a PDF based on type and data.
     *
     * @throws Exception
     */
    public static function generatePdf(string $type, mixed $data, ?string $filename = null, bool $restricted = false, ?string $locale = null): string
    {
        if ($restricted && ! Auth::check()) {
            throw new Exception('Authentication required to generate this PDF.');
        }

        $locale = $locale ?? app()->getLocale();

        return match ($type) {
            'member-application' => self::generateMemberApplicationPdf($data, $filename, $locale),
            'event-report' => self::generateEventReportPdf($data, $filename, $locale),
            'account-report' => self::generateAccountReportPdf($data, $filename, $locale),
            'invoice' => self::generateInvoicePdf($data['transaction'], $data['member'], $filename, $locale),
            default => throw new Exception("Unknown PDF type: $type"),
        };
    }

    private static function generateMemberApplicationPdf(Member $member, ?string $filename, string $locale): string
    {
        $filename = $filename ?? "mitgliedsantrag-{$member->id}-".now()->format('Ymd').'.pdf';
        $pdf = new MemberApplicationPdf($member, 'Mitgliedsantrag', $locale);
        $pdf->generateContent();

        return $pdf->Output($filename, 'S');
    }

    private static function generateEventReportPdf(Event $event, ?string $filename, string $locale): string
    {
        $ets = EventTransaction::query()->with('transaction')->where('event_id', $event->id)->get();
        $total_income = $ets->where('transaction.type', 'deposit')->sum('transaction.amount_gross') / 100;
        $total_spending = $ets->where('transaction.type', 'withdrawal')->sum('transaction.amount_gross') / 100;
        $incomes = $ets->where('transaction.type', 'deposit');
        $spending = $ets->where('transaction.type', 'withdrawal');
        $visitors = EventVisitor::all();

        $filename = $filename ?? "event-report-{$event->title[$locale]}-".now()->format('Ymd').'.pdf';
        $pdf = new EventReportPdf($event, $total_income, $incomes, $total_spending, $spending, $visitors, $locale, $filename);
        $pdf->generateContent();

        return $pdf->Output($filename, 'S');
    }

    private static function generateAccountReportPdf(AccountReport $accountReport, ?string $filename, string $locale): string
    {
        $dateString = Carbon::createFromTimeString($accountReport->period_start)->format('Y-m');
        $filename = $filename ?? "Kassenbericht-{$dateString}.pdf";
        $pdf = new AccountReportPdf($accountReport, $locale, $filename);
        $pdf->generateContent();

        return $pdf->Output($filename, 'S');
    }

    private static function generateInvoicePdf(Transaction $transaction, ?Member $member, ?string $filename, string $locale): string
    {
        $filename = $filename ?? "Rechnung-{$transaction->id}.pdf";
        $pdf = new TransactionInvoicePdf($transaction, $member, $locale);
        //        Log::debug('Starting PDF generation for transaction ' . $transaction->id);
        $pdf->generateContent();
        //        Log::debug('Content generated for transaction ' . $transaction->id);
        $pdfContent = $pdf->Output($filename, 'S');

        //        Log::debug('PDF content length: ' . strlen($pdfContent));
        return $pdfContent;
    }

    public static function generateMembershipApplication(Member $member): RedirectResponse
    {
        //        $html = view('pdf.membership-application', ['member' => $member])->render();
        //        $filename = __('members.apply.print.filename', ['tm' => date('YmdHis'), 'id' => $member->id]);
        //
        //        $pdf = new TCPDF;
        //        $pdf->SetTitle(__('members.apply.print.title'));
        //        $pdf->SetSubject(__('members.apply.print.title'));
        //        $pdf->setMargins(24, 10, 10);
        //        $pdf->setPrintHeader(false);
        //        $pdf->setPrintFooter(false);
        //        $pdf->AddPage();
        //        $pdf->writeHTML($html, true, false, true, false, '');
        //        $pdf->Output($filename, 'D');

        return redirect()->route('home'); // Optional, depending on desired behavior
    }
}
