
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

            <div class="form-group mb-3">
        <label> Name</label>
        <input name="name" value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>



    <div class="form-group mb-3">
        <label> Email</label>
        <input name="email" value="{{ old('email') }}" type="text" class="form-control @error('email') is-invalid @enderror">
        @error('email')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label> Phone</label>
        <input name="phone" value="{{ old('phone') }}" type="text" placeholder="059-xxxxxxx" class="form-control @error('phone') is-invalid @enderror">
        @error('phone')
        <p class="invalid-feedback">{{$message}}</p>   
              @enderror
    </div>

        <!-- Password -->
        <div class="form-group mb-3">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="form-control @error('phone') is-invalid @enderror"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                                @error('password')
                               <p class="invalid-feedback">{{$message}}</p>   
                                @enderror                
            </div>

            <!-- Confirm Password -->
            <div class="form-group mb-3">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="form-control @error('phone') is-invalid @enderror"
                                type="password"
                                name="password_confirmation" required />

                                @error('password_confirmation')
                              <p class="invalid-feedback">{{$message}}</p>   
                              @enderror
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
