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

        // sanitasi dasar: hapus tag berbahaya, izinkan beberapa tag formatting jika perlu
        $cleanContent = strip_tags($request->content, '<p><br><strong><em><ul><ol><li><a>');

        $post = Renungan::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
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

        // sanitasi komentar
        $cleanComment = strip_tags($request->content);

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

        $cleanContent = strip_tags($request->content, '<p><br><strong><em><ul><ol><li><a>');

        $renungan->title = $request->title;
        $renungan->content = $cleanContent;
        $renungan->save();

        return redirect()->route('renungan.show', $renungan)->with('success', 'Renungan diperbarui.');
    }
}
