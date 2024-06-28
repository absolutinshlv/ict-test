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
        $search = $request->input('search');

        if ($search) {
            $request->validate([
                'search' => 'required|min:3',
            ]);
        }

        $blogs = Blog::search($search)
            ->orderByDesc('id')
            ->paginate(3)
            ->appends(['search' => $search]);

        return view('blog.index', ['blogs' => $blogs]);
    }

    public function create(): View
    {
        return view('blog.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:25',
        ]);
        $validatedData['user_id'] = auth()->id();

        $blog = Blog::create($validatedData);

        $categories = $request->category;
        if ($categories) {
            $blog->categories()->attach($categories);
        }

        return redirect()->route('blog.index');
    }

    public function show(Blog $blog)
    {
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
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:25',
        ]);

        $blog->update($validatedData);

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
        $validatedData = $request->validate([
            'body' => 'required|min:10',
            'blog_id' => 'required',
        ]);
        $validatedData['user_id'] = auth()->id();

        BlogComment::create($validatedData);

        return redirect()->route('blog.show', $request->blog_id);
    }

    public function deleteComment(BlogComment $comment)
    {
        $comment->delete();
        return redirect()->back();
    }
}
