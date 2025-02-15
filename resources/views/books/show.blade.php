<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Book Details') }}
            </h2>
            <div class="flex space-x-4">
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('operator'))
                <a href="{{ route('books.edit', $book) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-150 ease-in-out bg-indigo-600 rounded-lg dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Edit Book') }}
                </a>
                @endif
                <a href="{{ route('books.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-150 ease-in-out bg-gray-600 rounded-lg dark:bg-gray-500 hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-800">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Book Details -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $book->title }}</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">By {{ $book->author }}</p>
                            </div>

                            <div class="pt-4 border-t dark:border-gray-700">
                                <dl class="grid grid-cols-1 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ISBN</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $book->isbn }}</dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Quantity</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $book->quantity }}
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                        <dd class="mt-1">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $book->is_available ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' : 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900' }}">
                                                {{ $book->is_available ? 'Available' : 'Borrowed' }}
                                            </span>
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $book->description
                                            ?? 'No description available.' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Loan History -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Loan History</h3>
                            @if($book->bookLoans->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Borrower</th>
                                            <th
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Borrowed Date</th>
                                            <th
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Due Date</th>
                                            <th
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @foreach($book->bookLoans as $loan)
                                        <tr>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100">
                                                {{ $loan->user->name }}</td>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $loan->borrowed_date->format('Y-m-d') }}</td>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $loan->due_date->format('Y-m-d') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $loan->returned_date ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-200 dark:text-yellow-900' }}">
                                                    {{ $loan->returned_date ? 'Returned' : 'Borrowed' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No loan history available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>