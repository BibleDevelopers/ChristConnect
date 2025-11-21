<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KJVImportSeeder extends Seeder
{
    /**
     * Try to import KJV verses from a local JSON file `database/seeders/data/kjv.json`
     * or download from a public raw source if not present.
     *
     * The expected JSON shape is an array of objects with: book, chapter, verse, text
     */
    public function run(): void
    {
        $local = database_path('seeders/data/kjv.json');

        if (file_exists($local) && is_readable($local)) {
            $this->command->info("Found local KJV file at {$local}, using it.");
            $content = file_get_contents($local);
        } else {
            // Attempt to download a public-domain KJV JSON from a known raw URL.
            $this->command->info('Local KJV file not found; attempting to download KJV JSON from public source...');
            $candidates = [
                'https://raw.githubusercontent.com/thiagobodruk/bible/master/json/en_kjv.json',
                'https://raw.githubusercontent.com/scrollmapper/bible_databases/master/json/kjv.json',
            ];

            $content = null;
            foreach ($candidates as $url) {
                try {
                    $res = Http::timeout(30)->get($url);
                    if ($res->ok()) {
                        $content = $res->body();
                        $this->command->info("Downloaded KJV JSON from {$url}");
                        break;
                    }
                } catch (\Throwable $e) {
                    // ignore errors and try next
                }
            }

            if (empty($content)) {
                $this->command->info('Unable to download KJV JSON and no local file present. Skipping KJV import.');
                return;
            }
        }

        // Try robust JSON decoding with common fallbacks for encoding issues
        $data = json_decode($content, true);
        if ($data === null) {
            // Try to convert to UTF-8 and decode again
            $converted = @mb_convert_encoding($content, 'UTF-8', 'UTF-8');
            $data = json_decode($converted, true);
        }

        if ($data === null) {
            // Strip invalid control chars and try again
            $clean = preg_replace('/[\x00-\x1F\x7F]/u', '', $content);
            $data = json_decode($clean, true);
        }

        if (!is_array($data) || empty($data)) {
            $this->command->error('KJV JSON is invalid or empty after attempted repairs.');
            return;
        }

        $rows = [];
        $count = 0;

        // Normalize several common JSON shapes into rows of book/chapter/verse/text
        // Shape A: array of book objects: {"name":"Genesis","chapters":[ ["v1","v2"], [...]] }
        if (is_array($data) && isset($data[0]) && (isset($data[0]['chapters']) || is_array($data[0]))) {
            foreach ($data as $bookObj) {
                // If book is an object with 'name' and 'chapters'
                if (is_array($bookObj) && isset($bookObj['chapters']) && isset($bookObj['name'])) {
                    $bookName = $bookObj['name'];
                    foreach ($bookObj['chapters'] as $ci => $chap) {
                        $chapterNo = $ci + 1;
                        if (!is_array($chap)) continue;
                        foreach ($chap as $vi => $verseText) {
                            $verseNo = $vi + 1;
                            $rows[] = [
                                'version' => 'kjv',
                                'book' => strtolower(str_replace(' ', '_', $bookName)),
                                'chapter' => $chapterNo,
                                'verse' => $verseNo,
                                'text' => $verseText,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                            $count++;
                        }
                    }
                } elseif (is_array($bookObj) && isset($bookObj['name']) && isset($bookObj['verses'])) {
                    // alternate shape: 'verses' keyed by chapter
                    $bookName = $bookObj['name'];
                    foreach ($bookObj['verses'] as $chapterNo => $verses) {
                        foreach ($verses as $verseNo => $verseText) {
                            $rows[] = [
                                'version' => 'kjv',
                                'book' => strtolower(str_replace(' ', '_', $bookName)),
                                'chapter' => (int)$chapterNo,
                                'verse' => (int)$verseNo,
                                'text' => $verseText,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                            $count++;
                        }
                    }
                } elseif (is_array($bookObj) && !isset($bookObj['chapters']) && is_array($bookObj)) {
                    // Some sources represent book as [ [v1,v2], [v1,v2] ] with 'name' provided separately
                    // Try to detect 'name' in a sibling key by searching nearby (not reliable)
                    continue;
                }
            }
        }

        // Shape B: associative object with book keys mapping to chapters
        if (empty($rows) && is_array($data)) {
            foreach ($data as $bookKey => $bookVal) {
                if (!is_array($bookVal)) continue;
                // If bookVal is chapters array (0-indexed)
                $isChapters = true;
                foreach ($bookVal as $ch) {
                    if (!is_array($ch)) { $isChapters = false; break; }
                }
                if ($isChapters) {
                    $bookName = $bookKey;
                    foreach ($bookVal as $ci => $chap) {
                        $chapterNo = $ci + 1;
                        foreach ($chap as $vi => $verseText) {
                            $rows[] = [
                                'version' => 'kjv',
                                'book' => strtolower(str_replace(' ', '_', $bookName)),
                                'chapter' => $chapterNo,
                                'verse' => $vi + 1,
                                'text' => $verseText,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                            $count++;
                        }
                    }
                }
            }
        }

        // Shape C: flat array of verse objects (book/chapter/verse/text)
        if (empty($rows) && is_array($data)) {
            foreach ($data as $entry) {
                if (isset($entry['book'], $entry['chapter'], $entry['verse'], $entry['text'])) {
                    $rows[] = [
                        'version' => 'kjv',
                        'book' => strtolower(str_replace(' ', '_', $entry['book'])),
                        'chapter' => (int) $entry['chapter'],
                        'verse' => (int) $entry['verse'],
                        'text' => $entry['text'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $count++;
                }
            }
        }

        if (empty($rows)) {
            $this->command->error('Could not normalize KJV JSON into expected structure.');
            return;
        }

        $this->command->info("Ready to import {$count} verses. Inserting in batches...");
        DB::table('bible_verses')->truncate();

        $batch = [];
        foreach ($rows as $r) {
            $batch[] = $r;
            if (count($batch) >= 500) {
                DB::table('bible_verses')->insert($batch);
                $batch = [];
            }
        }
        if (!empty($batch)) DB::table('bible_verses')->insert($batch);

        $this->command->info("Imported {$count} KJV verses.");
    }
}
