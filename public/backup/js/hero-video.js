document.addEventListener("DOMContentLoaded", () => {
    const hero = document.getElementById("hero");
    const video = document.getElementById("heroVideo");

    if (!hero || !video) return;

    video.muted = true; // 🔥 PAKSA MUTED
    video.autoplay = false;
    video.loop = false;

    const observer = new IntersectionObserver(
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

    observer.observe(hero);
});
