document.addEventListener('DOMContentLoaded', function () {
    const searchOpenBtns = document.querySelectorAll('.search-open-trigger');
    const searchModal = document.querySelector('#search-modal');
    const searchCloseBtn = document.querySelector('.search-close-trigger');
    const searchInput = document.querySelector('.search-modal-input');
    let lastActiveElement = null;

    if (searchModal) {
        searchOpenBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                lastActiveElement = document.activeElement; // Simpan elemen aktif terakhir untuk Focus Recovery
                searchModal.classList.add('active');
                searchModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
                
                setTimeout(() => {
                    if (searchInput) searchInput.focus();
                }, 100);
            });
        });

        const closeModal = function () {
            searchModal.classList.remove('active');
            searchModal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            if (lastActiveElement) lastActiveElement.focus(); // Focus Recovery (Aksesibilitas)
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
});