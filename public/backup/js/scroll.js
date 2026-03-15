const revealElements = document.querySelectorAll(".reveal");

const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
            } else {
                entry.target.classList.remove("active");
            }
        });
    },
    {
        threshold: 0.2,
    },
);

revealElements.forEach((el) => observer.observe(el));

const scrollContainer = document.getElementById("productScroll");
const btnLeft = document.getElementById("scrollLeft");
const btnRight = document.getElementById("scrollRight");

btnRight.addEventListener("click", () => {
    scrollContainer.scrollBy({
        left: 300,
        behavior: "smooth",
    });
});

btnLeft.addEventListener("click", () => {
    scrollContainer.scrollBy({
        left: -300,
        behavior: "smooth",
    });
});

const frameCount = 240;
const canvas = document.getElementById("hero-canvas");
const context = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const currentFrame = (index) => `/sequence/ezgif-frame-${index}.jpg`;

const images = [];

for (let i = 1; i <= frameCount; i++) {
    const img = new Image();
    img.src = currentFrame(i);
    images.push(img);
}

images[0].onload = function () {
    context.drawImage(images[0], 0, 0, canvas.width, canvas.height);
};

window.addEventListener("scroll", () => {
    const scrollTop = window.scrollY;
    const maxScroll = document.body.scrollHeight - window.innerHeight;
    const scrollFraction = scrollTop / maxScroll;

    const frameIndex = Math.min(
        frameCount - 1,
        Math.floor(scrollFraction * frameCount),
    );

    requestAnimationFrame(() => {
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.drawImage(
            images[frameIndex],
            0,
            0,
            canvas.width,
            canvas.height,
        );
    });
});
