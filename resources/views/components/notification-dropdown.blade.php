<div x-data="{ open: false }" class="relative z-50">
    <button @click="open = !open" class="relative p-1 text-gray-400 hover:text-gray-500 focus:outline-none">
        <span class="sr-only">View notifications</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <span
            class="absolute top-0 right-0 block w-2 h-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-gray-800"></span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 rounded-md shadow-lg w-80">
        <div class="bg-white rounded-md dark:bg-gray-700 ring-1 ring-black ring-opacity-5">
            <div class="p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        Notifications ({{ auth()->user()->unreadNotifications->count() }})
                    </h3>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500">
                            Mark all as read
                        </button>
                    </form>
                    @endif
                </div>
                <div class="space-y-4 overflow-y-auto max-h-96">
                    @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                    <div
                        class="flex items-start {{ $notification->read_at ? 'opacity-75' : '' }} p-3 rounded-lg {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-600' : 'bg-white dark:bg-gray-700' }}">
                        <div class="flex-1">
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $notification->data['message'] }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                            </p>
                        </div>
                        @unless($notification->read_at)
                        <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-500">
                                Mark as read
                            </button>
                        </form>
                        @endunless
                    </div>
                    @empty
                    <p class="py-4 text-sm text-center text-gray-500 dark:text-gray-400">
                        No notifications
                    </p>
                    @endforelse
                </div>
                @if(auth()->user()->notifications->count() > 5)
                <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-600">
                    <a href="{{ route('notifications.index') }}"
                        class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500">
                        View all notifications
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
