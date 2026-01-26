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
                    <img src="{{ asset('company_logo/kiaro.ge.png') }}" alt="kiaro.ge logo">
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

                @if($category->children->count() === 0)
                    <a href="{{ route('products', $category->slug) }}"
                       class="category-main">
                        {{ $category->name }}
                    </a>
                @else
                    <div class="category-main">
                        {{ $category->name }}
                    </div>

                    <div class="category-sub">
                        @foreach($category->children as $child)
                            <a href="{{ route('products', $child->slug) }}">
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
                <h3><span><img src="{{ asset('company_logo/kiaro.ge.png') }}" width="100px"> </span></h3>
                <p>
                    <span>KIARO - თქვენი მყუდრო და კომფორტული გარემოსთვის</span>
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
                <p>📧 kiarogeorgia@gmail.com</p>
                <p>📞 +995 501 11 22 55  </p>

                <div class="footer-socials">
                    <a href="https://www.facebook.com/kiarofurniture" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/kiarofurniture" target="_blank"><i class="bi bi-instagram"></i></a>
<a href="https://wa.me/+995501112255" target="_blank">
        <i class="bi bi-whatsapp"></i>
    </a>                </div>
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