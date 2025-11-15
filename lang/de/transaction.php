<?php

declare(strict_types=1);

return [
    'edit-text-modal.heading' => 'Buchungstexte ändern',
    'edit-text-modal.label' => 'Label',
    'edit-text-modal.reference' => 'Referenz',
    'edit-text-modal.description' => 'Beschreibung',
    'edit-text-modal.btn.label' => 'Speichern',
    'edit-text-modal.update-success.text' => 'Die Texte wurden erfolgreich aktualisiert',
    'edit-text-modal.update-success.heading' => 'Erfolg!',

    'detach-member-success.text' => 'Die Verknüpfung der Buchung mit dem Mitglied wurde erfolgreich gelöscht',
    'attach-member-success.text' => 'Die Verknüpfung der Buchung mit dem Mitglied wurde erfolgreich erstellt',
    'detach-member-success.heading' => 'Erfolg',
    'attach-member-success.heading' => 'Erfolg',

    'attach-event-success.heading' => 'Erfolg',
    'attach-event-success.text' => 'Die Verknüpfung der Buchung mit der Veranstaltung wurde erfolgreich erstellt',
    'detach-event-success.text' => 'Die Verknüpfung der Buchung mit der Veranstaltung wurde erfolgreich gelöscht',
    'detach-event-success.heading' => 'Erfolg',
    'access.denied' => 'Sie haben keine Berechtigungen Buchungen zu verwalten: ',
    'cancel-transaction-modal.reason.label' => 'Grund für Stornierung angeben',
    'cancel-transaction-modal.reason.error' => 'Es muss eine Begründung für die Stornierung angegegen werden!',
    'cancel-transaction-modal.heading' => 'Buchung stornieren',
    'cancel-transaction-modal.btn.submit.label' => 'Stornieren',
    'index.menu-item.book' => 'Buchen',
    'index.menu-item.edit' => 'Bearbeiten',
    'index.menu-item.cancel' => 'Storno',
    'index.menu-item.edit_text' => 'Texte ändern',
    'index.menu-item.rebook' => 'Umbuchen',
    'index.menu-item.attach_event' => 'Veranstaltung',
    'index.menu-item.attach_member' => 'Mitglied',
    'index.menu-item.detach_event' => 'Veranstaltung',
    'index.menu-item.detach_member' => 'Mitglied',
    'index.table.empty-results' => 'Keine Buchungen gefunden',

    'index.menu-item.send_invoice' => 'E-Mail senden',
    'index.menu-item.print_invoice' => 'Ausdrucken',

    'create' => [
        'page' => [
            'title' => 'Erstellle Buchung',
        ],
    ],

    'account-transfer-modal.btn.submit' => 'durchführen',
    'account-transfer-modal' => '',
    'account-transfer-modal.heading' => 'Umbuchung (Finanzkonto ändern)',
    'account-transfer-modal.content' => 'Die Umbuchung storniert die ausgewählte Buchung und erstellt eine neue Buchung mit einem Bezug zum neuen Finanzkonto',
    'account-transfer-modal.reason' => 'Grund der Umbuchung',
    'account-transfer-modal.new_account' => 'Neues Finanzkonto',
    'account-transfer-modal.error.transaction_id' => 'Es ist keine Buchung ausgewählt worden',
    'account-transfer-modal.error.account_id' => 'Es ist kein Finanzkonto ausgewählt worden',
    'account-transfer-modal.error.identical' => 'Es sollte nicht das ursprüngliche Konto ausgewählt werden',
    'account-transfer-modal.error.reason' => 'Eine Begründung ist zwingend anzugeben!',

    'account.name' => 'Finanzkonto',
    'account.number' => 'Nummer',
    'account.institute' => 'Institut',
    'account.type' => 'Art',
    'account.iban' => 'IBAN',
    'account.bic' => 'BIC',
    'account.starting_amount' => 'Startguthaben',

    'index.title' => 'Übersicht Buchungen',

    'mail.receipt.subject' => 'Quittung über erhaltenen Beitrag',
    'mail.receipt.title' => 'Quittung über erhaltenen Beitrag',
    'mail.receipt.greeting' => '',
    'mail.receipt.header' => 'Übersicht',
    'mail.receipt.body' => 'Vielen Dank für Ihren Beitrag! Im Anhang finden Sie den Quittungsbeleg für Ihre Unterlagen. Bei Fragen gerne auf diese E-Mail antworten.',
    'mail.receipt.date' => 'Zahlung erhalten am:',
    'mail.receipt.amount' => 'Erhaltener Betrag',
    'mail.receipt.label' => 'Verwendungszwecks/Betreff',
    'mail.receipt.reference' => 'Referenz',

    'event' => [
        'boxoffice' => [
            'heading' => 'Abendkasse',
            'paymentsection' => 'Buchungsdaten',
            'visitorsection' => 'Besucherdaten',
            'visitorname' => 'Name',
            'visitoremail' => 'E-Mail',
            'submit' => 'Abendkasse erfassen',
        ],
    ],
    '' => '',
];
