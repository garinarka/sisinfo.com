<x-guest-layout>
    <div class="flex flex-col justify-center min-h-full px-6 py-12 lg:px-8">
        <div>
            <a class="flex justify-center" href="/">
                <x-application-logo class="text-indigo-600 fill-current size-10" />
            </a>
        </div>
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-3 text-2xl font-bold tracking-tight text-center text-gray-900">
                {{ __('Verify Your Email Address') }}
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600 dark:text-gray-400">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on
                the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
        <div class="mt-4 text-sm font-medium text-center text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
        @endif

        <div class="mt-3 sm:mx-auto sm:w-full sm:max-w-sm">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div class="flex items-center justify-center mt-4">
                    <x-forms.primary-button>
                        {{ __('Resend Verification Email') }}
                    </x-forms.primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Log Out') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
