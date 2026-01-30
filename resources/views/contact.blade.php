@extends('layouts.app')

@section('content')

<section class="container section contact">
    <style>
     /* =========================
   CONTACT – CTA BUTTONS
========================= */

.contact-cta {
    display: flex;
    justify-content: center;
    gap: 14px;
    margin: 22px 0 32px;
    flex-wrap: wrap;
}

/* COMMON */
.contact-cta a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 999px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all .25s ease;
}

/* CALL */
.cta-call {
    background: #111;
    color: #fff;
}

.cta-call:hover {
    background: #000;
    transform: translateY(-1px);
}

/* WHATSAPP */
.cta-whatsapp {
    background: #25D366;
    color: #fff;
}

.cta-whatsapp:hover {
    background: #1ebe5d;
    transform: translateY(-1px);
}

.contact-cta i {
    font-size: 18px;
}

/* Mobile */
@media (max-width: 600px) {
    .contact-cta a {
        padding: 11px 18px;
        font-size: 14px;
    }
}


/* =========================
   CONTACT – SUBMIT SPINNER
========================= */

.submit-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 26px;
    border-radius: 999px;
    border: none;
    background: #111;
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity .25s ease;
}

.submit-btn:disabled {
    opacity: .7;
    cursor: not-allowed;
}

/* spinner hidden by default */
.btn-spinner {
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255,255,255,.4);
    border-top-color: #fff;
    border-radius: 50%;
    display: none;
    animation: spin .7s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* loading state */
.submit-btn.loading .btn-text {
    opacity: .85;
}

.submit-btn.loading .btn-spinner {
    display: inline-block;
}



    </style>
    <div class="contact-cta">
    <a href="tel:+995501112255" class="cta-call">
        <i class="bi bi-telephone-fill"></i>
        <span>დაგვირეკე</span>
    </a>

    <a href="https://wa.me/995501112255" target="_blank" class="cta-whatsapp">
        <i class="bi bi-whatsapp"></i>
        <span>WhatsApp</span>
    </a>
</div>



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

        <button type="submit" class="submit-btn">
    <span class="btn-text">გამოგზავნა</span>
    <span class="btn-spinner"></span>
</button>

    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.contact-form');
    const button = form.querySelector('.submit-btn');

    form.addEventListener('submit', function () {
        button.classList.add('loading');
        button.disabled = true;
    });
});
</script>

@endsection
