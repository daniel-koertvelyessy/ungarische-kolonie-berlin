<?php

return [
    'event' => [
        'title' => 'Esemény',
        'title_plural' => 'Események',
        'no_events' => 'Még nincsenek események.',
        'add_event' => 'Adj hozzá új eseményt',
        'edit_event' => 'Esemény szerkesztése',
        'delete_event' => 'Esemény törlése',
        'event_details' => 'Esemény részletei',
        'event_created' => 'Sikeresen létrehoztad az eseményt.',
        'event_updated' => 'Az eseményt frissítetted.',
        'event_deleted' => 'Az eseményt törölted.',
        'are_you_sure_delete' => 'Biztos vagy benne, hogy törölni szeretnéd ezt az eseményt?',
        'name' => 'Esemény neve',
        'description' => 'Leírás',
        'start_date' => 'Kezdés dátuma',
        'end_date' => 'Befejezés dátuma',
        'location' => 'Helyszín',
        'organizer' => 'Szervező',
        'participants' => 'Résztvevők',
        'add_participant' => 'Vegyél fel egy résztvevőt',
        'email_participants' => 'Küldj e-mailt a résztvevőknek',
    ],

    'validation' => [
        'name_required' => 'Add meg az esemény nevét!',
        'start_date_required' => 'Mikor kezdődik? Ez kötelező!',
        'end_date_required' => 'Meddig tart? Ez is fontos!',
        'location_required' => 'Írd be a helyszínt!',
    ],

    'actions' => [
        'save' => 'Mentés',
        'cancel' => 'Mégse',
        'back' => 'Vissza',
        'delete' => 'Törlés',
        'edit' => 'Szerkesztés',
    ],

    'participants' => [
        'title' => 'Résztvevők',
        'name' => 'Név',
        'email' => 'E-mail cím',
        'guests' => 'Vendégek száma',
        'add_guest' => 'Hozzáadsz vendéget?',
        'no_participants' => 'Még nincs senki jelentkezve.',
        'participant_added' => 'Sikeresen feliratkoztál!',
        'participant_removed' => 'Töröltük a jelentkezést.',
        'confirm_remove' => 'Biztos, hogy törölni szeretnéd ezt a résztvevőt?',
    ],

    'emails' => [
        'subject_confirmation' => 'Köszi a jelentkezést – erősítsd meg!',
        'greeting' => 'Szia :name!',
        'confirmation_text' => 'Köszi, hogy jelentkeztél a(z) ":event" eseményre. Kérlek, kattints az alábbi gombra, hogy megerősítsd a részvételed:',
        'confirm_button' => 'Jelentkezés megerősítése',
        'thanks' => 'Köszi!',
        'team' => 'A(z) :app csapata',
    ],

    'confirmed' => [
        'title' => 'Köszi, megerősítetted!',
        'text' => 'A jelentkezésed él! Találkozunk az eseményen!',
    ],

    'not_found' => [
        'title' => 'Hoppá, nem találjuk.',
        'text' => 'Ez az esemény nem létezik, vagy már törölték.',
    ],
];
