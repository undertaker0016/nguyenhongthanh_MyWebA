<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Post::with('user')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|min:3|max:255',
                'content' => 'required',
                'image' => 'nullable|string',
                'status' => 'required|in:0,1',
            ]);

            Post::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'image' => $request->image,
                'status' => $request->status,
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Thêm bài viết thành công!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Thêm bài viết thất bại!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "post show: " ;
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
{
    $post = Post::findOrFail($id);

    $users = User::select('id', 'fullname')
        ->orderBy('fullname')
        ->get();

    return view('admin.posts.edit', compact('post', 'users'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $post = Post::findOrFail($id);

            $request->validate([
                'title' => 'required|min:3|max:255',
                'content' => 'required',
                'image' => 'nullable|string',
                'status' => 'required|in:0,1',
            ]);

            $post->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'image' => $request->image,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Cập nhật thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "post destroy: ";
    }
}