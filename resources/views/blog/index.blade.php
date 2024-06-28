<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
            <a href="{{ route('blog.create') }}"><span
                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Add
                    new</span>
            </a>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-10">
                Search blog:
                <form action="{{ route('blog.index') }}" method="GET">
                    <input type="text" name="search" class="p-2 border-solid border-1 border-gray-300 rounded-sm"
                        value="{{ request()->search }}" placeholder="Enter a keyword.." minlength="3" required />
                    <button type="submit" class="bg-blue-700 text-white p-2 rounded-sm">Search</button>
                </form>
            </div>
            @if (request()->has('search'))
            <h1 class="text-lg font-bold pb-5">Search results for: {{ request()->search }}</h1>
            @endif
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                @if($blogs->isNotEmpty())
                @foreach ($blogs as $blog)
                <article
                    class="flex max-w-xl flex-col items-start justify-between bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="flex items-center gap-x-4 text-xs">
                        <time datetime="2020-03-16" class="text-gray-500">{{ $blog->created_at }}</time>
                    </div>
                    <div class="group relative">
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-blue-700">
                            <a href="{{ route('blog.show', $blog->id) }}">
                                <span class="absolute inset-0"></span>
                                {{ $blog->title }}
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">{{ $blog->body }}</p>
                    </div>
                    <div class="relative flex items-center gap-x-4 mt-2">
                        <div class="text-xs leading-6">
                            <p class="text-gray-500">
                                Author: {{ $blog->user->name }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-y-2 justify-start text-xs mt-2">
                        @if($blog->categories->isNotEmpty())
                        @foreach ($blog->categories as $category)
                        <div
                            class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-blue-700 hover:text-white">
                            {{ $category->name }}</div>
                        @endforeach
                        @endif
                    </div>
                    <div class="mt-2">
                        @can('own-blog', $blog)
                        <a href="{{ route('blog.edit', $blog->id) }}">
                            <span
                                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Edit</span>
                        </a>
                        @endcan
                        @can('own-blog', $blog)
                        <form method="POST" action="{{ route('blog.destroy', $blog->id) }}" class="float-right ml-2">
                            @csrf
                            @method("DELETE")
                            <button type="submit"
                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Delete</button>
                        </form>
                        @endcan
                    </div>
                </article>
                @endforeach
                @else
                Nothing found
                @endif
            </div>
            <div class="container w-full mt-5">
                {{ $blogs->links() }}
            </div>
        </div>
</x-app-layout>