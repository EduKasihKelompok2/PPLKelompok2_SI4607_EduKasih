<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ForumController extends Controller
{
    /**
     * Constructor - apply auth middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of forums.
     */
    public function index(Request $request)
    {
        $forums = Forum::mainPosts()
            ->with(['user', 'feedback.user'])
            ->latest()
            ->filter(request(['search']))
            ->paginate(10)
            ->withQueryString();

        return view('user.forum', compact('forums'));
    }

    /**
     * Show the form for creating a new forum.
     */
    public function create()
    {
        return redirect()->route('forum.index');
    }

    /**
     * Store a newly created forum in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $forum = new Forum();
        $forum->title = $validated['title'];
        $forum->description = $validated['description'];
        $forum->user_id = auth()->id();
        $forum->is_feedback = false;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('forum_images', 'public');
            $forum->image = $imagePath;
        }

        $forum->save();

        return redirect()->route('forum.index')->with('success', 'Forum berhasil dibuat');
    }

    /**
     * Store a reply to a forum post.
     */
    public function reply(Request $request, $id)
    {
        $parent = Forum::findOrFail($id);

        $validated = $request->validate([
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $reply = new Forum();
        $reply->description = $validated['description'];
        $reply->user_id = auth()->id();
        $reply->is_feedback = true;
        $reply->forum_id = $parent->id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('forum_images', 'public');
            $reply->image = $imagePath;
        }

        $reply->save();

        return back()->with('success', 'Balasan berhasil dikirim');
    }

    /**
     * Update the specified forum in storage.
     */
    public function update(Request $request, $id)
    {
        $forum = Forum::findOrFail($id);

        // Authorization check
        if (auth()->id() !== $forum->user_id) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengedit forum ini');
        }

        // Different validation rules for main posts and replies
        if ($forum->is_feedback) {
            $validated = $request->validate([
                'description' => 'required|string',
                'image' => 'nullable|image|max:2048',
            ]);
        } else {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|max:2048',
            ]);

            $forum->title = $validated['title'];
        }

        $forum->description = $validated['description'];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($forum->image) {
                Storage::disk('public')->delete($forum->image);
            }

            $imagePath = $request->file('image')->store('forum_images', 'public');
            $forum->image = $imagePath;
        }

        $forum->save();

        return back()->with('success', 'Forum berhasil diperbarui');
    }

    /**
     * Remove the specified forum from storage.
     */
    public function destroy($id)
    {
        $forum = Forum::findOrFail($id);

        // Authorization check
        if (auth()->id() !== $forum->user_id) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus forum ini');
        }

        // If it's a main forum post, delete all replies too
        if (!$forum->is_feedback) {
            // Delete all replies' images
            foreach ($forum->feedback as $reply) {
                if ($reply->image) {
                    Storage::disk('public')->delete($reply->image);
                }
                $reply->delete();
            }
        }

        // Delete forum image if exists
        if ($forum->image) {
            Storage::disk('public')->delete($forum->image);
        }

        $forum->delete();

        // If deleting a reply, stay on the same page
        if ($forum->is_feedback) {
            return back()->with('success', 'Balasan berhasil dihapus');
        }

        // If deleting a main post, go back to forum index
        return redirect()->route('forum.index')->with('success', 'Forum berhasil dihapus');
    }
}
