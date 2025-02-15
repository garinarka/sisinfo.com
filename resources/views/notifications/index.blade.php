<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Notifications') }}
            </h2>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                <x-primary-button>
                    {{ __('Mark All as Read') }}
                </x-primary-button>
            </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        @forelse($notifications as $notification)
                        <div
                            class="flex items-start p-4 {{ $notification->read_at ? 'bg-gray-50' : 'bg-white' }} dark:{{ $notification->read_at ? 'bg-gray-700' : 'bg-gray-800' }} rounded-lg">
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
                            <div class="flex-1 w-0 ml-3">
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $notification->data['message'] }}
                                </p>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{
                                        $notification->created_at->diffForHumans() }}</p>
                                    @unless($notification->read_at)
                                    <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST"
                                        class="ml-3">
                                        @csrf
                                        <button type="submit"
                                            class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-500">
                                            Mark as read
                                        </button>
                                    </form>
                                    @endunless
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-4 text-center">
                            <p class="text-gray-500 dark:text-gray-400">No notifications found.</p>
                        </div>
                        @endforelse

                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>