<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col justify-center min-h-full px-6 py-12 lg:px-8">
        <div>
            <a class="flex justify-center" href="/">
                <x-application-logo class="text-indigo-600 fill-current size-10" />
            </a>
        </div>
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-3 text-2xl font-bold tracking-tight text-center text-gray-900">Forgot Password</h2>
            <p class="mt-2 text-sm text-center text-gray-600 dark:text-gray-400">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a
                password reset link that will allow you to choose a new one.') }}
            </p>
        </div>

        <div class="mt-3 sm:mx-auto sm:w-full sm:max-w-sm">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                        type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-forms.primary-button>
                        {{ __('Send Reset Link') }}
                    </x-forms.primary-button>
                </div>
            </form>

            <p class="mt-3 text-sm text-center text-gray-500">
                Remembered your password?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign in</a>
            </p>
        </div>
    </div>
</x-guest-layout>
