@extends('layouts.app')

@section('content')

<section class="container section contact">
    <h2 class="section-title decorated-title"><span> დაგვიკავშირდი</span></h2>

    <form class="contact-form">
        <input type="text" placeholder="თქვენი სახელი">
        <input type="email" placeholder="თქვენი ელფოსტა">
        <textarea placeholder="წერილი"></textarea>
        <button type="button">გამოგზავნა</button>
    </form>
</section>

@endsection
