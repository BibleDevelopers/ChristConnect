<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlkitabController extends Controller
{
    public function index()
    {
        return view('alkitab', ['books' => $this->getBooks()]);
    }

    public function getChapter(Request $request, $version, $book, $chapter)
    {
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
        $query = $request->input('q');
        $book = $request->input('book');
        $chapter = $request->input('chapter');

        if (empty($query)) {
            return response()->json([]);
        }

        $dbQuery = DB::table('bible_verses')
            ->where('version', $version)
            ->where('text', 'LIKE', "%{$query}%");

        if ($book) {
            $dbQuery->where('book', $book);
        }

        if ($chapter) {
            $dbQuery->where('chapter', $chapter);
        }

        $results = $dbQuery->limit(50)->get();

        return response()->json($results);
    }

    private function getBooks()
    {
        return [
            ['id' => 'genesis', 'name' => 'Kejadian', 'chapters' => 50],
            ['id' => 'exodus', 'name' => 'Keluaran', 'chapters' => 40],
            // isi semua kitab disini
        ];
    }
}
