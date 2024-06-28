<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BlogController extends Controller
{
    public function index(Request $request): View
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

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:25',
        ]);
    }

    private function syncCategories(array|null $categories, Blog $blog): void
    {
        if ($categories) {
            $blog->categories()->sync($categories);
        } else {
            $blog->categories()->detach($categories);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateData($request);
        $validatedData['user_id'] = auth()->id();

        $blog = Blog::create($validatedData);

        $this->syncCategories($request->category, $blog);

        return redirect()->route('blog.index');
    }

    public function show(Blog $blog): View
    {
        return view('blog.show', ['blog' => $blog]);
    }

    public function edit(Blog $blog): View
    {
        return view('blog.edit', [
            'blog' => $blog,
            'categories' => Category::get(),
        ]);
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $validatedData = $this->validateData($request);

        $blog->update($validatedData);

        $this->syncCategories($request->category, $blog);

        return redirect()->back();
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $blog->delete();
        return redirect()->route('blog.index');
    }

    public function addComment(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'body' => 'required|min:10',
            'blog_id' => 'required',
        ]);
        $validatedData['user_id'] = auth()->id();

        BlogComment::create($validatedData);

        return redirect()->route('blog.show', $request->blog_id);
    }

    public function deleteComment(BlogComment $comment): RedirectResponse
    {
        $comment->delete();
        return redirect()->back();
    }
}
