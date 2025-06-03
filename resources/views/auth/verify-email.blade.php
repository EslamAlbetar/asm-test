<x-guest-layout>
    <style>
        .verify-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .verify-wrapper p {
            font-size: 0.95rem;
            color: #4b5563;
            background: #f9fafb;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .verify-wrapper .success-msg {
            font-weight: 600;
            color: #15803d;
        }

        .verify-wrapper .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .verify-wrapper .btn {
            background-color: #6366f1;
            color: white;
            padding: 0.6rem 1.4rem;
            border-radius: 8px;
            font-size: 1rem;
            border: none;
            cursor: pointer;
        }

        .verify-wrapper .btn:hover {
            background-color: #4f46e5;
        }

        .verify-wrapper .logout-btn {
            font-size: 0.9rem;
            color: #4b5563;
            text-decoration: underline;
            cursor: pointer;
        }

        .verify-wrapper .logout-btn:hover {
            color: #1f2937;
        }
    </style>

    <div class="verify-wrapper">
        <p>
            {{ __('شكراً لتسجيلك! من فضلك فعل الإيميل من خلال الرابط اللي بعتناه على بريدك الإلكتروني. لو الرسالة ما وصلتك، ممكن نبعتهالك تاني.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="success-msg">
                {{ __('تم إرسال رابط تفعيل جديد لبريدك الإلكتروني.') }}
            </div>
        @endif

        <div class="actions">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn">{{ __('Resend Email') }}</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">{{ __('Logout') }}</button>
            </form>
        </div>
    </div>
</x-guest-layout>
