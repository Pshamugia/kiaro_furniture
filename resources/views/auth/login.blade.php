@extends('layouts.app')

@section('content')
<div class="container" style="max-width:420px">
    <h2>Admin Login</h2>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div style="margin-bottom:15px">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div style="margin-bottom:15px">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    @if ($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif
</div>
@endsection
