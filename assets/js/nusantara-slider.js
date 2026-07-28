document.addEventListener('DOMContentLoaded', function () {
    // ==========================================================================
    // 1. ENGINE AUTOMATIC SLIDER: NUSANTARA TERKINI
    // ==========================================================================
    const nContainer = document.querySelector('.nusantara-slider-container');
    const nTrack = document.querySelector('.nusantara-slider-track');
    const nPrevBtn = document.querySelector('.nusantara-prev-btn');
    const nNextBtn = document.querySelector('.nusantara-next-btn');

    if (nContainer && nTrack) {
        let nSlides = document.querySelectorAll('.nusantara-slide-card');
        if (nSlides.length > 0) {
            let nIndex = 0;
            let nInterval = null;
            const nDelay = 4000; // Siklus 4 detik

            function getVisibleSlidesCount() {
                const width = window.innerWidth;
                if (width > 991) return 4;
                if (width > 567) return 2;
                return 1;
            }

            function moveNusantaraSlider() {
                const visible = getVisibleSlidesCount();
                const maxIndex = nSlides.length - visible;

                if (nIndex > maxIndex) {
                    nIndex = 0;
                } else if (nIndex < 0) {
                    nIndex = maxIndex;
                }

                const slideWidth = nSlides[0].getBoundingClientRect().width;
                const gap = 16;
                const offset = nIndex * (slideWidth + gap);

                nTrack.style.transform = `translateX(-${offset}px)`;
            }

            function nNext() {
                nIndex++;
                moveNusantaraSlider();
            }

            function nPrev() {
                nIndex--;
                moveNusantaraSlider();
            }

            function startNInterval() {
                stopNInterval();
                nInterval = setInterval(nNext, nDelay);
            }

            function stopNInterval() {
                if (nInterval) clearInterval(nInterval);
            }

            if (nNextBtn) {
                nNextBtn.addEventListener('click', function () {
                    nNext();
                    startNInterval();
                });
            }

            if (nPrevBtn) {
                nPrevBtn.addEventListener('click', function () {
                    nPrev();
                    startNInterval();
                });
            }

            nContainer.addEventListener('mouseenter', stopNInterval);
            nContainer.addEventListener('mouseleave', startNInterval);
            nContainer.addEventListener('focusin', stopNInterval);
            nContainer.addEventListener('focusout', startNInterval);

            window.addEventListener('resize', moveNusantaraSlider);
            startNInterval();
        }
    }
});