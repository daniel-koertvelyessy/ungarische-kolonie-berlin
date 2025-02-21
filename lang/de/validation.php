<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted' => 'Das :attribute Feld muss akzeptiert werden.',
    'accepted_if' => 'Das :attribute Feld muss akzeptiert werden, wenn :other :value ist.',
    'active_url' => 'Das :attribute Feld muss eine gültige URL sein.',
    'after' => 'Das :attribute Feld muss ein Datum nach :date sein.',
    'after_or_equal' => 'Das :attribute Feld muss ein Datum nach oder gleich :date sein.',
    'alpha' => 'Das :attribute Feld darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das :attribute Feld darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num' => 'Das :attribute Feld darf nur Buchstaben und Zahlen enthalten.',
    'array' => 'Das :attribute Feld muss ein Array sein.',
    'ascii' => 'Das :attribute Feld darf nur Einzelbyte-Zeichen enthalten. alphanumerische Zeichen und Symbole.',
    'before' => 'Das :attribute Feld muss ein Datum vor :date sein.',
    'before_or_equal' => 'Das :attribute Feld muss ein Datum vor oder gleich :date sein.',
    'between' => [
        'array' => 'Das :attribute Feld muss zwischen :min und :max Elemente enthalten.',
        'file' => 'Das :attribute Feld muss zwischen :min und :max Kilobyte enthalten.',
        'numeric' => 'Das :attribute Feld muss zwischen :min und :max liegen.',
        'string' => 'Das :attribute Feld muss zwischen :min und :max Zeichen enthalten.',
    ],
    'boolean' => 'Das :attribute Feld muss true oder false sein.',
    'can' => 'Das :attribute Feld enthält einen nicht autorisierten Wert.',
    'confirmed' => 'Die Bestätigung des :attribute Felds Übereinstimmung.',
    'contains' => 'Im Feld :attribute fehlt ein erforderlicher Wert.',
    'current_password' => 'Das Passwort ist falsch.',
    'date' => 'Das Feld :attribute muss ein gültiges Datum sein.',
    'date_equals' => 'Das Feld :attribute muss ein Datum sein, das :date entspricht.',
    'date_format' => 'Das Feld :attribute muss dem Format :format entsprechen.',
    'decimal' => 'Das Feld :attribute muss :decimal Dezimalstellen haben.',
    'declined' => 'Das Feld :attribute muss abgelehnt werden.',
    'declined_if' => 'Das Feld :attribute muss abgelehnt werden, wenn :other :value ist.',
    'different' => 'Das Feld :attribute und :other müssen unterschiedlich sein.',
    'digits' => 'Das Feld :attribute muss :digits Ziffern haben.',
    'digits_between' => 'Das :attribute Feld muss zwischen :min und :max Ziffern enthalten.',
    'dimensions' => 'Das :attribute Feld hat ungültige Bildabmessungen.',
    'distinct' => 'Das :attribute Feld hat einen doppelten Wert.',
    'doesnt_end_with' => 'Das :attribute Feld darf nicht mit einem der folgenden enden: :values.',
    'doesnt_start_with' => 'Das :attribute Feld darf nicht mit einem der folgenden beginnen: :values.',
    'email' => 'Das :attribute Feld muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => 'Das :attribute Feld muss mit einem der folgenden enden: :values.',
    'enum' => 'Das ausgewählte :attribute ist ungültig.',
    'exists' => 'Das ausgewählte :attribute ist ungültig.',
    'extensions' => 'Das :attribute Feld muss eine der folgenden Erweiterungen haben: :values.',
    'file' => 'Das :attribute Feld muss eine Datei sein.',
    'filled' => 'Das :attribute Feld muss einen Wert haben.',

    'gt' => [
        'array' => 'Das :attribute Feld muss mehr als :value-Elemente enthalten.',
        'file' => 'Das :attribute Feld muss größer als :value Kilobyte sein.',
        'numeric' => 'Das :attribute Feld muss größer als :value sein.',
        'string' => 'Das :attribute Feld muss größer als :value Zeichen sein.',
    ],
    'gte' => [
        'array' => 'Das :attribute Feld muss :value-Elemente oder mehr enthalten.',
        'file' => 'Das :attribute Feld muss größer oder gleich :value Kilobyte sein.',
        'numeric' => 'Das :attribute Feld muss größer oder gleich :value Kilobyte sein.',
        'string' => 'Das :attribute Feld muss größer oder gleich :value Zeichen sein.',
    ],
    'hex_color' => 'Das :attribute Feld muss eine gültige Hexadezimalzahl sein Farbe.',
    'image' => 'Das :attribute Feld muss ein Bild sein.',
    'in' => 'Das ausgewählte :attribute ist ungültig.',
    'in_array' => 'Das :attribute Feld muss in :other vorhanden sein.',
    'integer' => 'Das :attribute Feld muss eine Ganzzahl sein.',
    'ip' => 'Das :attribute Feld muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Das :attribute Feld muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Das :attribute Feld muss eine gültige IPv6-Adresse sein.',
    'json' => 'Das :attribute Feld muss ein gültiger JSON-String sein.',
    'list' => 'Das :attribute Feld muss eine Liste sein.',
    'lowercase' => 'Das :attribute Feld muss klein geschrieben sein.',
    'lt' => [
        'array' => 'Das :attribute Feld muss weniger als :value haben Elemente.',
        'file' => 'Das :attribute Feld muss kleiner als :value Kilobyte sein.',
        'numeric' => 'Das :attribute Feld muss kleiner als :value sein.',
        'string' => 'Das :attribute Feld muss kleiner als :value Zeichen sein.',
    ],
    'lte' => [
        'array' => 'Das :attribute Feld darf nicht mehr als :value-Elemente haben.',
        'file' => 'Das :attribute Feld muss kleiner oder gleich :value Kilobyte sein.',
        'numeric' => 'Das :attribute Feld muss kleiner oder gleich :value sein.',
        'string' => 'Das :attribute Feld muss kleiner oder gleich :value Zeichen sein.',
    ],
    'mac_address' => 'Das :attribute Feld muss eine gültige MAC-Adresse sein.',
    'max' => [
        'array' => 'Das :attribute Feld darf nicht mehr als :max Elemente.',
        'file' => 'Das :attribute Feld darf nicht größer als :max Kilobyte sein.',
        'numeric' => 'Das :attribute Feld darf nicht größer als :max sein.',
        'string' => 'Das :attribute Feld darf nicht größer als :max Zeichen sein.',
    ],
    'max_digits' => 'Das :attribute Feld darf nicht mehr als :max Ziffern haben.',
    'mimes' => 'Das :attribute Feld muss eine Datei vom Typ: :values sein.',
    'mimetypes' => 'Das :attribute Feld muss eine Datei vom Typ: :values sein.',
    'min' => [
        'array' => 'Das :attribute Feld muss mindestens :min Elemente haben.',
        'file' => 'Das :attribute Feld muss mindestens :min Kilobyte haben.',
        'numeric' => 'Das :attribute Feld muss mindestens :min Kilobyte haben.',
        'string' => 'Das :attribute Feld muss mindestens :min Zeichen haben.',
    ],
    'min_digits' => 'Das :attribute Feld muss mindestens :min Ziffern haben.',
    'missing' => 'Das :attribute Feld muss fehlen.',
    'missing_if' => 'Das :attribute Feld muss fehlen, wenn :other :value ist.',
    'missing_unless' => 'Das :attribute Feld muss fehlen, es sei denn, :other ist :value.',
    'missing_with' => 'Das :attribute Feld muss fehlen, wenn :values vorhanden ist.',
    'missing_with_all' => 'Das :attribute Feld muss fehlen, wenn :values vorhanden sind.',
    'multiple_of' => 'Das :attribute Feld muss ein Vielfaches von :value sein.',
    'not_in' => 'Das ausgewählte :attribute ist ungültig.',
    'not_regex' => 'Das :attribute Feldformat ist ungültig.',
    'numeric' => 'Das :attribute Feld muss eine Zahl sein.',
    'password' => [
        'letters' => 'Das :attribute Feld muss mindestens einen Buchstaben enthalten.',
        'mixed' => 'Das :attribute Feld muss mindestens einen Groß- und einen Kleinbuchstaben enthalten.',
        'numbers' => 'Das :attribute Feld muss mindestens eine Zahl enthalten.',
        'symbols' => 'Das :attribute Feld muss mindestens ein Symbol enthalten.',
        'uncompromised' => 'Das angegebene :attribute ist in einem Datenleck aufgetaucht. Bitte wählen Sie ein anderes :attribute.',
    ],

    'present' => 'Das Feld :attribute muss vorhanden sein.',
    'present_if' => 'Das Feld :attribute muss vorhanden sein, wenn :other :value ist.',
    'present_unless' => 'Das Feld :attribute muss vorhanden sein, es sei denn, :other ist :value.',
    'present_with' => 'Das Feld :attribute muss vorhanden sein, wenn :values vorhanden ist.',
    'present_with_all' => 'Das Feld :attribute muss vorhanden sein, wenn :values vorhanden sind.',
    'prohibited' => 'Das Feld :attribute ist verboten.',
    'prohibited_if' => 'Das Feld :attribute ist verboten, wenn :other :value ist.',
    'prohibited_unless' => 'Das Feld :attribute ist verboten, es sei denn, :other ist in :values.',
    'prohibits' => 'Das Feld :attribute verhindert, dass :other vorhanden ist.',
    'regex' => 'Das :attribute Feldformat ist ungültig.',
    'required' => 'Das :attribute Feld ist erforderlich.',
    'required_array_keys' => 'Das :attribute Feld muss Einträge für: :values enthalten.',
    'required_if' => 'Das :attribute Feld ist erforderlich, wenn :other :value ist.',
    'required_if_accepted' => 'Das :attribute Feld ist erforderlich, wenn :other akzeptiert wird.',
    'required_if_declined' => 'Das :attribute Feld ist erforderlich, wenn :other abgelehnt wird.',
    'required_unless' => 'Das :attribute Feld ist erforderlich, sofern :other nicht in :values enthalten ist.',
    'required_with' => 'Das :attribute Feld ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all' => 'Das :attribute Feld ist erforderlich, wenn :values vorhanden sind.',
    'required_without' => 'Das :attribute Feld ist erforderlich, wenn :values ist nicht vorhanden.',
    'required_without_all' => 'Das :attribute Feld ist erforderlich, wenn keines der :values vorhanden ist.',
    'same' => 'Das :attribute Feld muss mit :other übereinstimmen.',
    'size' => [
        'array' => 'Das :attribute Feld muss :size-Elemente enthalten.',
        'file' => 'Das :attribute Feld muss :size Kilobytes enthalten.',
        'numeric' => 'Das :attribute Feld muss :size sein.',
        'string' => 'Das :attribute Feld muss :size Zeichen enthalten.',
    ],
    'starts_with' => 'Das :attribute Feld muss mit einem der folgenden beginnen: :values.',
    'string' => 'Das :attribute Feld muss ein String sein.',
    'timezone' => 'Das :attribute Feld muss eine gültige Zeitzone sein.',
    'unique' => 'Das :attribute wurde bereits übernommen.',
    'uploaded' => 'Das :attribute konnte nicht hochgeladen werden.',
    'uppercase' => 'Das :attribute Feld muss in Großbuchstaben geschrieben sein.',
    'url' => 'Das :attribute Feld muss eine gültige URL sein.',
    'ulid' => 'Das :attribute Feld muss eine gültige ULID sein.',
    'uuid' => 'Das :attribute Feld muss eine gültige UUID sein.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
