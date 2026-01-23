const slides = document.querySelectorAll('.slide');
const prevBtn = document.getElementById('prevSlide');
const nextBtn = document.getElementById('nextSlide');
const slider = document.getElementById('slider');
const dotsContainer = document.getElementById('sliderDots');

let index = 0;
let interval;
let startX = 0;

/* ===========================
   CORE FUNCTIONS
=========================== */

function showSlide(i) {
    slides.forEach((slide, idx) => {
        slide.classList.remove('active');
        dots[idx].classList.remove('active');
    });

    slides[i].classList.add('active');
    dots[i].classList.add('active');
}

function nextSlide() {
    index = (index + 1) % slides.length;
    showSlide(index);
}

function prevSlide() {
    index = (index - 1 + slides.length) % slides.length;
    showSlide(index);
}

function startSlider() {
    interval = setInterval(nextSlide, 5000);
}

function stopSlider() {
    clearInterval(interval);
}

function resetSlider() {
    stopSlider();
    startSlider();
}

/* ===========================
   ARROWS
=========================== */

prevBtn.onclick = () => { prevSlide(); resetSlider(); };
nextBtn.onclick = () => { nextSlide(); resetSlider(); };

/* ===========================
   PAGINATION DOTS
=========================== */

let dots = [];

slides.forEach((_, i) => {
    const dot = document.createElement('div');
    dot.className = 'slider-dot';
    dot.onclick = () => {
        index = i;
        showSlide(index);
        resetSlider();
    };
    dotsContainer.appendChild(dot);
    dots.push(dot);
});

/* ===========================
   SWIPE SUPPORT
=========================== */

slider.addEventListener('touchstart', e => {
    startX = e.touches[0].clientX;
});

slider.addEventListener('touchend', e => {
    const endX = e.changedTouches[0].clientX;
    const diff = startX - endX;

    if (Math.abs(diff) > 50) {
        diff > 0 ? nextSlide() : prevSlide();
        resetSlider();
    }
});

/* ===========================
   PARALLAX (DESKTOP)
=========================== */

slider.addEventListener('mousemove', e => {
    const rect = slider.getBoundingClientRect();
    const x = (e.clientX / rect.width - 0.5) * 2;
    const y = (e.clientY / rect.height - 0.5) * 2;

    const active = document.querySelector('.slide.active');
    if (!active) return;

    active.querySelectorAll('[data-depth]').forEach(el => {
        const depth = el.dataset.depth;
        el.style.transform = `translate(${x * depth * 20}px, ${y * depth * 20}px)`;
    });
});

slider.addEventListener('mouseleave', () => {
    document.querySelectorAll('[data-depth]').forEach(el => {
        el.style.transform = 'translate(0,0)';
    });
});

/* ===========================
   AUTO-PAUSE ON HOVER
=========================== */

slider.addEventListener('mouseenter', stopSlider);
slider.addEventListener('mouseleave', startSlider);

/* ===========================
   INIT
=========================== */

showSlide(index);
startSlider();



const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');

if (hamburger) {
    hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('show');
    });

    // Close menu on link click (mobile UX)
    navMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('show');
        });
    });
}




/* ===========================
   MOBILE DROPDOWN TOGGLE
=========================== */

document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('click', (e) => {

        // MOBILE ONLY
        if (window.innerWidth > 768) return;

        e.preventDefault();

        const parent = toggle.closest('.nav-dropdown');
        parent.classList.toggle('open');
    });
});


function copyProductLink() {
    navigator.clipboard.writeText(window.location.href)
        .then(() => {
            alert('ლინკი დაკოპირდა');
        })
        .catch(() => {
            alert('ვერ მოხერხდა კოპირება');
        });
}