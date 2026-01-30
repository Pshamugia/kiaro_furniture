@extends('layouts.app')

@section('seo_title', 'ჩვენ შესახებ – KIARO | თანამედროვე ავეჯი')
@section('seo_description', 'KIARO — თანამედროვე დიზაინის ავეჯის საამქრო თბილისში. ხარისხიანი მასალები, სწრაფი წარმოება და კომფორტული დიზაინი.')
@section('seo_image', asset('company_logo/kiaro.ge.png'))

@section('content')
<style>
    /* =========================
   ABOUT – PREMIUM LANDING
========================= */

.about-landing {
    padding-top: 40px;
}

/* HERO */
.about-hero {
    text-align: center;
    margin-bottom: 60px;
}

.about-hero h1 {
    font-size: 38px;
    font-weight: 700;
    line-height: 1.2;
}

.about-hero h1 span {
    color: #666;
}

.about-hero p {
    margin-top: 14px;
    font-size: 18px;
    max-width: 700px;
    margin-inline: auto;
}

/* GRID */
.about-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 40px;
    margin-bottom: 60px;
}

.about-text h3 {
    margin: 28px 0 14px;
    font-size: 22px;
}

.about-note {
    font-weight: 500;
    margin-top: 10px;
}

/* LISTS */
.about-list li {
    margin-bottom: 6px;
}

.about-checklist {
    list-style: none;
    padding-left: 0;
}

.about-checklist li {
    padding-left: 26px;
    position: relative;
    margin-bottom: 10px;
}

.about-checklist li::before {
    content: "✓";
    position: absolute;
    left: 0;
    font-weight: 700;
}

/* INFO CARD */
.about-info-card {
    background: #fff;
    border-radius: 14px;
    padding: 26px;
    box-shadow: 0 8px 30px rgba(0,0,0,.06);
}

.about-info-card h4 {
    font-size: 18px;
    margin-bottom: 8px;
}

.about-info-card hr {
    margin: 18px 0;
    border: none;
    border-top: 1px solid #eee;
}

/* MAP */
.about-map {
    margin-top: 60px;
}

.map-wrapper {
    margin-top: 16px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

.map-wrapper iframe {
    width: 100%;
    height: 360px;
    border: 0;
}

/* FOOTNOTE */
.about-footnote {
    margin-top: 40px;
    font-size: 13px;
    color: #555;
    max-width: 900px;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .about-grid {
        grid-template-columns: 1fr;
    }

    .about-hero h1 {
        font-size: 30px;
    }
}

</style>
<section class="container section about-landing">

    <!-- HERO -->
    <div class="about-hero">
        <h1>მყუდრო სივრცეები<br><span>თანამედროვე დიზაინით</span></h1>
        <p>
            „კიარო" — თანამედროვე დიზაინის ავეჯის საამქრო,
            რომელიც 2025 წლიდან ქმნის კომფორტს თქვენი სახლისთვის.
        </p>
    </div>

    <!-- CONTENT GRID -->
    <div class="about-grid">

        <!-- LEFT -->
        <div class="about-text">

            <h3>რას ვქმნით</h3>
            <ul class="about-list">
                <li>ტელევიზორის მაგიდებს</li>
                <li>შემოსავლელის კარადებს</li>
                <li>წიგნების კარადებს</li>
                <li>ფეხსაცმლის კარადებს</li>
                <li>პატარა მაგიდებს და სხვა</li>
            </ul>

            <p class="about-note">
                უახლოეს მომავალში დაგეგმილია ასორტიმენტის გაფართოება!
            </p>

            <h3>ჩვენი უპირატესობები</h3>
            <ul class="about-checklist">
                <li>ავეჯი მზადდება 3–5 დღეში და მოდის აწყობილ მდგომარეობაში</li>
                <li>მაღალი ხარისხის ლამინატი და თანამედროვე დიზაინი</li>
                <li>საამქროს დათვალიერება წინასწარი შეთანხმებით</li>
                <li>ავეჯის ადგილიდან გატანის შესაძლებლობა</li>
            </ul>

        </div>

        <!-- RIGHT -->
        <div class="about-info-card">
            <h4>მიტანა</h4>
            <p>თბილისი — 30₾</p>
            <p>შემოგარენი / რუსთავი — 50₾</p>
            <p>სართულზე ატანა — 10₾</p>

            <hr>

            <h4>გადახდა</h4>
            <p>ნაღდი ანგარიშსწორება</p>
            <p>საბანკო გადარიცხვა</p>

            <hr>

            <h4>კონტაქტი</h4>
            <p>📍 ქინძმარაულის ქ. 7</p>
            <p>🕐 11:00 – 19:00</p>
            <p>📞 501 11 22 55</p>
        </div>

    </div>

    <!-- MAP -->
    <div class="about-map">
        <h3>გვესტუმრეთ</h3>

        <div class="map-wrapper">
            <iframe
                src="https://www.google.com/maps?q=ქინძმარაულის%20ქუჩა%207%20თბილისი&output=embed"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    <!-- FOOTNOTE -->
    <p class="about-footnote">
        *ჩვენი ავეჯი მზადდება მაღალი ხარისხის ლამინატით (E1 ევროპული სტანდარტი).
        გამოიყენება დაბალი ფორმალდეჰიდის შემცველობის წებოები და მასალა
        შეესაბამება EN 13986 მოთხოვნებს.
    </p>

</section>

@endsection
