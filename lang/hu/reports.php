<?php

declare(strict_types=1);

return [
    'event.title' => 'Rendezvényjelentés',
    'event.subject' => ':name rendezvény értékelése',
    'event.visitor.name' => 'Látogató',

    'account' => [
        'title' => 'Pénztárjelentés',
        'timespan' => 'Időszak',
        'heading' => 'Fejlécadatok',
        'start' => 'Kezdete',
        'end' => 'Vége',
        'starting_amount' => 'Kezdő összeg',
        'end_amount' => 'Záró összeg',
        'total_income' => 'Összes bevétel',
        'total_expenditure' => 'Összes kiadás',
        'notes' => 'Megjegyzések',
        'new' => [
            'header' => 'Új jelentés létrehozása',
        ],
        'edit' => [
            'heading' => 'Szerkesztés',
        ],
        'btn' => [
            'get_transactions' => 'Időszak könyvelési tételeinek lekérése',
            'store_data' => 'Adatok mentése',
        ],
    ],

    'table.header.date' => 'Létrehozva',
    'table.header.name' => 'Pénzügyi számla',
    'table.header.status' => 'Állapot',
    'table.header.range' => 'Időszak',
    'table.header.audited' => 'Ellenőrizve',

    'initiate-report-audit-modal.title' => 'Jelentés ellenőrzésének indítása',
    'initiate-report-audit-modal.content' => 'Kérem, válassza ki azokat a tagokat, akik az ellenőrzést végzik.',
    'initiate-report-audit-modal.btn.submit' => 'Meghívók elküldése',
    'initiate-report-audit-modal.select_member_id' => 'Tag',

    'index' => [
        'title' => 'Havi jelentések',
    ],

    'status' => [
        'eingereicht' => 'beküldve',
        'entwurf' => 'tervezet',
        'geprueft' => 'ellenőrizve',
    ],

];
