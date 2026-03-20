document.addEventListener("DOMContentLoaded", () => {

    const track = document.getElementById("carouselTrack");
    const next = document.querySelector(".next");
    const prev = document.querySelector(".prev");

    function getScrollAmount() {
        const logo = track.querySelector(".logo");
        return (logo.offsetWidth + 20) * 3;
    }

    function smoothScroll(element, target, duration = 500) {
        const start = element.scrollLeft;
        const change = target - start;
        const startTime = performance.now();

        function animateScroll(currentTime) {
            const timeElapsed = currentTime - startTime;
            const progress = Math.min(timeElapsed / duration, 1);

            const ease = progress < 0.5
                ? 2 * progress * progress
                : 1 - Math.pow(-2 * progress + 2, 2) / 2;

            element.scrollLeft = start + change * ease;

            if (timeElapsed < duration) {
                requestAnimationFrame(animateScroll);
            }
        }

        requestAnimationFrame(animateScroll);
    }

    next.addEventListener("click", () => {
        smoothScroll(track, track.scrollLeft + getScrollAmount(), 600);
    });

    prev.addEventListener("click", () => {
        smoothScroll(track, track.scrollLeft - getScrollAmount(), 600);
    });

});