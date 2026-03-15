const categoryTabs = document.querySelectorAll(".category-tab");
const banners = document.querySelectorAll(".banner-item");

categoryTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
        const category = tab.dataset.category;

        // ganti banner
        banners.forEach((banner) => {
            banner.classList.toggle(
                "active",
                banner.dataset.banner === category,
            );
        });
    });
});
