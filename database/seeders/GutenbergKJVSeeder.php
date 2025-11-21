<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GutenbergKJVSeeder extends Seeder
{
    protected array $bookMap = [
        
        'genesis' => 'genesis',
        'exodus' => 'exodus',
        'leviticus' => 'leviticus',
        'numbers' => 'numbers',
        'deuteronomy' => 'deuteronomy',
        'joshua' => 'joshua',
        'judges' => 'judges',
        'ruth' => 'ruth',
        'samuel' => 'samuel',
        'kings' => 'kings',
        'chronicles' => 'chronicles',
        'ezra' => 'ezra',
        'nehemiah' => 'nehemiah',
        'esther' => 'esther',
        'job' => 'job',
        'psalm' => 'psalms',
        'psalms' => 'psalms',
        'proverbs' => 'proverbs',
        'ecclesiastes' => 'ecclesiastes',
        'song of' => 'song_of_songs',
        'songs of' => 'song_of_songs',
        'isaiah' => 'isaiah',
        'jeremiah' => 'jeremiah',
        'lamentations' => 'lamentations',
        'ezekiel' => 'ezekiel',
        'daniel' => 'daniel',
        'hosea' => 'hosea',
        'joel' => 'joel',
        'amos' => 'amos',
        'obadiah' => 'obadiah',
        'jonah' => 'jonah',
        'micah' => 'micah',
        'nahum' => 'nahum',
        'habakkuk' => 'habakkuk',
        'zephaniah' => 'zephaniah',
        'haggai' => 'haggai',
        'zechariah' => 'zechariah',
        'malachi' => 'malachi',
        'matthew' => 'matthew',
        'mark' => 'mark',
        'luke' => 'luke',
        'john' => 'john',
        'acts' => 'acts',
        'romans' => 'romans',
        'corinthians' => 'corinthians',
        'galatians' => 'galatians',
        'ephesians' => 'ephesians',
        'philippians' => 'philippians',
        'colossians' => 'colossians',
        'thessalonians' => 'thessalonians',
        'timothy' => 'timothy',
        'titus' => 'titus',
        'philemon' => 'philemon',
        'hebrews' => 'hebrews',
        'james' => 'james',
        'peter' => 'peter',
        'jude' => 'jude',
        'revelation' => 'revelation',
    ];

    public function run(): void
    {
        $this->command->info('Gutenberg KJV import: starting');

        $local = database_path('seeders/data/pg10.txt');
        $path = '/tmp/cc_kjv/pg10.txt';

        if (file_exists($local)) {
            $this->command->info("Using local Gutenberg file: {$local}");
            $text = file_get_contents($local);
        } elseif (file_exists($path)) {
            $this->command->info("Using cached Gutenberg file: {$path}");
            $text = file_get_contents($path);
        } else {
            $this->command->info('Downloading Project Gutenberg KJV (this may take a few seconds)...');
            $url = 'https:
            try {
                $res = Http::timeout(60)->get($url);
                if (!$res->ok()) {
                    $this->command->error('Failed to download Gutenberg KJV');
                    return;
                }
                $text = $res->body();
                @mkdir(dirname($path), 0755, true);
                file_put_contents($path, $text);
            } catch (\Throwable $e) {
                $this->command->error('Download failed: ' . $e->getMessage());
                return;
            }
        }

        
        $text = str_replace("\r\n", "\n", $text);
        $lines = preg_split('/\n/', $text);

        $currentBook = null;
        $currentChapter = null;
        $currentVerse = null;
        $currentText = '';
        $rows = [];

        foreach ($lines as $raw) {
            $line = trim($raw);
            if ($line === '') continue;

            
            $lower = strtolower($line);
            foreach ($this->bookMap as $key => $id) {
                if (strpos($lower, $key) !== false && strlen($line) < 120) {
                    $currentBook = $id;
                    
                    $currentChapter = null;
                    $currentVerse = null;
                    $currentText = '';
                    
                    continue 2;
                }
            }

            
            $parts = preg_split('/(?=\b\d+:\d+\s)/', $line);
            foreach ($parts as $part) {
                if (preg_match('/^(\d+):(\d+)\s*(.*)$/', $part, $m)) {
                    
                    if ($currentBook && $currentChapter !== null && $currentVerse !== null && $currentText !== '') {
                        $rows[] = [
                            'version' => 'kjv',
                            'book' => $currentBook,
                            'chapter' => (int) $currentChapter,
                            'verse' => (int) $currentVerse,
                            'text' => trim(preg_replace('/\s+/', ' ', $currentText)),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    $currentChapter = (int) $m[1];
                    $currentVerse = (int) $m[2];
                    $currentText = $m[3] ?? '';
                } else {
                    
                    if ($currentVerse !== null) {
                        $currentText .= ' ' . $part;
                    }
                }
            }
        }

        
        if ($currentBook && $currentChapter !== null && $currentVerse !== null && $currentText !== '') {
            $rows[] = [
                'version' => 'kjv',
                'book' => $currentBook,
                'chapter' => (int) $currentChapter,
                'verse' => (int) $currentVerse,
                'text' => trim(preg_replace('/\s+/', ' ', $currentText)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (empty($rows)) {
            $this->command->error('No verses extracted from Gutenberg KJV text.');
            return;
        }

        $this->command->info('Inserting ' . count($rows) . ' verses into the database in batches...');
        
        DB::table('bible_verses')->truncate();

        $batch = [];
        $inserted = 0;
        foreach ($rows as $r) {
            $batch[] = $r;
            if (count($batch) >= 500) {
                DB::table('bible_verses')->insert($batch);
                $inserted += count($batch);
                $batch = [];
                $this->command->info("Inserted {$inserted}...");
            }
        }
        if (!empty($batch)) {
            DB::table('bible_verses')->insert($batch);
            $inserted += count($batch);
        }

        $this->command->info("Gutenberg KJV import completed. Total verses inserted: {$inserted}");
    }
}
