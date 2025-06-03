<x-guest-layout>
    <style>
        .forgot-password-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .forgot-password-form p {
            font-size: 0.95rem;
            color: #4b5563;
            background: #f9fafb;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .forgot-password-form label {
            font-weight: 600;
            color: #1f2937;
            display: block;
            margin-bottom: 0.3rem;
        }

        .forgot-password-form input[type="email"] {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 1rem;
            transition: 0.3s;
        }

        .forgot-password-form input:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .forgot-password-form .btn {
            background-color: #6366f1;
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .forgot-password-form .btn:hover {
            background-color: #4f46e5;
        }

        .forgot-password-form .actions {
            display: flex;
            justify-content: flex-end;
        }
    </style>

    <form method="POST" action="{{ route('password.email') }}" class="forgot-password-form">
        @csrf

        <p>
            {{ __('نسيت كلمة المرور؟ مفيش مشكلة، بس اكتب الإيميل بتاعك وهنبعتلك رابط لإعادة تعيين كلمة السر.') }}
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-2" :status="session('status')" />

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Send Button -->
        <div class="actions">
            <button type="submit" class="btn">
                {{ __('Send Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
