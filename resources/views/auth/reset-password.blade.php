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
            <h2 class="mt-3 text-2xl font-bold tracking-tight text-center text-gray-900">Reset Password</h2>
        </div>

        <div class="mt-3 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                        type="email" name="email" :value="old('email', $request->email)" required autofocus
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-forms.primary-button>
                        {{ __('Reset Password') }}
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
