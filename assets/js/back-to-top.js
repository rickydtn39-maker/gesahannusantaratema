document.addEventListener('DOMContentLoaded', function () {
    const backToTopBtn = document.querySelector('#back-to-top');
    if (backToTopBtn) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 600) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
        });

        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});