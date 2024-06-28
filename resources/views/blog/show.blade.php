<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
            <a href="{{ route('blog.index') }}"><span
                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Back
                    to blog</span>
            </a>
        </h2>
    </x-slot>
    @if (!empty($blog))
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                <h1 class="text-xl font-bold">{{ $blog->title }}</h1>
                <div>
                    <p class="text-sm">Added by {{ $blog->author_name }}, {{ $blog->created_at }}</p>
                </div>
                <div class="mt-2 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{ $blog->body }}
                </div>
                <h2 class="mt-5 text-lg underline font-bold">Comments ({{ $blog->comments->count() }}):</h2>
                @if ($blog->comments->isNotEmpty())
                <div class="container">
                    @foreach ($blog->comments as $comment)
                    <div class="my-2 bg-gray-100 w-full p-2 border-b">
                        <h5 class="font-bold">
                            {{ $comment->user->name }} ({{ $comment->created_at->diffForHumans() }}):
                            <form method="POST" action="{{ route('blog.deleteComment', $comment->id) }}">
                                @csrf
                                @method("DELETE")
                                <button type="submit"
                                    class="float-right rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Delete</button>
                            </form>
                        </h5>
                        <p>{{ $comment->body }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="my-2 bg-gray-100 w-full p-2">
                    No comments yet
                </p>
                @endif
                <div class="container">
                    @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li class="bg-red-600 text-white mt-2 text-sm p-2">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (auth()->check())
                    <h3 class="font-bold text-lg">Add comment</h3>
                    <form action="{{ route('blog.addComment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                        <div class="flex">
                            <textarea name="body" rows="2"
                                class="p-2 border-solid border-2 border-gray-300 w-full"></textarea>
                            <button class="bg-blue-700 text-white p-2 ml-2">Add</button>
                        </div>
                    </form>
                    @else
                    <h3 class="font-bold text-lg">Log in to comment</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>