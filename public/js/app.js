/**
 * public/js/app.js
 * Safe global JS: runs on every page without crashing.
 */
document.addEventListener('DOMContentLoaded', () => {

  /* =========================================================
     1) SLIDER (homepage only)
  ========================================================== */

  const slider = document.getElementById('slider');
  const slides = document.querySelectorAll('.slide');
  const prevBtn = document.getElementById('prevSlide');
  const nextBtn = document.getElementById('nextSlide');
  const dotsContainer = document.getElementById('sliderDots');

  if (slider && slides.length && prevBtn && nextBtn && dotsContainer) {
    let index = 0;
    let interval = null;
    let startX = 0;
    let dots = [];

    function showSlide(i) {
      slides.forEach((slide, idx) => {
        slide.classList.toggle('active', idx === i);
        if (dots[idx]) dots[idx].classList.toggle('active', idx === i);
      });
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
      stopSlider();
      interval = setInterval(nextSlide, 5000);
    }

    function stopSlider() {
      if (interval) clearInterval(interval);
      interval = null;
    }

    function resetSlider() {
      stopSlider();
      startSlider();
    }

    // Arrows
    prevBtn.addEventListener('click', () => { prevSlide(); resetSlider(); });
    nextBtn.addEventListener('click', () => { nextSlide(); resetSlider(); });

    // Dots
    dotsContainer.innerHTML = '';
    dots = [];
    slides.forEach((_, i) => {
      const dot = document.createElement('div');
      dot.className = 'slider-dot';
      dot.addEventListener('click', () => {
        index = i;
        showSlide(index);
        resetSlider();
      });
      dotsContainer.appendChild(dot);
      dots.push(dot);
    });

    // Swipe
    slider.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
    });

    slider.addEventListener('touchend', (e) => {
      const endX = e.changedTouches[0].clientX;
      const diff = startX - endX;

      if (Math.abs(diff) > 50) {
        diff > 0 ? nextSlide() : prevSlide();
        resetSlider();
      }
    });

    // Parallax (desktop only)
    slider.addEventListener('mousemove', (e) => {
      const rect = slider.getBoundingClientRect();
      const x = (e.clientX / rect.width - 0.5) * 2;
      const y = (e.clientY / rect.height - 0.5) * 2;

      const active = document.querySelector('.slide.active');
      if (!active) return;

      active.querySelectorAll('[data-depth]').forEach(el => {
        const depth = Number(el.dataset.depth || 0);
        el.style.transform = `translate(${x * depth * 20}px, ${y * depth * 20}px)`;
      });
    });

    slider.addEventListener('mouseleave', () => {
      document.querySelectorAll('[data-depth]').forEach(el => {
        el.style.transform = 'translate(0,0)';
      });
    });

    // Auto-pause on hover
    slider.addEventListener('mouseenter', stopSlider);
    slider.addEventListener('mouseleave', startSlider);

    // Init
    showSlide(index);
    startSlider();
  }

  /* =========================================================
     2) HAMBURGER MENU (header)
  ========================================================== */
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');
const navCategories = document.querySelector('.nav-categories');

if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('show');
    });
}

/* MOBILE: categories accordion */
if (navCategories) {
    const mainToggle = navCategories.querySelector('.category-main');

    mainToggle?.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            e.preventDefault();
            navCategories.classList.toggle('open');
        }
    });
}

/* MOBILE: subcategories accordion */
document.querySelectorAll('.category-item > .category-main').forEach(link => {
    link.addEventListener('click', (e) => {
        if (window.innerWidth > 768) return;

        const parent = link.closest('.category-item');
        const sub = parent?.querySelector('.category-sub');

        if (sub) {
            e.preventDefault();
            parent.classList.toggle('open');
        }
    });
});




  /* =========================================================
     3) MOBILE DROPDOWN TOGGLE
  ========================================================== */

  document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('click', (e) => {
      if (window.innerWidth > 768) return; // mobile only
      e.preventDefault();

      const parent = toggle.closest('.nav-dropdown');
      if (parent) parent.classList.toggle('open');
    });
  });

  /* =========================================================
     4) COPY LINK (share)
  ========================================================== */

  window.copyProductLink = function () {
    navigator.clipboard.writeText(window.location.href)
      .then(() => alert('ლინკი დაკოპირდა'))
      .catch(() => alert('ვერ მოხერხდა კოპირება'));
  };

  /* =========================================================
     5) ORDER MODAL HELPERS (product page)
     - Safe even if modal does not exist.
  ========================================================== */

  window.openOrderModal = function () {
    const modal = document.getElementById('orderModal');
    if (!modal) return;
    modal.style.display = 'flex';
  };

  window.closeOrderModal = function () {
    const modal = document.getElementById('orderModal');
    if (!modal) return;
    modal.style.display = 'none';
  };

  const orderModal = document.getElementById('orderModal');
  if (orderModal) {
    orderModal.addEventListener('click', (e) => {
      if (e.target === orderModal) {
        window.closeOrderModal();
      }
    });
  }
});




 



