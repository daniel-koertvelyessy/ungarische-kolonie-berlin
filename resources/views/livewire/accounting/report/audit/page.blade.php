@php use App\Enums\TransactionType; @endphp
<div>
   <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-6">

       <flux:card>
           Übersicht

           <dl class="divide-y divide-zinc-100">
               <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                   <dt class="text-sm/6 font-medium text-zinc-900">Konto</dt>
                   <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{$report->account->name }}</dd>
                   <dt class="text-sm/6 font-medium text-zinc-900">Typ</dt>
                   <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{$report->account->type }}</dd>

                   <dt class="text-sm/6 font-medium text-zinc-900">Start Guthaben</dt>
                   <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ \App\Models\Accounting\Account::formatedAmount($report->starting_amount) }} <span class="text-xs">EUR</span></dd>
               </div>
           </dl>



           <flux:table>
               <flux:table.columns>
                   <flux:table.column>Datum</flux:table.column>
                   <flux:table.column>Buchung</flux:table.column>
                   <flux:table.column>Referenz</flux:table.column>
                   <flux:table.column align="right">Eingang</flux:table.column>
                   <flux:table.column align="right">Ausgang</flux:table.column>
                   <flux:table.column>Typ</flux:table.column>
                   <flux:table.column align="right">Stand</flux:table.column>
               </flux:table.columns>

               <flux:table.rows>
                   <flux:table.row>
                       <flux:table.cell></flux:table.cell>
                       <flux:table.cell>
                           Übernahme aus Vormonat
                       </flux:table.cell>
                       <flux:table.cell></flux:table.cell>
                       <flux:table.cell></flux:table.cell>
                       <flux:table.cell></flux:table.cell>
                       <flux:table.cell></flux:table.cell>

                       <flux:table.cell align="end">{{ \App\Models\Accounting\Account::formatedAmount($report->starting_amount) }}</flux:table.cell>


                   </flux:table.row>
                       @php
    $sub = $report->starting_amount;
           $total_in = 0;
           $total_out = 0;
 @endphp
                   @foreach($transactions as $transaction)
                       @php
                           if ($transaction->type === TransactionType::Deposit->value) {
                              $in = $transaction->amount_gross * TransactionType::calc($transaction->type);
                              $out = 0;
                              $sub += $in;
                              $total_in += $in;
                          } else {
                              $out = $transaction->amount_gross * TransactionType::calc($transaction->type);
                              $in = 0;
                              $sub += $out;
                              $total_out += $out;
                          }
                       @endphp
                   <flux:table.row>
                       <flux:table.cell>{{ $transaction->date->isoFormat('Do MMMM') }}</flux:table.cell>
                       <flux:table.cell>{{ $transaction->label }}</flux:table.cell>
                       <flux:table.cell>{{ $transaction->reference }}</flux:table.cell>
                       <flux:table.cell align="end"><span class="{{ TransactionType::color($transaction->type) }}">{{ \App\Models\Accounting\Account::formatedAmount($in) }}</span></flux:table.cell>
                       <flux:table.cell align="end"><span class="{{ TransactionType::color($transaction->type) }}">{{ \App\Models\Accounting\Account::formatedAmount($out) }}</span></flux:table.cell>
                       <flux:table.cell>{{ $transaction->type }}</flux:table.cell>
                       <flux:table.cell align="end">{{ \App\Models\Accounting\Account::formatedAmount($sub) }}</flux:table.cell>
                   </flux:table.row>
                   @endforeach
               </flux:table.rows>
           </flux:table>


       </flux:card>

       <flux:card>
           freigabe
       </flux:card>

   </section>
</div>
<!--
{"id":1,"created_at":"2025-03-03T14:45:42.000000Z","updated_at":"2025-03-03T14:45:42.000000Z","account_id":1,"starting_amount":15840,"end_amount":82965,"created_by":1,"period_start":"2025-03-01T00:00:00.000000Z","period_end":"2025-03-31T00:00:00.000000Z","total_income":113925,"total_expenditure":46800,"status":"entwurf","notes":null,"account":{"id":1,"name":"Vereinskasse","number":"VK1","type":"Barkasse","institute":"","iban":"","bic":"","starting_amount":15840,"created_at":"2025-03-03T14:35:52.000000Z","updated_at":"2025-03-03T14:35:52.000000Z"}}

{"id":64,"date":"2025-03-01T00:00:00.000000Z","label":"voluptatem-voluptas-quia-quibusdam-est-rerum-sint-nulla","reference":null,"description":null,"amount_gross":97825,"vat":19,"tax":null,"amount_net":7857,"account_id":1,"booking_account_id":null,"type":"Einzahlung","status":"gebucht","created_at":"2025-03-03T14:36:49.000000Z","updated_at":"2025-03-03T14:36:49.000000Z"}
-->
