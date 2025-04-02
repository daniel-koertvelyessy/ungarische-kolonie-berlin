<?php

use App\Livewire\Accounting\Transaction\Index\Page;
use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use Tests\Traits\TranslationTestTrait;

uses(TranslationTestTrait::class);

test('if backend transactions index page component renders correctly', function () {

    // Nutzer erstellen aus Mitglied authentifizieren
    $this->actingAs(Member::factory()->create()->user);

    // Set session value for financial year
    session(['financialYear' => 2025]);

    $transactions = \App\Models\Accounting\Transaction::factory(30)->create([
        'date' => now()->year(2025)->startOfYear(), // Ensure it's within 2025
    ]);

    Livewire::test(Page::class, ['transactionList' => $transactions, 'current_fiscal_year' => 2025])
        ->assertSeeLivewire(Page::class) // Ensures Livewire renders
        ->assertStatus(200)
//        ->assertSee('Keine Buchungen gefunden'); // Assuming pagination is visible
        ->assertSee(Transaction::first()->label); // Check if first transaction is listed
});

test('if backend transaction pagination works correctly', function () {
    $this->actingAs(Member::factory()->create()->user);
    // Nutzer erstellen aus Mitglied authentifizieren
    $this->actingAs(Member::factory()->create()->user);

    // Set session value for financial year
    session(['financialYear' => 2025]);

    $transactions = \App\Models\Accounting\Transaction::factory(30)->create([
        'date' => now()->year(2025)->startOfYear(), // Ensure it's within 2025
    ]);

    Livewire::test(Page::class)
        ->call('gotoPage', 2)
//        ->assertSee(Transaction::skip(10)->first()->label) // Check second page content
        ->assertDontSee(Transaction::first()->label); // First page transaction should not be here
});

test('if backend transaction index page transactions can be searched', function () {

    $this->actingAs(Member::factory()->create()->user);

    // Set session value for financial year
    session(['financialYear' => 2025]);

    $transactions = \App\Models\Accounting\Transaction::factory(30)->create([
        'date' => now()->year(2025)->startOfYear(), // Ensure it's within 2025
    ]);

    $transactions = \App\Models\Accounting\Transaction::factory()->create([
        'date' => now()->year(2025)->startOfYear(),
        'label' => 'Laravel Conference', // Ensure it's within 2025
    ]);
    $transactions = \App\Models\Accounting\Transaction::factory()->create([
        'date' => now()->year(2025)->startOfYear(),
        'label' => 'VueJS Meetup', // Ensure it's within 2025
    ]);

    Livewire::test(Page::class)
        ->set('search', 'Laravel')
        ->assertSee('Laravel Conference')
        ->assertDontSee('VueJS Meetup');
});

test('if all translations are rendered on backend transaction index page', function () {
    $this->actingAs(Member::factory()->create()->user);

    // Nutzer erstellen aus Mitglied authentifizieren
    $this->actingAs(Member::factory()->create()->user);

    // Set session value for financial year
    session(['financialYear' => 2025]);

    $transactions = \App\Models\Accounting\Transaction::factory(30)->create([
        'date' => now()->year(2025)->startOfYear(), // Ensure it's within 2025
    ]);

    $this->assertTranslationsRendered(
        Page::class, [],
        'transaction',
        'transaction.',
    );
});
