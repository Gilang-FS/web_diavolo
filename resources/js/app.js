import "./bootstrap";
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// ========================
// NAVBAR HIDE ON SCROLL
// ========================
let lastScroll = 0;
const header = document.getElementById("header");

if (header) {
    window.addEventListener("scroll", function () {
        let currentScroll = window.pageYOffset;
        if (currentScroll > lastScroll && currentScroll > 100) {
            header.classList.add("hide");
        } else {
            header.classList.remove("hide");
        }
        lastScroll = currentScroll;
    });
}

// ========================
// HERO VIDEO
// ========================
document.addEventListener("DOMContentLoaded", () => {
    const hero = document.getElementById("hero");
    const video = document.getElementById("heroVideo");
    if (!hero || !video) return;
    video.muted = true;
    video.loop = true;
    const heroObserver = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting) {
                video.currentTime = 0;
                video.play().catch(() => {});
            } else {
                video.pause();
            }
        },
        { threshold: 0.3 },
    );
    heroObserver.observe(hero);
});

// ========================
// BANNER — ganti saat klik kategori + dots + auto slide
// ========================
document.addEventListener("DOMContentLoaded", () => {
    const banners = document.querySelectorAll(".banner-item");
    const categoryTabs = document.querySelectorAll(".category-tab");
    const dots = document.querySelectorAll(".banner-dot");
    const categories = ["taekwondo", "karate", "silat", "boxing"];
    let current = 0;
    let autoSlide;

    function switchBanner(category) {
        const index = categories.indexOf(category);
        if (index === -1) return;
        current = index;

        // Update banner
        banners.forEach((banner) => {
            const isActive = banner.dataset.banner === category;
            banner.style.opacity = isActive ? "1" : "0";
            banner.style.transform = isActive ? "scale(1)" : "scale(1.05)";
            banner.style.zIndex = isActive ? "1" : "0";
        });

        // Update dots
        dots.forEach((dot) => {
            const isActive = dot.dataset.banner === category;
            dot.style.width = isActive ? "32px" : "16px";
            dot.style.background = isActive ? "white" : "rgba(255,255,255,0.3)";
        });
    }

    // Klik category tabs
    categoryTabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            switchBanner(tab.dataset.category);
            resetAutoSlide();
        });
    });

    // Klik dots
    dots.forEach((dot) => {
        dot.addEventListener("click", () => {
            switchBanner(dot.dataset.banner);
            resetAutoSlide();
        });
    });

    // Auto slide setiap 4 detik
    function startAutoSlide() {
        autoSlide = setInterval(() => {
            const next = categories[(current + 1) % categories.length];
            switchBanner(next);
        }, 4000);
    }

    function resetAutoSlide() {
        clearInterval(autoSlide);
        startAutoSlide();
    }

    startAutoSlide();
});

// ========================
// CATEGORY TABS + INDICATOR
// ========================
document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".category-tab");
    const groups = document.querySelectorAll(".product-group");
    const indicator = document.querySelector(".category-indicator");
    const sectionTitle = document.getElementById("section-title");

    const categoryNames = {
        taekwondo: "PRODUK TAEKWONDO",
        karate: "PRODUK KARATE",
        silat: "PRODUK SILAT",
        boxing: "PRODUK BOXING",
    };

    function moveIndicator(element) {
        if (!indicator) return;
        const rect = element.getBoundingClientRect();
        const parentRect = element.parentElement.getBoundingClientRect();
        indicator.style.width = rect.width + "px";
        indicator.style.left = rect.left - parentRect.left + "px";
    }

    const activeTab = document.querySelector(".category-tab.active");
    if (activeTab) moveIndicator(activeTab);

    tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            tabs.forEach((t) => t.classList.remove("active"));
            tab.classList.add("active");
            moveIndicator(tab);

            const category = tab.dataset.category;
            if (sectionTitle)
                sectionTitle.textContent =
                    categoryNames[category] || category.toUpperCase();

            groups.forEach((group) => {
                group.style.display = group.id === category ? "block" : "none";
            });
        });
    });

    window.addEventListener("resize", () => {
        const active = document.querySelector(".category-tab.active");
        if (active) moveIndicator(active);
    });
});

// ========================
// SCROLL REVEAL
// ========================
const revealElements = document.querySelectorAll(".reveal");
const revealObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
            } else {
                entry.target.classList.remove("active");
            }
        });
    },
    { threshold: 0.2 },
);
revealElements.forEach((el) => revealObserver.observe(el));

// ========================
// PRODUCT SCROLL BUTTONS
// ========================
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".products-wrapper").forEach((wrapper) => {
        const btnLeft = wrapper.querySelector(".scroll-btn.left");
        const btnRight = wrapper.querySelector(".scroll-btn.right");
        const scrollEl = wrapper.querySelector(".product-scroll");

        if (btnLeft && scrollEl) {
            btnLeft.addEventListener("click", () => {
                scrollEl.scrollBy({ left: -300, behavior: "smooth" });
            });
        }
        if (btnRight && scrollEl) {
            btnRight.addEventListener("click", () => {
                scrollEl.scrollBy({ left: 300, behavior: "smooth" });
            });
        }
    });
});
