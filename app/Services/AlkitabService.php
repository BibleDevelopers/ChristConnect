<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AlkitabService
{
    protected $base;

    public function __construct()
    {
        $this->base = rtrim(config('services.alkitab.url') ?? env('ALKITAB_API_URL', ''), '/');
    }

    public function available()
    {
        return !empty($this->base);
    }

    public function getBooks()
    {
        if (!$this->available()) {
            return [];
        }

        // try a couple of common endpoints
        $candidates = [
            $this->base . '/books',
            $this->base . '/api/books',
        ];

        foreach ($candidates as $url) {
            try {
                $res = Http::timeout(5)->get($url);
                if ($res->ok()) {
                    return $res->json();
                }
            } catch (\Throwable $e) {
                // ignore and try next
            }
        }

        return [];
    }

    public function getChapter($version, $book, $chapter)
    {
        if (!$this->available()) {
            return null;
        }

        $candidates = [
            // common patterns used by various alkitab APIs
            $this->base . "/api/alkitab/{$version}/{$book}/{$chapter}",
            $this->base . "/api/verses/{$version}/{$book}/{$chapter}",
            $this->base . "/verses/{$version}/{$book}/{$chapter}",
            $this->base . "/{$version}/{$book}/{$chapter}",
        ];

        foreach ($candidates as $url) {
            try {
                $res = Http::timeout(5)->get($url);
                if ($res->ok()) {
                    return $res->json();
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return null;
    }

    public function search($version, $query, $book = null, $chapter = null)
    {
        if (!$this->available()) {
            return [];
        }

        $params = ['q' => $query];
        if ($book) $params['book'] = $book;
        if ($chapter) $params['chapter'] = $chapter;

        $candidates = [
            $this->base . "/api/alkitab/search/{$version}",
            $this->base . "/search/{$version}",
            $this->base . "/api/search/{$version}",
        ];

        foreach ($candidates as $url) {
            try {
                $res = Http::timeout(5)->get($url, $params);
                if ($res->ok()) {
                    return $res->json();
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return [];
    }
}
