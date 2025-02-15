<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Book Details') }}
            </h2>
            <div class="flex space-x-4">
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('operator'))
                <a href="{{ route('books.edit', $book) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Edit Book') }}
                </a>
                @endif
                <a href="{{ route('books.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ $book->title }}</h3>
                    <p class="mt-1 text-sm text-gray-600">By {{ $book->author }}</p>
                    <div class="pt-4 mt-4 border-t">
                        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                        <p><strong>Quantity:</strong> {{ $book->quantity }}</p>
                        <p><strong>Status:</strong>
                            <span
                                class="px-2 inline-flex text-xs font-semibold rounded-full {{ $book->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->is_available ? 'Available' : 'Borrowed' }}
                            </span>
                        </p>
                        <p><strong>Description:</strong> {{ $book->description ?? 'No description available.' }}</p>
                    </div>
                    @if(auth()->user()->hasRole('visitor'))
                    @if($book->is_available)
                    <form action="{{ route('loans.store') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <x-primary-button>{{ __('Borrow Book') }}</x-primary-button>
                    </form>
                    @else
                    @php
                    $userLoan = $book->bookLoans()
                    ->where('user_id', auth()->id())
                    ->whereNull('returned_date')
                    ->first();
                    @endphp
                    @if($userLoan)
                    <form action="{{ route('loans.return', $userLoan) }}" method="POST" class="mt-4">
                        @csrf
                        <x-primary-button>{{ __('Return Book') }}</x-primary-button>
                    </form>
                    @endif
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
