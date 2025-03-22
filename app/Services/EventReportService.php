<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Event\Event;
use App\Models\Event\EventTransaction;
use App\Models\Event\EventVisitor;
use App\Pdfs\EventReportPdf;

class EventReportService
{
    public function generate(Event $event): string
    {
        $ets = EventTransaction::query()->with('transaction')->where('event_id', $event->id)->get();

        $income = 0;
        $spending = 0;

        $spendings = EventTransaction::query()->with('transaction.account')
            ->where('event_id', $event->id)
            ->whereHas('transaction', fn ($query) => $query->where('type', TransactionType::Withdrawal->value))
            ->get();

        $incomes = EventTransaction::query()->with('transaction')
            ->where('event_id', $event->id)
            ->whereHas('transaction', fn ($query) => $query->where('type', TransactionType::Deposit->value))
            ->get();

        foreach ($ets as $et) {
            if ($et->transaction->type === TransactionType::Deposit->value) {
                $income += $et->transaction->amount_gross;
            }
            if ($et->transaction->type === TransactionType::Withdrawal->value) {
                $spending += $et->transaction->amount_gross;
            }
        }

        $visitors = EventVisitor::all();

        $filename = 'event-report-'.$event->title['de'].'.pdf';
        $pdf = new EventReportPdf(
            $event,
            $income / 100,
            $incomes,
            $spending / 100,
            $spendings,
            $visitors,
            app()->getLocale(),
            $filename
        );
        $pdf->generateContent();

        return $pdf->generatePdf($filename);
    }
}
