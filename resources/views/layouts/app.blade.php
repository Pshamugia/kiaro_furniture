<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ავეჯის მაღაზია</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('company_logo/favicon.ico') }}" type="image/x-icon">
</head>

<body>

    <header class="navbar">
        <div class="container nav-inner">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('company_logo/kiaro.ge.jpg') }}" alt="kiaro.ge logo">
                </a>
            </div>




            <!-- Navigation -->




            <nav id="navMenu">
                <a href="{{ route('home') }}"><span> საწყისი </span></a>

                <div class="nav-dropdown nav-categories">
    <span class="nav-link dropdown-toggle">
        პროდუქცია
        <i class="bi bi-chevron-down"></i>
    </span>

    <div class="categories-menu">
        @foreach($menuCategories as $category)
            <div class="category-item">
                <a href="{{ route('products', ['category' => $category->id]) }}"
                   class="category-main">
                    <span style="padding-left:20px;">{{ $category->name }}</span>
                </a>

                @if($category->children->count())
                    <div class="category-sub">
                        @foreach($category->children as $child)
                            <a href="{{ route('products', ['category' => $child->id]) }}">
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>


                <a href="{{ route('about') }}"><span> ჩვენ შესახებ</span></a>

                <a href="{{ route('contact') }}"><span>კონტაქტი</span></a>
            </nav>

            <!-- SEARCH -->
            <form class="nav-search" action="{{ route('search') }}" method="GET">
                <input
                    type="text"
                    name="q"
                    placeholder="ძიება…"
                    aria-label="Search products">
                <button type="submit" aria-label="Search">
                    <svg viewBox="0 0 24 24">
                        <path d="M21 21l-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"
                            fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </button>
            </form>

            <!-- Hamburger -->
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>


        </div>
    </header>


    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer-inner">

            <!-- Brand -->
            <div class="footer-brand">
                <h3><span><img src="{{ asset('company_logo/kiaro.ge.jpg') }}" width="100px"> </span></h3>
                <p>
                    <span>თანამედროვე ავეჯი, შექმნილი კომფორტისა და ელეგანტურობისთვის.</span>
                </p>
            </div>

            <!-- Navigation -->
            <div class="footer-links">
                <h4>ნავიგაცია</h4>
                <a href="{{ route('home') }}"><span>საწყისი</span></a>
                <a href="{{ route('products') }}"><span>პროდუქცია</span></a>
                <a href="{{ route('about') }}"><span>ჩვენ შესახებ</span></a>
                <a href="{{ route('contact') }}"><span>კონტაქტი</span></a>
            </div>

            <!-- Contact -->
            <div class="footer-contact">
                <h4>კონტაქტი</h4>
                <p>📧 info@kiaro.ge</p>
                <p>📞 +995 555 55 55 55</p>

                <div class="footer-socials">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

        </div>

        <!-- Bottom -->
        <div class="footer-bottom">
            <span> © {{ date('Y') }} kiaro.ge • ყველა უფლება დაცულია</span>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>