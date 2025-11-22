<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BibleController extends Controller
{
    public function index()
    {
        return view('alkitab'); 
    }

    public function getPassage($passageRef)
    {
        $parts = explode('.', $passageRef);
        if (count($parts) !== 3) {
            return back()->with('error', 'Format referensi tidak valid.');
        }

        $book = $parts[0];
        $chapter = (int)$parts[1];
        $verse = (int)$parts[2];

        $query = '
            query GetPassage($version: Version, $book: String, $chapter: Int, $verse: Int) {
                passages(version: $version, book: $book, chapter: $chapter, verse: $verse) {
                    verses {
                        verse
                        type
                        content
                    }
                }
            }
        ';
        
        $variables = [
            'version' => 'tb',
            'book' => $book,
            'chapter' => $chapter,
            'verse' => $verse
        ];

        try {
            // Set a reasonable timeout so the request can't hang indefinitely
            $response = Http::timeout(5)->post('http://localhost:3000/', [
                'query' => $query,
                'variables' => $variables
            ]);
        } catch (\Throwable $e) {
            // Log if you have logging configured; return generic error to user
            return back()->with('error', 'Gagal terhubung ke server Alkitab.');
        }

        if ($response->failed()) {
            return back()->with('error', 'Gagal terhubung ke server Alkitab.');
        }

        $data = $response->json();

        // Defensive: ensure expected structure exists
        $verses = $data['data']['passages']['verses'] ?? null;
        if (!is_array($verses) || empty($verses)) {
            return back()->with('error', 'Ayat tidak ditemukan.');
        }

        $fullText = '';
        foreach ($verses as $v) {
            if (isset($v['type']) && $v['type'] === 'content' && isset($v['content'])) {
                $fullText .= $v['content'] . ' ';
            }
        }

        return view('alkitab', [
            'reference' => "{$book} {$chapter}:{$verse}",
            'text' => trim($fullText)
        ]);
    }
}