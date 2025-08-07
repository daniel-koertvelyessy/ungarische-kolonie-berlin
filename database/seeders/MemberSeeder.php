<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Membership\Member;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

final class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Becsei',
            'first_name' => 'Illés',
            'email' => null,
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Bernhardt',
            'first_name' => 'Josef',
            'email' => 'jozsef.b@gmx.net',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Bogdán',
            'first_name' => 'Daniela',
            'email' => 'daniela.bogdan336@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Bognár',
            'first_name' => 'Andrea',
            'email' => 'bognar.andrea1@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Bruck',
            'first_name' => 'József',
            'email' => 'joska.bruck@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Deák',
            'first_name' => 'Alexandra',
            'email' => 'alexandra.deak74@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Deák',
            'first_name' => 'Ferenc',
            'email' => null,
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Dr. Heidt',
            'first_name' => 'Géza',
            'email' => 'silkeheidt@t-online.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Erdmann',
            'first_name' => 'Erzsébet',
            'email' => 'erdmann3@gmx.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Fekete',
            'first_name' => 'Imre',
            'email' => 'Imre.Fekete@gmx.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Fülöp',
            'first_name' => 'Tamás',
            'email' => 'tamas.flp@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Gremsperger',
            'first_name' => 'Timea',
            'email' => 'Tgremsperger@gmx.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Guth',
            'first_name' => 'Emöke Maria',
            'email' => 'maria.guth9@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Guth',
            'first_name' => 'Werner',
            'email' => 'samy.guth@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Hardi-Szabó',
            'first_name' => 'Zoltán',
            'email' => 'hardiszabozoltan@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Heidt',
            'first_name' => 'Matthias',
            'email' => 'matthiasheidt83@web.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Heller',
            'first_name' => 'Knut',
            'email' => 'knut-heller@t-online.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Heller',
            'first_name' => 'Robert',
            'email' => 'robert.heller@hotmail.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Heuer',
            'first_name' => 'Judith',
            'email' => 'judith.heuer@gmx.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Hoffmann',
            'first_name' => 'Andreas',
            'email' => 'vuddbih@gmx.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Horváth',
            'first_name' => 'Viktória',
            'email' => 'vikvaktoriahorvath@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Kállai',
            'first_name' => 'Ágnes',
            'email' => 'agneskallai254@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Keszég',
            'first_name' => 'Kornél',
            'email' => 'kornelkeszeg@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Kis',
            'first_name' => 'Lajos',
            'email' => 'lajoskis357@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Korpos´-Köpál',
            'first_name' => 'András',
            'email' => 'korpos@gmail.hu',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Kovács',
            'first_name' => 'Ágnes',
            'email' => 'agnes.steczne@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Kovács',
            'first_name' => 'Ida',
            'email' => null,
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Kovács',
            'first_name' => 'Rozália',
            'email' => 'rozaliaberlin@googlemail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Kovács',
            'first_name' => 'Sándor',
            'email' => 'olajbogyo07@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Küster',
            'first_name' => 'Katalin',
            'email' => null,
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'László',
            'first_name' => 'Attila',
            'email' => 'laciatti@hotmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'László',
            'first_name' => 'Levente',
            'email' => 'leventelaszlo@gmx.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Lerm',
            'first_name' => 'Eric',
            'email' => 'ericlerm@arcor.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Liebhardt',
            'first_name' => 'István',
            'email' => 'liebhardt54@gmx.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Márki',
            'first_name' => 'Anna',
            'email' => null,
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Molnár',
            'first_name' => 'János',
            'email' => '56molnar@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Molnár',
            'first_name' => 'Tóth Irén',
            'email' => '56irenmo@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Morvai',
            'first_name' => 'István',
            'email' => null,
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Morvai',
            'first_name' => 'Mária',
            'email' => null,
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Mozoly',
            'first_name' => 'Ladislaus',
            'email' => 'lmozoly@t-online.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Nagy',
            'first_name' => 'Attila',
            'email' => 'ombenza@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Nagy',
            'first_name' => 'Szabolcs',
            'email' => null,
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Nárai',
            'first_name' => 'Judit',
            'email' => 'judit.sas@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Oswald',
            'first_name' => 'Maria',
            'email' => 'mrswld@yahoo.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Papp',
            'first_name' => 'Dorián',
            'email' => 'dorian.papp@web.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Papp',
            'first_name' => 'Ildikó',
            'email' => 'ildiko.papp@t-online.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Pusch',
            'first_name' => 'Andreas',
            'email' => 'andreaspusch@yahoo.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Törjék',
            'first_name' => 'József',
            'email' => 'joseftoerjek@gmail.com',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Usztics',
            'first_name' => 'Anita',
            'email' => 'anita67@arcor.de',
        ]);
        Member::create([
            'applied_at' => Carbon::today('Europe/Berlin'),
            'name' => 'Usztics',
            'first_name' => 'János',
            'email' => 'janos.usztics@gmail.com',
        ]);
    }
}
