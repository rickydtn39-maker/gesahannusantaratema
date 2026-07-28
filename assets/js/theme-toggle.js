(function () {
    const currentTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (currentTheme === 'dark' || (!currentTheme && systemPrefersDark)) {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const themeBtn = document.querySelector('.theme-toggle-btn');
        if (themeBtn) {
            themeBtn.addEventListener('click', function () {
                let theme = document.documentElement.getAttribute('data-theme');
                let newTheme = (theme === 'dark') ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);

                const event = new CustomEvent('gesahanDarkModeChanged', { detail: { theme: newTheme } });
                document.dispatchEvent(event);
            });
        }
    });
})();