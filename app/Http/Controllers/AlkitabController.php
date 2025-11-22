<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\AlkitabService;

class AlkitabController extends Controller
{
    public function index(Request $request)
    {
        // if external API configured, prefer it but fall back to local list when empty
        $version = $request->input('version');
        $service = new AlkitabService();
        $books = [];
        if ($service->available()) {
            $books = $service->getBooks() ?: [];
        }

        if (empty($books)) {
            $books = $this->getBooks($version ?? null);
        }

        return view('alkitab', ['books' => $books, 'version' => $version]);
    }

    public function getChapter(Request $request, $version, $book, $chapter)
    {
        $service = new AlkitabService();
        if ($service->available()) {
            $res = $service->getChapter($version, $book, $chapter);
            if (!empty($res)) {
                return response()->json($res);
            }
            // if external service returns nothing, fall through to DB fallback
        }

        $verses = DB::table('bible_verses')
            ->where('version', $version)
            ->where('book', $book)
            ->where('chapter', $chapter)
            ->orderBy('verse', 'asc')
            ->get();

        return response()->json($verses);
    }

    public function search(Request $request, $version)
    {
        $query = (string) $request->input('q');
        $book = $request->input('book');
        $chapter = $request->input('chapter');

        if (empty($query)) {
            return response()->json([]);
        }

        // limit length to avoid expensive queries
        $query = mb_substr($query, 0, 200);

        // escape SQL LIKE wildcards % and _ and backslash
        $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $query);

        $service = new AlkitabService();
        if ($service->available()) {
            $results = $service->search($version, $query, $book, $chapter);
            if (!empty($results)) {
                return response()->json($results);
            }
            // fall back to DB if external search returned empty
        }

        $dbQuery = DB::table('bible_verses')
            ->where('version', $version)
            ->where('text', 'LIKE', "%{$escaped}%");

        if ($book) {
            $dbQuery->where('book', $book);
        }

        if ($chapter) {
            $dbQuery->where('chapter', $chapter);
        }

        $results = $dbQuery->limit(50)->get();

        return response()->json($results);
    }

    private function getBooks(?string $version = null)
    {
        try {
            // Canonical Bible book order (Genesis -> Revelation). Books not in this list
            // will be appended after the canonical ones.
            $bookOrder = [
                'genesis','exodus','leviticus','numbers','deuteronomy','joshua','judges','ruth',
                'samuel','kings','chronicles','ezra','nehemiah','esther','job','psalms','proverbs',
                'ecclesiastes','song_of_songs','isaiah','jeremiah','lamentations','ezekiel','daniel',
                'hosea','joel','amos','obadiah','jonah','micah','nahum','habakkuk','zephaniah','haggai',
                'zechariah','malachi','matthew','mark','luke','john','acts','romans','corinthians',
                'galatians','ephesians','philippians','colossians','thessalonians','timothy','titus',
                'philemon','hebrews','james','peter','jude','revelation'
            ];

            $rows = DB::table('bible_verses')
                ->select('book', DB::raw('MAX(chapter) as chapters'))
                ->groupBy('book')
                ->get()
                ->map(function ($r) {
                    return ['book' => $r->book, 'chapters' => (int)$r->chapters];
                })
                ->toArray();

            if (empty($rows)) {
                // Fallback small list when DB empty
                return [
                    ['id' => 'genesis', 'name' => 'Kejadian', 'chapters' => 50],
                    ['id' => 'exodus', 'name' => 'Keluaran', 'chapters' => 40],
                ];
            }

            // Sort rows according to canonical order
            usort($rows, function ($a, $b) use ($bookOrder) {
                $ia = array_search($a['book'], $bookOrder, true);
                $ib = array_search($b['book'], $bookOrder, true);
                if ($ia === false && $ib === false) return strcmp($a['book'], $b['book']);
                if ($ia === false) return 1; // a goes after known-order books
                if ($ib === false) return -1;
                return $ia <=> $ib;
            });

            // If version is 'tb' (Indonesian TB), map book ids to Indonesian names when available
            $tbNames = [
                'genesis' => 'Kejadian', 'exodus' => 'Keluaran', 'leviticus' => 'Imamat',
                'numbers' => 'Bilangan', 'deuteronomy' => 'Ulangan', 'joshua' => 'Yosua',
                'judges' => 'Hakim-hakim', 'ruth' => 'Rut', 'samuel' => 'Samuel',
                'kings' => 'Raja-raja', 'chronicles' => 'Tawarikh', 'ezra' => 'Ezra',
                'nehemiah' => 'Nehemia', 'esther' => 'Ester', 'job' => 'Ayub',
                'psalms' => 'Mazmur', 'proverbs' => 'Amsal', 'ecclesiastes' => 'Pengkhotbah',
                'song_of_songs' => 'Kidung Agung', 'isaiah' => 'Yesaya', 'jeremiah' => 'Yeremia',
                'lamentations' => 'Ratapan', 'ezekiel' => 'Yehezkiel', 'daniel' => 'Daniel',
                'hosea' => 'Hosea', 'joel' => 'Yoel', 'amos' => 'Amos', 'obadiah' => 'Obaja',
                'jonah' => 'Yunus', 'micah' => 'Mika', 'nahum' => 'Nahum', 'habakkuk' => 'Habakuk',
                'zephaniah' => 'Sefanya', 'haggai' => 'Hagai', 'zechariah' => 'Zakharia',
                'malachi' => 'Maleakhi', 'matthew' => 'Matius', 'mark' => 'Markus',
                'luke' => 'Lukas', 'john' => 'Yohanes', 'acts' => 'Kisah Para Rasul',
                'romans' => 'Roma', 'corinthians' => 'Korintus', 'galatians' => 'Galatia',
                'ephesians' => 'Efesus', 'philippians' => 'Filipi', 'colossians' => 'Kolose',
                'thessalonians' => 'Tesalonika', 'timothy' => 'Timotius', 'titus' => 'Titus',
                'philemon' => 'Filemon', 'hebrews' => 'Ibrani', 'james' => 'Yakobus',
                'peter' => 'Petrus', 'jude' => 'Yudas', 'revelation' => 'Wahyu'
            ];

            return array_map(function ($r) use ($version, $tbNames) {
                $name = ucwords(str_replace('_', ' ', $r['book']));
                if ($version === 'tb' && isset($tbNames[$r['book']])) {
                    $name = $tbNames[$r['book']];
                }
                return [
                    'id' => $r['book'],
                    'name' => $name,
                    'chapters' => $r['chapters'],
                ];
            }, $rows);
        } catch (\Exception $e) {
            // If DB isn't available for some reason, return the minimal placeholder list.
            return [
                ['id' => 'genesis', 'name' => 'Kejadian', 'chapters' => 50],
                ['id' => 'exodus', 'name' => 'Keluaran', 'chapters' => 40],
            ];
        }
    }
}
