<?php

declare(strict_types=1);

return [
    'index' => [
        'title' => 'Számlaáttekintés',
        'btn' => [
            'fetch_data' => 'Számlaadatok lekérése',
            'create_report' => 'Jelentés készítése',
            'create_vcashcount' => 'Pénzszámlálási lista létrehozása',
        ],
    ],
    'cashcount' => [
        'delete' => [
            'heading' => 'Pénzszámlálási lista törlése',
            'label' => 'Kérem, erősítse meg a(z) :label pénzszámlálási lista törlését',
            'warning' => 'A törlés nem visszavonható!',
            'btn' => [
                'cancel' => 'Mégse',
                'submit' => 'Törlés',
            ],
            'confirmationtoast' => [
                'head' => 'Siker',
                'txt' => 'A pénzszámlálási lista sikeresen törölve lett!',
            ],
        ],
        'create' => [
            'heading' => 'Új pénzszámlálási lista létrehozása',
            'btn' => [
                'submit' => 'Rögzítés',
            ],
        ],
        'edit' => [
            'heading' => 'Pénzszámlálási lista szerkesztése',
            'btn' => [
                'submit' => 'Frissítés',
            ],
        ],
    ],
];
