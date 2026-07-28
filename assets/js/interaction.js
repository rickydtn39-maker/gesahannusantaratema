document.addEventListener('DOMContentLoaded', function () {
    // 1. Search Modal Interactions
    const searchOpenBtn = document.querySelector('.search-open-trigger');
    const searchModal = document.querySelector('#search-modal');
    const searchCloseBtn = document.querySelector('.search-close-trigger');
    const searchInput = document.querySelector('.search-modal-input');

    if (searchOpenBtn && searchModal) {
        searchOpenBtn.addEventListener('click', function () {
            searchModal.classList.add('active');
            if (searchInput) searchInput.focus();
        });

        const closeModal = function () {
            searchModal.classList.remove('active');
            searchOpenBtn.focus();
        };

        if (searchCloseBtn) searchCloseBtn.addEventListener('click', closeModal);

        searchModal.addEventListener('click', function (e) {
            if (e.target === searchModal) closeModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && searchModal.classList.contains('active')) {
                closeModal();
            }
        });
    }

    // 2. Back to Top Smooth Scroll
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

    // 3. Sticky Header Shrink
    const siteHeader = document.querySelector('.site-header');
    if (siteHeader) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 100) {
                siteHeader.classList.add('scrolled');
            } else {
                siteHeader.classList.remove('scrolled');
            }
        });
    }

    // 4. TOP DROPDOWN AD POPUP (Volume 4 Bab 29)
    const topDropdownAd = document.querySelector('#top-dropdown-ad');
    const closeDropdownAdBtn = document.querySelector('#top-dropdown-ad-close');

    if (topDropdownAd) {
        setTimeout(function () {
            topDropdownAd.classList.add('active');
        }, 3000);

        if (closeDropdownAdBtn) {
            closeDropdownAdBtn.addEventListener('click', function () {
                topDropdownAd.classList.remove('active');
            });
        }
    }

    // 5. PROGRESS BAR MEMBACA (Reading Progress Bar Logic - High Compatibility)
    const progressBar = document.querySelector('#reading-progress-bar');
    if (progressBar) {
        window.addEventListener('scroll', function () {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            if (docHeight > 0) {
                const scrollPercent = (scrollTop / docHeight) * 100;
                progressBar.style.width = scrollPercent + '%';
            }
        });
    }

    // 6. SINGLE ARTICLE INTERACTIVE FOOTER ACTION TOOLBAR
    const bookmarkBtn = document.querySelector('#utility-bookmark');
    if (bookmarkBtn) {
        bookmarkBtn.addEventListener('click', function (e) {
            e.preventDefault();
            alert('Artikel berhasil disimpan ke daftar bacaan Anda (Simulasi Bookmark).');
        });
    }

    const reportErrorBtn = document.querySelector('#utility-report-error');
    if (reportErrorBtn) {
        reportErrorBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const reportReason = prompt('Silakan tulis kesalahan penulisan atau ejaan pada artikel ini:');
            if (reportReason) {
                alert('Terima kasih atas laporan Anda. Tim Redaksi kami akan segera meninjau kesalahan tersebut.');
            }
        });
    }
});