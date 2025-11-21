<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BibleDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bible_verses')->truncate(); 

        $verses = [
            
            ['version' => 'tb', 'book' => 'genesis', 'chapter' => 1, 'verse' => 1, 'text' => 'Pada mulanya Allah menciptakan langit dan bumi.'],
            ['version' => 'tb', 'book' => 'genesis', 'chapter' => 1, 'verse' => 2, 'text' => 'Bumi belum berbentuk dan kosong; gelap gulita menutupi samudera raya, dan Roh Allah melayang-layang di atas permukaan air.'],
            
            ['version' => 'tb', 'book' => 'genesis', 'chapter' => 2, 'verse' => 1, 'text' => 'Demikianlah diselesaikan langit dan bumi dan segala isinya.'],
            ['version' => 'tb', 'book' => 'genesis', 'chapter' => 2, 'verse' => 2, 'text' => 'Ketika Allah pada hari ketujuh telah menyelesaikan pekerjaan yang dibuat-Nya itu, berhentilah Ia pada hari ketujuh dari segala pekerjaan yang telah dibuat-Nya itu.'],

            
            ['version' => 'kjv', 'book' => 'genesis', 'chapter' => 1, 'verse' => 1, 'text' => 'In the beginning God created the heaven and the earth.'],
            ['version' => 'kjv', 'book' => 'genesis', 'chapter' => 1, 'verse' => 2, 'text' => 'And the earth was without form, and void; and darkness was upon the face of the deep. And the Spirit of God moved upon the face of the waters.'],
            
            ['version' => 'kjv', 'book' => 'genesis', 'chapter' => 2, 'verse' => 1, 'text' => 'Thus the heavens and the earth were finished, and all the host of them.'],
            ['version' => 'kjv', 'book' => 'genesis', 'chapter' => 2, 'verse' => 2, 'text' => 'And on the seventh day God ended his work which he had made; and he rested on the seventh day from all his work which he had made.'],
        ];

        foreach ($verses as &$verse) {
            $verse['created_at'] = now();
            $verse['updated_at'] = now();
        }

        DB::table('bible_verses')->insert($verses);

        $this->command->info('Sample Bible verses have been seeded.');
    }
}
