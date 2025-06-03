<x-guest-layout>
    <style>
        .confirm-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .confirm-form p {
            font-size: 0.95rem;
            color: #4b5563;
            background: #f9fafb;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .confirm-form label {
            font-weight: 600;
            color: #1f2937;
        }

        .confirm-form input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 1rem;
        }

        .confirm-form input:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .confirm-form .btn {
            background-color: #6366f1;
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        }

        .confirm-form .btn:hover {
            background-color: #4f46e5;
        }

        .confirm-form .actions {
            display: flex;
            justify-content: flex-end;
        }
    </style>

    <form method="POST" action="{{ route('password.confirm') }}" class="confirm-form">
        @csrf

        <p>
            {{ __('دي منطقة مؤمنة من الموقع، من فضلك أكد كلمة المرور عشان تكمل.') }}
        </p>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="actions">
            <button type="submit" class="btn">{{ __('Confirm') }}</button>
        </div>
    </form>
</x-guest-layout>
