<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f1f5f9;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .auth-container {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease-in-out;
        }

        .auth-container:hover {
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #1e293b;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        input[type="email"],
        input[type="password"] {
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 1rem;
            transition: 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .btn {
            padding: 0.75rem;
            background-color: #6366f1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #4f46e5;
        }

        .link {
            text-align: center;
            margin-top: 1rem;
        }

        .link a {
            font-size: 0.9rem;
            color: #6366f1;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        {{ $slot }}
    </div>
</body>
</html>
