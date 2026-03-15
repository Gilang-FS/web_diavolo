// ========================
// NAVBAR HIDE ON SCROLL
// ========================
let lastScroll = 0;
const header = document.getElementById("header");

window.addEventListener("scroll", function () {
    let currentScroll = window.pageYOffset;
    if (currentScroll > lastScroll && currentScroll > 100) {
        header.classList.add("hide");
    } else {
        header.classList.remove("hide");
    }
    lastScroll = currentScroll;
});

// ========================
// HERO VIDEO
// ========================
document.addEventListener("DOMContentLoaded", () => {
    const hero = document.getElementById("hero");
    const video = document.getElementById("heroVideo");

    if (!hero || !video) return;

    video.muted = true;
    video.autoplay = false;
    video.loop = false;

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
// BANNER — ganti saat klik kategori
// ========================
const categoryTabs = document.querySelectorAll(".category-tab");
const banners = document.querySelectorAll(".banner-item");

categoryTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
        const category = tab.dataset.category;
        banners.forEach((banner) => {
            banner.classList.toggle(
                "active",
                banner.dataset.banner === category,
            );
        });
    });
});

// ========================
// MANIFESTO ANIMATION
// ========================
document.addEventListener("DOMContentLoaded", function () {
    const title = document.querySelector(".manifesto-title");
    if (!title) return;

    const spans = title.querySelectorAll("span");

    const manifestoObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    spans.forEach((span, index) => {
                        setTimeout(
                            () => span.classList.add("active"),
                            index * 200,
                        );
                    });
                } else {
                    spans.forEach((span) => span.classList.remove("active"));
                }
            });
        },
        { threshold: 0.4 },
    );

    manifestoObserver.observe(title);

    // manifesto text reveal
    const text = document.querySelector(".manifesto-text");
    if (text) {
        function revealText() {
            const rect = text.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100) {
                text.classList.add("active");
            }
        }
        window.addEventListener("scroll", revealText);
        revealText();
    }
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

            if (sectionTitle) {
                sectionTitle.textContent =
                    categoryNames[category] || category.toUpperCase();
            }

            groups.forEach((group) => {
                if (group.id === category) {
                    group.style.display = "block";
                } else {
                    group.style.display = "none";
                }
            });

            banners.forEach((banner) => {
                const isActive = banner.dataset.banner === category;
                banner.style.opacity = isActive ? "1" : "0";
                banner.style.transform = isActive ? "scale(1)" : "scale(1.05)";
                banner.style.zIndex = isActive ? "1" : "0";
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
