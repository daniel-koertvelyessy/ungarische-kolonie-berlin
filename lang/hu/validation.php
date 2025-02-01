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


    'accepted'             => 'Az :attribute mezőt el kell fogadni.',
    'accepted_if'          => 'Az :attribute mezőt el kell fogadni, ha az :other a :value.',
    'active_url'           => 'Az :attribute mezőnek érvényes URL-nek kell lennie.',
    'after'                => 'Az :attribute mezőnek a :date utáni dátumnak kell lennie.',
    'after_or_equal'       => 'Az :attribute mezőnek a :date utáni vagy azzal egyenlő dátumnak kell lennie.',
    'alpha'                => 'Az :attribute mező csak betűket tartalmazhat.',
    'alpha_dash'           => 'Az :attribute mező csak betűket, számokat, kötőjeleket és aláhúzásjeleket tartalmazhat.',
    'alpha_num'            => 'Az :attribute mező csak betűket és számokat tartalmazhat.',
    'array'                => 'Az :attribute mezőnek tömbnek kell lennie.',
    'ascii'                => 'Az :attribute mező csak egybájtos karaktereket tartalmazhat. alfanumerikus karakterek és szimbólumok.',
    'before'               => 'Az :attribute mezőnek a :date előtti dátumnak kell lennie.',
    'before_or_equal'      => 'Az :attribute mezőnek a :date előtti vagy azzal egyenlő dátumnak kell lennie.',
    'között'               => [
        'array'   => 'Az :attribute mezőnek :min és :max közötti elemeket kell tartalmaznia.',
        'file'    => 'Az :attribute mezőnek :min és :max kilobyte között kell lennie.',
        'numeric' => 'Az :attribute mezőnek :min és :max között kell lennie.',
        'string'  => 'Az :attribute mezőnek :min és :max közötti karaktereket kell tartalmaznia.',
    ],
    'boolean'              => 'Az :attribute mezőnek igaznak vagy hamisnak kell lennie.',
    'can'                  => 'Az :attribute mező nem engedélyezett értéket tartalmaz.',
    'confirmed'            => 'Az :attribute mező egyezésének megerősítése.',
    'contains'             => 'Hiányzik egy kötelező érték az :attribute mezőből.',
    'current_password'     => 'A jelszó helytelen.',
    'date'                 => 'Az :attribute mezőnek érvényes dátumnak kell lennie.',
    'date_equals'          => 'Az :attribute mezőnek dátumnak kell lennie, amely egyenlő a következővel: :date.',
    'date_format'          => 'Az :attribute mezőnek meg kell felelnie a :format formátumnak.',
    'decimal'              => 'Az :attribute mezőben :decimal tizedesjegyek kell, hogy legyenek.',
    'declined'             => 'Az :attribute mezőt el kell utasítani.',
    'declined_if'          => 'Az :attribute mezőt el kell utasítani, ha az :other értéke :value.',
    'different'            => 'Az :attribute és az :other mezőnek különböznie kell.',
    'digits'               => 'Az :attribute mezőnek :digits számjegyeket kell tartalmaznia.',
    'digits_between'       => 'Az :attribute mezőnek :min és :max közötti számjegyeket kell tartalmaznia.',
    'dimensions'           => 'Az :attribute mező képméretei érvénytelenek.',
    'distinct'             => 'Az :attribute mező értéke duplikált.',
    'doesnt_end_with'      => 'Az :attribute mező nem végződhet a következők egyikével: :values.',
    'doesnt_start_with'    => 'Az :attribute mező nem kezdődhet a következők egyikével: :values.',
    'email'                => 'Az :attribute mezőnek érvényes e-mail címnek kell lennie.',
    'ends_with'            => 'Az :attribute mezőnek a következők valamelyikével kell végződnie: :values.',
    'enum'                 => 'A kiválasztott :attribute érvénytelen.',
    'exists'               => 'A kiválasztott :attribute érvénytelen.',
    'extensions'           => 'Az :attribute mezőnek a következő kiterjesztések egyikével kell rendelkeznie: :values.',
    'file'                 => 'Az :attribute mezőnek fájlnak kell lennie.',
    'filled'               => 'Az :attribute mezőnek értékkel kell rendelkeznie.',
    'gt'                   => [
        'array'   => 'Az :attribute mezőnek több mint :value elemet kell tartalmaznia.',
        'file'    => 'Az :attribute mezőnek nagyobbnak kell lennie, mint :value kilobyte.',
        'numeric' => 'Az :attribute mezőnek nagyobbnak kell lennie, mint :value kilobyte.',
        'string'  => 'Az :attribute mezőnek nagyobbnak kell lennie, mint :value karakter.',
    ],
    'gte'                  => [
        'array'   => 'Az :attribute mezőnek legalább :value elemet kell tartalmaznia.',
        'file'    => 'Az :attribute mezőnek nagyobbnak vagy egyenlőnek kell lennie, mint :value kilobyte.',
        'numeric' => 'Az :attribute mezőnek nagyobbnak vagy egyenlőnek kell lennie, mint :value.',
        'string'  => 'Az :attribute mezőnek nagyobbnak vagy egyenlőnek kell lennie, mint :value karakter.',
    ],
    'hex_color'            => 'Az :attribute mezőnek érvényes hexadecimális színnek kell lennie.',
    'image'                => 'Az :attribute mezőnek képnek kell lennie.',
    'in'                   => 'A kiválasztott :attribute érvénytelen.',
    'in_array'             => 'Az :attribute mezőnek jelen kell lennie az :otherben.',
    'integer'              => 'Az :attribute mezőnek egész számnak kell lennie.',
    'ip'                   => 'Az :attribute mezőnek érvényes IP-címnek kell lennie.',
    'ipv4'                 => 'Az :attribute mezőnek érvényes IPv4-címnek kell lennie.',
    'ipv6'                 => 'Az :attribute mezőnek érvényes IPv6-címnek kell lennie.',
    'json'                 => 'Az :attribute mezőnek érvényes JSON karakterláncnak kell lennie.',
    'list'                 => 'Az :attribute mezőnek listának kell lennie.',
    'lowercase'            => 'Az :attribute mezőnek kisbetűnek kell lennie.',
    'lt'                   => [
        'array'   => 'Az :attribute mezőnek kevesebb, mint :value elemet kell tartalmaznia.',
        'file'    => 'Az :attribute mezőnek kevesebb, mint :value kilobyte-ot kell tartalmaznia.',
        'numeric' => 'Az :attribute mezőnek kevesebb, mint :value kilobyte-ot kell tartalmaznia.',
        'string'  => 'Az :attribute mezőnek kevesebb, mint :value karaktert kell tartalmaznia.',
    ],
    'lte'                  => [
        'array'   => 'Az :attribute mező legfeljebb :value elemet tartalmazhat.',
        'file'    => 'Az :attribute mezőnek legfeljebb :value kilobyte-ot kell tartalmaznia.',
        'numeric' => 'Az :attribute mezőnek legfeljebb :value kilobyte-ot kell tartalmaznia.',
        'string'  => 'Az :attribute mezőnek legfeljebb :value karaktert kell tartalmaznia.',
    ],
    'mac_address'          => 'Az :attribute mezőnek érvényes MAC-címnek kell lennie.',
    'max'                  => [
        'array'   => 'Az :attribute mező legfeljebb :max elemet tartalmazhat.',
        'file'    => 'Az :attribute mező nem lehet nagyobb, mint :max kilobyte.',
        'numeric' => 'Az :attribute mező nem lehet nagyobb, mint :max.',
        'string'  => 'Az :attribute mező nem lehet nagyobb :max karakternél.',
    ],
    'max_digits'           => 'Az :attribute mező nem tartalmazhat több mint :max számjegyet.',
    'mimes'                => 'Az :attribute mezőnek egy :values típusú fájlnak kell lennie.',
    'mimetypes'            => 'Az :attribute mezőnek egy :values típusú fájlnak kell lennie.',
    'min'                  => [
        'array'   => 'Az :attribute mezőnek legalább :min elemet kell tartalmaznia.',
        'file'    => 'Az :attribute mezőnek legalább :min értékűnek kell lennie. Kilobyte.',
        'numeric' => 'Az :attribute mezőnek legalább :min értékűnek kell lennie.',
        'string'  => 'Az :attribute mezőnek legalább :min értékűnek kell lennie. vannak jelei.',
    ],
    'min_digits'           => 'Az :attribute mezőnek legalább :min értéket kell tartalmaznia. számjegyei vannak.',
    'missing'              => 'A :attribute mezőnek hiányoznia kell.',
    'missing_if'           => 'A :attribute mezőnek hiányoznia kell, ha az :other a :value.',
    'missing_unless'       => 'Az :attribute mezőnek hiányoznia kell, hacsak az :other nem :value.',
    'missing_with'         => 'A :attribute mezőnek hiányoznia kell, ha a :values jelen van.',
    'missing_with_all'     => 'A :attribute mezőnek hiányoznia kell, ha a :values vannak jelen.',
    'multiple_of'          => 'Az :attribute mezőnek a :value többszörösének kell lennie.',
    'not_in'               => 'A kiválasztott :attribute érvénytelen.',
    'not_regex'            => 'Az :attribute mező formátuma érvénytelen.',
    'numeric'              => 'Az :attribute mezőnek számnak kell lennie.',
    'password'             => [
        'letters'       => 'Az :attribute mezőnek legalább egy betűt kell tartalmaznia.',
        'mixed'         => 'Az :attribute mezőnek tartalmaznia kell legalább egy nagybetűt és egy kisbetűt.',
        'numbers'       => 'Az :attribute mezőnek legalább egy számot kell tartalmaznia.',
        'symbols'       => 'Az :attribute mezőnek legalább egy szimbólumot kell tartalmaznia.',
        'uncompromised' => 'A megadott :attribute adatszivárgásban található. Kérjük, válasszon másik :attribute.',
    ],
    'present'              => 'Az :attribute mezőnek jelen kell lennie.',
    'present_if'           => 'Az :attribute mezőnek jelen kell lennie, ha az :other a :value.',
    'present_unless'       => 'Az :attribute mezőnek jelen kell lennie, hacsak az :other nem :value.',
    'present_with'         => 'A :attribute mezőnek jelen kell lennie, ha a :values jelen van.',
    'present_with_all'     => 'A :attribute mezőnek jelen kell lennie, ha a :values vannak jelen.',
    'prohibited'           => 'Az :attribute mező tiltott.',
    'prohibited_if'        => 'Az :attribute mező tiltott, ha az :other a :value.',
    'prohibited_unless'    => 'Az :attribute mező tilos, hacsak az :other nincs a :values-ben.',
    'prohibits'            => 'Az :attribute mező megtiltja, hogy az :other jelen legyen.',
    'regex'                => 'Az :attribute mező formátuma érvénytelen.',
    'required'             => 'Az :attribute mező kitöltése kötelező.',
    'required_array_keys'  => 'Az :attribute mezőnek tartalmaznia kell a következő bejegyzéseket: :values.',
    'required_if'          => 'Az :attribute mező kötelező, ha az :other értéke :value.',
    'required_if_accepted' => 'Az :attribute mező kötelező, ha az :other elfogadásra kerül.',
    'required_if_declined' => 'Az :attribute mező kitöltése kötelező, ha az :other elutasításra kerül.',
    'required_unless'      => 'Az :attribute mező kitöltése kötelező, hacsak az :other nem tartalmazza a :values fájlt.',
    'required_with'        => 'A :attribute mező kötelező, ha a :values jelen van.',
    'required_with_all'    => 'Az :attribute mező kötelező, ha a :values vannak jelen.',
    'required_without'     => 'A :attribute mező kitöltése kötelező, ha a :values nincs jelen.',
    'required_without_all' => 'A :attribute mező kitöltése kötelező, ha a :values egyike sem található meg.',
    'same'                 => 'Az :attribute mezőnek egyeznie kell az :other értékkel.',

    'méret'       => [
        'array'   => 'Az :attribute mezőnek tartalmaznia kell a :size elemeket.',
        'file'    => 'Az :attribute mezőnek :size kilobájt méretűnek kell lennie.',
        'numeric' => 'Az :attribute mezőnek :size-nek kell lennie.',
        'string'  => 'Az :attribute mezőnek :size karakter hosszúságúnak kell lennie.',
    ],
    'starts_with' => 'Az :attribute mezőnek a következők valamelyikével kell kezdődnie: :values.',
    'string'      => 'Az :attribute mezőnek karakterláncnak kell lennie.',
    'timezone'    => 'Az :attribute mezőnek érvényes időzónának kell lennie.',
    'unique'      => 'Az :attribute mező már foglalt.',
    'uploaded'    => 'Az :attribute mezőt nem sikerült feltölteni.',
    'uppercase'   => 'Az :attribute mezőnek nagybetűsnek kell lennie.',
    'url'         => 'Az :attribute mezőnek érvényes URL-nek kell lennie.',
    'ulid'        => 'Az :attribute mezőnek érvényes ULID-nek kell lennie.',
    'uuid'        => 'Az :attribute mezőnek érvényes UUID-nek kell lennie.',

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
