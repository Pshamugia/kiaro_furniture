@extends('layouts.app')

@section('content')

<section class="container section contact">
    <h2 class="section-title decorated-title">
        <span> დაგვიკავშირდი</span>
    </h2>

    @if(session('success'))
        <p style="color:green;margin-bottom:20px;">
            {{ session('success') }}
        </p>
    @endif

    <form class="contact-form"
          method="POST"
          action="{{ route('contact.send') }}">
        @csrf

        <input type="text"
               name="name"
               placeholder="თქვენი სახელი"
               value="{{ old('name') }}"
               required>

        @error('name')
            <div style="color:#c00">{{ $message }}</div>
        @enderror

        <input type="email"
               name="email"
               placeholder="თქვენი ელფოსტა"
               value="{{ old('email') }}"
               required>

        @error('email')
            <div style="color:#c00">{{ $message }}</div>
        @enderror

        <textarea name="message"
                  placeholder="წერილი"
                  rows="5"
                  required>{{ old('message') }}</textarea>

        @error('message')
            <div style="color:#c00">{{ $message }}</div>
        @enderror

        <button type="submit">გამოგზავნა</button>
    </form>
</section>


@endsection
