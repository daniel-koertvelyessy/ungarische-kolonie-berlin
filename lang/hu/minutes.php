<?php

return [
    'create' => [
        'page_title' => 'Jegyzőkönyv készítése',
        'heading' => 'Új jegyzőkönyv',
        'default_title' => 'Új értekezlet',
        'title' => 'Cím',
        'meeting_date' => 'Értekezlet dátuma',
        'meeting_date_placeholder' => 'Válassz dátumot',
        'location' => 'Helyszín',
        'content' => 'Tartalom',
        'save' => 'Jegyzőkönyv mentése',
        'success' => 'Jegyzőkönyv sikeresen mentve!',
        'btn' => [
            'add_attendee' => 'Résztvevő hozzáadása',
        ],
        'attendees' => [
            'heading' => 'Résztvevők',
        ],
        'empty_attendee_list' => 'Nincsenek résztvevők hozzáadva.',
        'modal' => [
            'add_attendee' => [
                'header' => 'Résztvevő hozzáadása',
                'name' => 'Név',
                'email' => 'E-mail',
                'btn' => 'Hozzáadás',
                'select_member' => 'Tag kiválasztása',
                'no_member' => 'Nincs tag',
            ],
            'add_action_item' => [
                'header' => 'Feladat hozzáadása',
                'description' => 'Leírás',
                'select_assignee' => 'Felelős kiválasztása',
                'no_assignee' => 'Nincs felelős',
                'due_date' => 'Határidő',
                'due_date_placeholder' => 'Válassz határidőt',
                'btn' => 'Hozzáadás',
            ],
        ],
        'topic' => [
            'heading' => 'Témák',
            'add' => 'Téma hozzáadása',
            'placeholder' => 'Add meg a téma tartalmát...',
            'empty_topics_list' => 'Nincsenek témák hozzáadva.',
        ],
        'actionitems' => [
            'heading' => 'Feladatok',
            'add' => 'Feladat hozzáadása',
            'remove' => 'Eltávolítás',
            'empty' => 'Nincsenek feladatok hozzáadva.',
            'no_assignee' => 'Nincs felelős',
        ],
        'validation_error' => [
            'title' => [
                'required' => 'A cím mező kötelező.',
            ],
            'meeting_date' => [
                'required' => 'Az értekezlet dátuma mező kötelező.',
            ],
            'attendees' => [
                'required' => 'Legalább egy résztvevő szükséges.',
                'min' => 'Legalább egy résztvevő szükséges.',
            ],
            'topics' => [
                'required' => 'Legalább egy téma szükséges.',
                'min' => 'Legalább egy téma szükséges.',
            ],
            'actionitems' => [
                'description' => [
                    'required' => 'A feladat leírása kötelező.',
                    'min' => 'A feladat leírásának legalább 3 karakter hosszúnak kell lennie.',
                ],
            ],
        ],
    ],
];
