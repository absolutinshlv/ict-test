<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($search = $request->input('search')) {
            $request->validate([
                'search' => 'required|min:3',
            ]);
        }
        $blogs = Blog::where('title', 'like', "%$search%")
            ->orWhere('body', 'like', "%$search%")
            ->orderByDesc('id')
            ->paginate(3);
        $blogs->appends(['search' => $search]);

        return view('blog.index', ['blogs' => $blogs]);
    }

    public function create(): View
    {
        return view('blog.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:25',
        ]);

        $categories = $request->category;

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->user_id = auth()->id();
        $blog->save();

        if ($categories) {
            $blog->categories()->attach($categories);
        }

        return redirect()->route('blog.index');
    }

    public function show(string $id)
    {
        $blog = Blog::find($id);
        return view('blog.show', ['blog' => $blog]);
    }

    public function edit(Blog $blog)
    {
        return view('blog.edit', [
            'blog' => $blog,
            'categories' => Category::get(),
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:25',
        ]);

        $blog->update($request->only('title', 'body'));

        $categories = $request->category;
        if ($categories) {
            $blog->categories()->sync($categories);
        } else {
            $blog->categories()->detach($categories);
        }
        return redirect()->back();
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->back();
    }

    public function addComment(Request $request)
    {
        $request->validate([
            'body' => 'required|min:10',
        ]);
        $data = new BlogComment();
        $data->body = $request->body;
        $data->user_id = auth()->id();
        $data->blog_id = $request->blog_id;
        $data->save();

        return redirect()->route('blog.show', $request->blog_id);
    }

    public function deleteComment(BlogComment $comment)
    {
        $comment->delete();
        return redirect()->back();
    }
}
