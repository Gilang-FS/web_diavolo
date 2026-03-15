document.addEventListener("DOMContentLoaded", function () {
    const title = document.querySelector(".manifesto-title");

    if (!title) return;

    const spans = title.querySelectorAll("span");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    // PLAY ANIMATION
                    spans.forEach((span, index) => {
                        setTimeout(() => {
                            span.classList.add("active");
                        }, index * 200);
                    });
                } else {
                    // RESET ANIMATION
                    spans.forEach((span) => {
                        span.classList.remove("active");
                    });
                }
            });
        },
        {
            threshold: 0.4,
        },
    );

    observer.observe(title);
});

document.addEventListener("DOMContentLoaded", function () {
    const text = document.querySelector(".manifesto-text");

    function revealText() {
        const rect = text.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        if (rect.top < windowHeight - 100) {
            text.classList.add("active");
        }
    }

    window.addEventListener("scroll", revealText);
    revealText();
});

const tabs = document.querySelectorAll(".category-tab");
const groups = document.querySelectorAll(".product-group");

tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
        tabs.forEach((t) => t.classList.remove("active"));
        tab.classList.add("active");

        const category = tab.dataset.category;

        groups.forEach((group) => {
            group.classList.remove("active");
            if (group.id === category) {
                group.classList.add("active");
            }
        });
    });
});

const tab = document.querySelectorAll(".category-tab");
const indicator = document.querySelector(".category-indicator");

function moveIndicator(element) {
    const rect = element.getBoundingClientRect();
    const parentRect = element.parentElement.getBoundingClientRect();

    indicator.style.width = rect.width + "px";
    indicator.style.left = rect.left - parentRect.left + "px";
}

// initial position
const activeTab = document.querySelector(".category-tab.active");
moveIndicator(activeTab);

tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
        tabs.forEach((t) => t.classList.remove("active"));
        tab.classList.add("active");

        moveIndicator(tab);
    });
});

// update on resize
window.addEventListener("resize", () => {
    const active = document.querySelector(".category-tab.active");
    moveIndicator(active);
});
