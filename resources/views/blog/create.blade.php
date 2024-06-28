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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('blog.store') }}">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <h1 class="text-xl font-bold">Add new blog</h1>
                    @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li class="bg-red-600 text-white mt-2 text-sm p-2">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <input type="text" name="title" id="title" autocomplete="title"
                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label class="block text-sm font-medium leading-6 text-gray-900">Category</label>
                            <div class="mt-2">
                                @if (!empty($categories))
                                @foreach ($categories as $category)
                                <div>
                                    <input type="checkbox" value="{{ $category->id }}" id="{{ $category->id }}"
                                        name="category[]" />
                                    <label for="{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="body" class="block text-sm font-medium leading-6 text-gray-900">Body</label>
                            <div class="mt-2">
                                <textarea id="body" name="body" rows="3"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="mt-5 bg-blue-700 text-white p-2 rounded-sm">Add</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>