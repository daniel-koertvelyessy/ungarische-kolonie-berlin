<?php

use App\Http\Controllers\RegisterController;
use App\Mail\SendMemberMassMail;
use App\Models\Accounting\Transaction;
use App\Models\Event\Event;
use App\Services\EventReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\App\Home\Page::class)->name('home');

Route::get('/lang/{locale}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/imprint', [\App\Http\Controllers\StaticController::class, 'imprint'])->name('imprint');

Route::get('/about-us', [\App\Http\Controllers\StaticController::class, 'aboutUs'])->name('about-us');

Route::get('/mailing-list/unsubscribe/{token}', \App\Livewire\App\Global\Mailinglist\Unsubscribe::class)->name('mailing-list.unsubscribe');

Route::get('/mailing-list/{token}', \App\Livewire\App\Global\Mailinglist\Show::class)->name('mailing-list.show');

Route::get('/rollback-email', [\App\Http\Controllers\StaticController::class, 'rollbackMail'])->name('rollback-email');

Route::prefix('members')->name('members.')->group(function () {
    Route::get('/application', \App\Livewire\Member\Apply\Page::class)
        ->name('application');

    Route::get('/print-member-application/{member}', [\App\Http\Controllers\MembersController::class, 'printApplication'])
        ->name('print_application');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

    Route::post('/register', [RegisterController::class, 'create']);

});

Route::prefix('events')->name('events.')->group(function () {

    Route::get('/subscription/confirm/{eventSubscription}/{token}', [\App\Http\Controllers\EventController::class, 'confirmSubscription'])->name('subscription.confirm');

    Route::get('/', [\App\Http\Controllers\EventController::class, 'index'])->name('index');

    Route::get('/{slug}', [\App\Http\Controllers\EventController::class, 'show'])->name('show');

    Route::get('/ics/{slug}', [\App\Http\Controllers\EventController::class, 'generateIcs'])->name('ics');

});

Route::prefix('posts')->name('posts.')->group(function () {

    Route::get('/', [\App\Http\Controllers\PostController::class, 'index'])->name('index');

    Route::get('/{slug}', [\App\Http\Controllers\PostController::class, 'show'])->name('show');

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('backend')
    ->group(function () {

        Route::get('/tools', \App\Livewire\App\Tool\Index\Page::class)
            ->name('tools.index');

        Route::get('/members', \App\Livewire\Member\Index\Page::class)
            ->name('members.index');

        Route::get('/members/{member}', \App\Livewire\Member\Show\Page::class)
            ->name('members.show');

        Route::get('/members-create', \App\Livewire\Member\Create\Page::class)
            ->name('members.create');

        Route::get('/members-import', \App\Livewire\Member\Import\Page::class)
            ->name('members.import');

        Route::get('/events', \App\Livewire\Event\Index\Page::class)
            ->name('backend.events.index');

        Route::get('/events/create', \App\Livewire\Event\Create\Page::class)
            ->name('backend.events.create');

        Route::get('/events/{event}', \App\Livewire\Event\Show\Page::class)
            ->name('backend.events.show');

        Route::get('/events/report/{event}', function (Event $event, EventReportService $reportService) {
            return $reportService->generate($event);
        })->name('backend.events.report');

        Route::get('/posts', \App\Livewire\Blog\Post\Index\Page::class)
            ->name('backend.posts.index');

        Route::get('/posts/create', \App\Livewire\Blog\Post\Create\Page::class)
            ->name('backend.posts.create');

        Route::get('/posts/{post}', \App\Livewire\Blog\Post\Show\Page::class)
            ->name('backend.posts.show');

        Route::get('/accounting', \App\Livewire\Accounting\Index\Page::class)
            ->name('accounting.index');

        Route::get('/transaction', \App\Livewire\Accounting\Transaction\Create\Page::class)
            ->name('transaction.create');

        Route::get('/transactions', \App\Livewire\Accounting\Transaction\Index\Page::class)
            ->name('transaction.index');

        Route::get('/account-report', \App\Livewire\Accounting\Report\Index\Page::class)
            ->name('accounts.report.index');

        Route::get('/account-report/print/{account_report}', function (\App\Models\Accounting\AccountReport $accountReport, \App\Services\AccountReportService $reportService) {
            return $reportService->generate($accountReport);
        })->name('accounts.report.print');

        Route::get('/transaction/invoice/preview/{transaction}', function (Transaction $transaction, \App\Services\MemberInvoiceService $invoiceService) {
            $member = $transaction->member_transaction->member ?? null;
            $pdfContent = $invoiceService->generate($transaction, $member, app()->getLocale());

            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="Rechnung_'.$transaction->id.'.pdf"');
        })->name('transaction.invoice.preview');

        Route::get('/account-report/audit/{account_report_audit}', function (\App\Models\Accounting\AccountReportAudit $accountReportAudit) {
            if (Auth::user()->id === $accountReportAudit->user_id) {
                return view('accounts.reports.audit', [
                    'accountReportAuditId' => $accountReportAudit->id,
                ]);
            } else {
                return redirect()->route('accounts.report.index');
            }
        })->name('account-report.audit');

        Route::get('/accounts', \App\Livewire\Accounting\Account\Index\Page::class)
            ->name('accounts.index');

        Route::get('/receipts', \App\Livewire\Accounting\Receipt\Index\Page::class)
            ->name('receipts.index');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/test-mail-preview', function () {
            $mailable = new SendMemberMassMail(
                'Daniel',
                request('subject'),
                request('message'),
                request('locale'),
                request('url'),
                request('url_label'),
                []
            );

            return $mailable->render();
        })->name('test-mail-preview');

        Route::get('/secure-image/{filename}', function (Request $request, $filename) {

            abort_unless(auth()->check(), 403);

            $path = storage_path("app/private/accounting/receipts/previews/{$filename}.png");

            abort_unless(Storage::disk('local')->exists($path), 404);

            return response()->file($path, ['Content-Type' => 'image/png']);

        });

    }); // End middleware auth, jetstream, verified, group

/**
 *   Routes for testing, subject to future deletion
 */
if (app()->isLocal()) {
    Route::get('/mailer-test', [\App\Http\Controllers\TestingController::class, 'mailTest'])
        ->name('mail-tester');
}
