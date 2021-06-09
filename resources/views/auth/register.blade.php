<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="form-group mb-3">
        <label> Phone</label>
        <input name="phone" value="{{ old('phone') }}" type="text" class="form-control @error('phone') is-invalid @enderror">
        @error('phone')
        <p class="invalid-feedback">{{$message}}</p>         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Gender:</label>
        <div>
            <label> <input type="radio" name="gender" value=" male" @if(old('status')=='male') checked @endif> Male</label>
            <label> <input type="radio" name="gender" value="female"  @if(old('status')=='female') checked @endif> Female</label>
        </div>
        @error('gender')
        <p class="alert-warning ">{{$message}}</p>
                 @enderror
    </div>


    <div class="form-group mb-3">
        <label>Birth Date</label>
        <input name="birth_date" value="{{ old('birth_date') }}" type="text" id="date" class="form-control @error('birth_date') is-invalid @enderror">
        <span class="form-text text-muted">YYYY-MM-DD</span>
        @error('birth_date')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
