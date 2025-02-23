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
            <h2 class="mt-3 text-2xl font-bold tracking-tight text-center">Sign in to your account</h2>
        </div>

        <div class="mt-3 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium">Email address</label>
                    <div class="mt-2">
                        <x-text-input id="email"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium">Password</label>
                        @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}"
                                class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                        </div>
                        @endif
                    </div>
                    <div class="mt-2">
                        <x-text-input id="password"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-forms.primary-button>
                        {{ __('Sign In') }}
                    </x-forms.primary-button>
                </div>
            </form>

            <p class="mt-3 text-sm text-center text-gray-500 dark:text-gray-300">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Create an
                    account</a>
            </p>
        </div>
    </div>
</x-guest-layout>
