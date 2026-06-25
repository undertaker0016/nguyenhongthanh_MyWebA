<?php

namespace App\Http\Controllers\Admin;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        $list = Post::select('id', 'title', 'slug', 'image', 'status')
        ->orderBy('title')
        ->paginate($limit);
    return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'fullname')
            ->orderBy('fullname')
            ->get();
        return view('admin.posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:posts,slug',
            'content' => 'required',
            'image' => 'nullable|image',
            'status' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Thêm bài viết thành công!');

    } catch (\Exception $e) {
        return back()
            ->with('error', 'Thêm bài viết thất bại!')
            ->withInput();
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "post show: ";
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
            $request->validate([
                'title' => 'required',
                'slug' => 'required|unique:posts,slug,' . $id,
                'content' => 'required',
                'image' => 'nullable|image',
                'status' => 'required',
                'user_id' => 'required|exists:users,id',
            ]);

            $post = Post::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($post->image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image);
                }
                $imagePath = $request->file('image')->store('posts', 'public');
            } else {
                $imagePath = $post->image;
            }

            $post->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'image' => $imagePath,
                'status' => $request->status,
                'user_id' => $request->user_id,
            ]);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Cập nhật bài viết thành công!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Cập nhật bài viết thất bại!')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "xoa post: " ;
    }
}
