<x-guest-layout>
    <div class="flex flex-col justify-center min-h-full px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <div>
                <a class="flex justify-center" href="/">
                    <x-application-logo class="text-indigo-600 fill-current size-10" />
                </a>
            </div>
            <h2 class="mt-3 text-2xl font-bold tracking-tight text-center text-gray-900">Create a new account</h2>
        </div>

        <div class="mt-3 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                    <div class="mt-2">
                        <x-text-input id="name"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <x-text-input id="email"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <x-text-input id="password"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900">Confirm
                            Password</label>
                    </div>
                    <div class="mt-2">
                        <x-text-input id="password_confirmation"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
                </div>
            </form>

            <p class="mt-3 text-sm text-center text-gray-500">
                Already registered?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Log in</a>
            </p>
        </div>
    </div>
</x-guest-layout>