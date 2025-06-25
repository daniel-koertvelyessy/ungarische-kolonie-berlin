<?php

use App\Models\Accounting\AccountReport;
use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use App\Models\User;
use App\Services\PdfGeneratorService;

test('member application pdf can be generated', function () {
    $member = Member::factory()
        ->create([
            'first_name' => 'Janos',
            'name' => 'Kovacs',
            'email' => 'janos@example.com',
        ]);
    ob_start();
    $pdfContent = PdfGeneratorService::generatePdf('member-application', $member);
    ob_end_clean();
    expect($pdfContent)
        ->toBeString()
        ->toStartWith('%PDF-')
        ->and(strlen($pdfContent))
        ->toBeGreaterThan(1000); // Reasonable size
});

test('invoice pdf generation requires authentication', function () {
    $transaction = Transaction::factory()
        ->create(['amount_gross' => 10000]);
    $user = User::factory()->create(['email_verified_at' => now()]);
    $member = Member::factory()->withUser()->create(['user_id' => $user->id]);

    // Without auth
    expect(fn () => PdfGeneratorService::generatePdf('invoice', ['transaction' => $transaction, 'member' => $member], null, true))
        ->toThrow(\Exception::class, 'Authentication required to generate this PDF.');

    $this->actingAs($user);

    ob_start();
    $pdfContent = PdfGeneratorService::generatePdf('invoice', ['transaction' => $transaction, 'member' => $member], null, true);
    ob_end_clean();
    expect($pdfContent)
        ->toBeString()
        ->toStartWith('%PDF-')
        ->and(strlen($pdfContent))
        ->toBeGreaterThan(1000);
});

test('event report pdf can be generated', function () {
    $event = \App\Models\Event\Event::factory()
        ->create();
    $user = User::factory()->create(['email_verified_at' => now()]);
    $member = Member::factory()->withUser()->create(['user_id' => $user->id]);
    $this->actingAs($user);
    ob_start();
    $pdfContent = PdfGeneratorService::generatePdf('event-report', $event, null, true);
    ob_end_clean();
    expect($pdfContent)
        ->toBeString()
        ->toStartWith('%PDF-')
        ->and(strlen($pdfContent))
        ->toBeGreaterThan(1000);
});

test('account report pdf can be generated', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);
    $member = Member::factory()->withUser()->create(['user_id' => $user->id]);
    $this->actingAs($user);

    $report = AccountReport::factory()
        ->create(['period_start' => now(), 'created_by' => $member->user->id]);

    // Auth for restricted
    ob_start();
    $pdfContent = PdfGeneratorService::generatePdf('account-report', $report, null, true);
    ob_end_clean();
    expect($pdfContent)
        ->toBeString()
        ->toStartWith('%PDF-')
        ->and(strlen($pdfContent))
        ->toBeGreaterThan(1000);
});
