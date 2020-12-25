<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('img/logo.png') }}" height="110px" width="100px" />
        </x-slot>



        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class='text-red-600'>{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" required/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Mật khẩu') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required/>
            </div>

            <div class="flex items-center mt-4 justify-between">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Nhớ mật khẩu') }}</span>
                </label>
            </div>

            <div class="flex items-center mt-4 justify-end">
                <x-jet-button class="ml-4">
                    {{ __('Đăng nhập') }}
                </x-jet-button>
            </div>


        </form>
    </x-jet-authentication-card>
</x-guest-layout>
