<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Manage Books') }}
            </h2>
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('operator'))
            <a href="{{ route('books.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-150 ease-in-out bg-blue-600 rounded-lg dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Add New Book') }}
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <!-- Search and Filter Section -->
                    <div class="mb-6">
                        <form action="{{ route('books.index') }}" method="GET"
                            class="grid grid-cols-1 gap-4 md:grid-cols-4">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="w-full pr-10 border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500 dark:text-gray-300"
                                    placeholder="Search books...">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <select name="availability"
                                    class="w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500 dark:text-gray-300">
                                    <option value="">All Availability</option>
                                    <option value="available" {{ request('availability')==='available' ? 'selected' : ''
                                        }}>Available</option>
                                    <option value="borrowed" {{ request('availability')==='borrowed' ? 'selected' : ''
                                        }}>Borrowed</option>
                                </select>
                            </div>
                            <div>
                                <select name="sort"
                                    class="w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500 dark:text-gray-300">
                                    <option value="title">Sort by Title</option>
                                    <option value="author" {{ request('sort')==='author' ? 'selected' : '' }}>Sort by
                                        Author</option>
                                    <option value="newest" {{ request('sort')==='newest' ? 'selected' : '' }}>Newest
                                        First</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit"
                                    class="w-full px-4 py-2 text-gray-700 bg-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-500">
                                    Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Books Table -->
                    <div class="relative overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        Title
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        Author
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        ISBN
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($books as $book)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{
                                            $book->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $book->isbn }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $book->is_available ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' : 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900' }}">
                                            {{ $book->is_available ? 'Available' : 'Borrowed' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex space-x-3">
                                            <a href="{{ route('books.show', $book) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                View
                                            </a>
                                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('operator'))
                                            <a href="{{ route('books.edit', $book) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                Edit
                                            </a>
                                            <form action="{{ route('books.destroy', $book) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                                    onclick="return confirm('Are you sure you want to delete this book?')">
                                                    Delete
                                                </button>
                                            </form>
                                            @endif
                                            @if(auth()->user()->hasRole('visitor') && $book->is_available)
                                            <form action="{{ route('loans.store') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <button type="submit"
                                                    class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">
                                                    Borrow
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        No books found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
        class="fixed px-6 py-3 text-white bg-green-500 rounded-lg shadow-lg bottom-4 right-4">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
        class="fixed px-6 py-3 text-white bg-red-500 rounded-lg shadow-lg bottom-4 right-4">
        {{ session('error') }}
    </div>
    @endif
</x-app-layout>