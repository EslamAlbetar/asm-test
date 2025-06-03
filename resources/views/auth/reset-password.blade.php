<x-guest-layout>
    <style>
        .reset-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .reset-form label {
            font-weight: 600;
            color: #1f2937;
        }

        .reset-form input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 1rem;
        }

        .reset-form input:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .reset-form .btn {
            background-color: #6366f1;
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        }

        .reset-form .btn:hover {
            background-color: #4f46e5;
        }

        .reset-form .actions {
            display: flex;
            justify-content: flex-end;
        }
    </style>

    <form method="POST" action="{{ route('password.store') }}" class="reset-form">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="actions">
            <button type="submit" class="btn">{{ __('Reset Password') }}</button>
        </div>
    </form>
</x-guest-layout>
