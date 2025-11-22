<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Renungan;
use App\Models\RenunganComment;
use Illuminate\Support\Facades\Auth;

class RenunganController extends Controller
{
    // show paginated list
    public function index()
    {
        $posts = Renungan::with('user.badges')->latest()->paginate(10);
        return view('renungan.renungan', compact('posts'));
    }

    // show single post + comments
    public function show(Renungan $renungan)
    {
        $renungan->load('user.badges');

        $comments = $renungan->comments()->with('user.badges')->orderBy('created_at', 'asc')->get();

        return view('renungan.show', compact('renungan', 'comments'));
    }

    // store a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000', // batasi panjang
        ]);

        // sanitize title to plain text and require non-empty
        $titleClean = trim(strip_tags($request->title));
        if ($titleClean === '') {
            return back()->withErrors(['title' => 'Title harus berisi teks yang valid.'])->withInput();
        }

        $input = $request->content;

        // Prefer using a trusted purifier if available (e.g. mews/purifier)
        if (app()->bound('purifier')) {
            $cleanContent = app('purifier')->clean($input);
        } else {
            // Basic but stricter sanitizer fallback
            $allowed = '<p><br><strong><em><ul><ol><li><a>';
            $cleanContent = strip_tags($input, $allowed);

            // remove inline event handlers (on*)
            $cleanContent = preg_replace('/(<[a-z][^>]*?)on\w+\s*=\s*([\'"]).*?\2/iu', '$1', $cleanContent);

            // sanitize hrefs in anchors and add rel/target for external links
            $cleanContent = preg_replace_callback(
                '/<a\s+[^>]*href=(["\']?)([^"\'>\s]+)\1[^>]*>/i',
                function ($m) {
                    $href = $m[2] ?? '';
                    if (preg_match('/^(https?:\/\/|mailto:|\/)/i', $href)) {
                        $safe = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
                        $relTarget = preg_match('/^https?:\/\//i', $href) ? ' target="_blank" rel="noopener noreferrer"' : '';
                        return '<a href="' . $safe . '"' . $relTarget . '>';
                    }
                    return '<a>';
                },
                $cleanContent
            );
        }

        // Reject if sanitization removed all visible text (e.g. input was only <img onerror=...>)
        if (trim(strip_tags($cleanContent)) === '') {
            return back()->withErrors(['content' => 'Content Anda berisi HTML yang tidak diperbolehkan atau kosong setelah sanitasi. Silakan masukkan teks biasa atau gunakan tag yang diizinkan.'])->withInput();
        }

        $post = Renungan::create([
            'user_id' => Auth::id(),
            'title' => $titleClean,
            'content' => $cleanContent,
        ]);

        return redirect()->route('renungan.show', $post)->with('success', 'Renungan dibuat.');
    }

    // add comment to a post
    public function comment(Request $request, Renungan $renungan)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        // sanitasi komentar (strip all tags)
        $cleanComment = strip_tags($request->content);
        $cleanComment = trim($cleanComment);

        // if input was only tags (e.g. <img onerror=...>) strip_tags -> empty
        if ($cleanComment === '') {
            return back()->withErrors(['content' => 'Komentar Anda berisi HTML yang tidak diizinkan. Silakan tulis teks biasa.'])->withInput();
        }

        $renungan->comments()->create([
            'user_id' => Auth::id(),
            'content' => $cleanComment,
        ]);

        return back()->with('success', 'Komentar ditambahkan.');
    }

    public function destroy(Renungan $renungan)
    {
        $user = Auth::user();
        if ($user->id !== $renungan->user_id && $user->role !== 'admin') {
            abort(403);
        }

        $renungan->delete();

        return redirect()->route('renungan')->with('success', 'Renungan dihapus.');
    }

    public function destroyComment(Renungan $renungan, RenunganComment $comment)
    {
        $user = Auth::user();
        if ($comment->renungan_id !== $renungan->id) {
            abort(404);
        }
        if ($user->id !== $comment->user_id && $user->role !== 'admin') {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }

    public function edit(Renungan $renungan)
    {
        $user = Auth::user();
        if ($user->id !== $renungan->user_id && $user->role !== 'admin') {
            abort(403);
        }

        return view('renungan.edit', compact('renungan'));
    }

    public function update(Request $request, Renungan $renungan)
    {
        $user = Auth::user();
        if ($user->id !== $renungan->user_id && $user->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        // sanitize title to plain text and require non-empty
        $titleClean = trim(strip_tags($request->title));
        if ($titleClean === '') {
            return back()->withErrors(['title' => 'Title harus berisi teks yang valid.'])->withInput();
        }

        $input = $request->content;

        if (app()->bound('purifier')) {
            $cleanContent = app('purifier')->clean($input);
        } else {
            $allowed = '<p><br><strong><em><ul><ol><li><a>';
            $cleanContent = strip_tags($input, $allowed);
            $cleanContent = preg_replace('/(<[a-z][^>]*?)on\w+\s*=\s*([\'"]).*?\2/iu', '$1', $cleanContent);
            $cleanContent = preg_replace_callback(
                '/<a\s+[^>]*href=(["\']?)([^"\'>\s]+)\1[^>]*>/i',
                function ($m) {
                    $href = $m[2] ?? '';
                    if (preg_match('/^(https?:\/\/|mailto:|\/)/i', $href)) {
                        $safe = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
                        $relTarget = preg_match('/^https?:\/\//i', $href) ? ' target="_blank" rel="noopener noreferrer"' : '';
                        return '<a href="' . $safe . '"' . $relTarget . '>';
                    }
                    return '<a>';
                },
                $cleanContent
            );
        }

        // Reject if sanitization removed all visible text
        if (trim(strip_tags($cleanContent)) === '') {
            return back()->withErrors(['content' => 'Content Anda berisi HTML yang tidak diperbolehkan atau kosong setelah sanitasi. Silakan masukkan teks biasa atau gunakan tag yang diizinkan.'])->withInput();
        }

        $renungan->title = $titleClean;
        $renungan->content = $cleanContent;
        $renungan->save();

        return redirect()->route('renungan.show', $renungan)->with('success', 'Renungan diperbarui.');
    }
}
