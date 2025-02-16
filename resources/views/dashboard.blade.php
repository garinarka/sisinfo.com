<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('These are your details, ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Quick Stats Section -->
            <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-2 lg:grid-cols-4">
                @if ($user->hasRole('admin') || $user->hasRole('operator'))
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Books</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalBooks ?? 0 }}</div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Borrowed</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $borrowedBooks ?? 0 }}</div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Available Books</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $availableBooks ?? 0 }}
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Due Returns</div>
                        <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $dueReturns ?? 0 }}</div>
                    </div>
                </div>
                @else
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Currently Borrowed</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $borrowedBooks ?? 0 }}</div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Books Returned</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $returnedBooks ?? 0 }}</div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Available Books</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $availableBooks ?? 0 }}
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Overdue Books</div>
                        <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $overdueBooks ?? 0 }}</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick Actions Section -->
            <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-2">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @if ($user->hasRole('admin') || $user->hasRole('operator'))
                            <a href="{{ route('books.create') }}"
                                class="inline-flex items-center justify-center px-4 py-2 text-white transition bg-blue-600 rounded-lg dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Book
                            </a>
                            <a href="{{ route('books.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 text-white transition bg-green-600 rounded-lg dark:bg-green-500 hover:bg-green-700 dark:hover:bg-green-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Manage Books
                            </a>
                            @endif
                            <a href="{{ route('books.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 text-white transition bg-indigo-600 rounded-lg dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Browse Books
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Notifications
                        </h3>
                        <div class="space-y-4">
                            @forelse(auth()->user()->notifications()->take(3)->get() as $notification)
                            <div class="flex items-start p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                                <div class="flex-shrink-0">
                                    @if($notification->type === 'App\Notifications\BookBorrowed')
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    @else
                                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    @endif
                                </div>
                                <div class="w-full ml-3">
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{
                                        $notification->data['message'] ?? 'New notification' }}</p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{
                                        $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">No new notifications</p>
                            @endforelse
                            <a href="{{ route('notifications.index') }}"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View all
                                notifications</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Recent Activity') }}
                    </h3>

                    @if($recentActivity->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        {{ __('Book') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        {{ __('Activity') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        {{ __('Date') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        {{ __('Status') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-600">
                                @foreach($recentActivity as $activity)
                                <tr>
                                    <td
                                        class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-100">
                                        <a href="{{ route('books.show', $activity->book) }}"
                                            class="hover:text-blue-600 dark:hover:text-blue-400">
                                            {{ $activity->book->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        @if($activity->returned_date)
                                        {{ __('Returned') }}
                                        @else
                                        {{ __('Borrowed') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        @if($activity->returned_date)
                                        {{ $activity->returned_date->format('Y-m-d H:i') }}
                                        @else
                                        {{ $activity->borrowed_date->format('Y-m-d H:i') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($activity->returned_date)
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full dark:bg-green-200 dark:text-green-900">
                                            {{ __('Completed') }}
                                        </span>
                                        @elseif($activity->due_date->isPast())
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full dark:bg-red-200 dark:text-red-900">
                                            {{ __('Overdue') }}
                                        </span>
                                        @else
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-200 dark:text-yellow-900">
                                            {{ __('Active') }}
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($recentActivity->hasPages())
                    <div class="mt-4">
                        {{ $recentActivity->links() }}
                    </div>
                    @endif
                    @else
                    <p class="text-gray-500 dark:text-gray-400">{{ __('No recent activity.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>