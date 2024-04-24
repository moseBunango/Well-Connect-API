<x-guest-layout>




    <div>
        <a href="/">
           Well-Connect Admin Register
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">



    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4"  style="display: none;">
            <x-input-label for="location" :value="__('userType')" />
            <x-text-input class="block mt-1 w-full" type="text" name="userType" value="1" />
            {{-- <x-input-error :messages="$errors->get('location')" class="mt-2" /> --}}
        </div>

        {{-- <div class="mt-4">
            <x-input-label for="location" :value="__('location')" />
            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div> --}}

       <!-- Image Upload -->
{{-- <div class="mt-4">
    <x-input-label for="file" :value="__('Add Image')" />
    <label for="file" class="cursor-pointer block w-full py-2 px-4 bg-gray-200 text-gray-700 rounded-md text-center hover:bg-gray-300 hover:text-gray-800">
        <span id="selectedImage">Choose an image</span>
        <input id="file" type="file" name="file" class="hidden" accept="image/*" onchange="updateSelectedImage(this)">
    </label>
    <x-input-error :messages="$errors->get('file')" class="mt-2" />
</div> --}}

        <!-- Password -->
        <div class="mt-4">

            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    </div>





    <script>
    function updateSelectedImage(input) {
        const span = document.getElementById('selectedImage');
        if (input.files && input.files[0]) {
            span.textContent = input.files[0].name;
        } else {
            span.textContent = 'Choose an image';
        }
    }
</script>

</x-guest-layout>
