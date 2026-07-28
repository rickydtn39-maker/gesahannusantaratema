document.addEventListener('DOMContentLoaded', function () {
    const accordionCards = document.querySelectorAll('.footer-col-card');

    if (accordionCards.length > 0 && window.innerWidth < 992) {
        accordionCards.forEach(function (card) {
            const title = card.querySelector('.footer-section-title');
            let body = card.querySelector('.footer-col-body') || card.querySelector('.footer-widget');

            if (title && body) {
                // Sembunyikan konten secara default
                if (body.classList.contains('footer-widget')) {
                    Array.from(body.children).forEach(function(child) {
                        if (!child.classList.contains('footer-section-title')) {
                            child.style.display = 'none';
                        }
                    });
                } else {
                    body.style.display = 'none';
                }

                title.addEventListener('click', function () {
                    const isOpen = card.classList.contains('active');
                    
                    // Tutup panel lain
                    accordionCards.forEach(function (c) {
                        c.classList.remove('active');
                        let b = c.querySelector('.footer-col-body') || c.querySelector('.footer-widget');
                        if (b) {
                            if (b.classList.contains('footer-widget')) {
                                Array.from(b.children).forEach(function(child) {
                                    if (!child.classList.contains('footer-section-title')) {
                                        child.style.display = 'none';
                                    }
                                });
                            } else {
                                b.style.display = 'none';
                            }
                        }
                    });

                    // Buka panel yang diklik
                    if (!isOpen) {
                        card.classList.add('active');
                        if (body.classList.contains('footer-widget')) {
                            Array.from(body.children).forEach(function(child) {
                                if (!child.classList.contains('footer-section-title')) {
                                    child.style.display = 'block';
                                }
                            });
                        } else {
                            body.style.display = 'block';
                        }
                    }
                });
            }
        });
    }
});