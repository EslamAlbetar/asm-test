<x-guest-layout>
    <style>
        form.auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .auth-form label {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.3rem;
            display: block;
        }

        .auth-form input[type="email"],
        .auth-form input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 1rem;
            transition: 0.3s ease;
        }

        .auth-form input[type="email"]:focus,
        .auth-form input[type="password"]:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .auth-form .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            color: #374151;
        }

        .auth-form input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #6366f1;
        }

        .auth-form .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .auth-form .actions a {
            font-size: 0.9rem;
            color: #6366f1;
            text-decoration: none;
        }

        .auth-form .actions a:hover {
            text-decoration: underline;
        }

        .auth-form .btn {
            background-color: #6366f1;
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .auth-form .btn:hover {
            background-color: #4f46e5;
        }

        .btn-action {
            display: flex;
            flex-direction: column;
        }

        .text-danger {
            color:rgb(201, 65, 65) !important;
        }
    </style>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div>
            <label for="remember_me" class="checkbox-label">
                <input id="remember_me" type="checkbox" name="remember">
                <span>{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="actions">
    <div class="btn-action">
    @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <a class="text-danger" href="{{ route('register') }}">
                {{ __('Not registered yet?') }}
            </a>
    </div>

        



            <button type="submit" class="btn">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>
