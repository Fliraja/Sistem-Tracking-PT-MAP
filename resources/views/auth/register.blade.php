<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Alamat -->
        <div class="mt-4">
            <x-input-label for="alamat" :value="__('Alamat')" />
            <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" autofocus autocomplete="alamat" />
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <!-- No. Hp -->
        <div class="mt-4">
            <x-input-label for="no_hp" :value="__('No. HP')" />
            <x-text-input id="no_hp" class="block mt-1 w-full" type="number" name="no_hp" :value="old('no_hp')" autofocus autocomplete="no_hp" />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Role')" />
            {{-- <x-text-input id="name" class="block mt-1 w-full" type="text" name="role" :value="old('role')" required autocomplete="username" /> --}}
            <select id="role" name="role"
                class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
                <option value="supir" {{ old('role') == 'supir' ? 'selected' : '' }}>
                    Supir
                </option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        {{-- Foto Sim --}}
        <div class="mt-4">
            <x-input-label for="foto_sim" value="Foto SIM" />
            <input type="file" accept="image/*" name="foto_sim" id="foto_sim" class="block w-full mt-1 text-sm text-gray-300">
            <x-input-error :messages="$errors->get('foto_sim')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('users.index') }}">
                {{ __('Batal') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
