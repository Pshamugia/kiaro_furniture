@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #ffffff, #afbfda);
        min-height: 100vh;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        padding: 40px 35px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
    }

    .login-title {
        font-size: 26px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 10px;
        color: #111827;
    }

    .login-subtitle {
        text-align: center;
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        font-size: 15px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        transition: all 0.2s ease;
        background: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .login-btn {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: none;
        font-size: 16px;
        font-weight: 600;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        cursor: pointer;
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .login-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
    }

    .login-error {
        margin-top: 15px;
        padding: 12px;
        border-radius: 10px;
        background: #fee2e2;
        color: #991b1b;
        font-size: 14px;
        text-align: center;
    }

    .brand {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 700;
        letter-spacing: 1px;
        color: #2563eb;
        font-size: 14px;
        text-transform: uppercase;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">

        <div class="brand">
            Admin Panel
        </div>

        <h2 class="login-title">Welcome Back</h2>
        <p class="login-subtitle">
            Sign in to manage the system
        </p>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Email address"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Password"
                    required
                >
            </div>

            <button type="submit" class="login-btn">
                Log in
            </button>
        </form>

        @if ($errors->any())
            <div class="login-error">
                {{ $errors->first() }}
            </div>
        @endif

    </div>
</div>
@endsection
