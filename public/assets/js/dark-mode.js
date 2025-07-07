(function () {
    'use strict';

    const THEME_KEY = 'kostash_theme';

    function applyTheme(theme) {
        const html = document.documentElement;
        if (theme === 'dark') {
            html.setAttribute('data-bs-theme', 'dark');
            html.setAttribute('data-layout-mode', 'dark');
        } else {
            html.setAttribute('data-bs-theme', 'light');
            html.setAttribute('data-layout-mode', 'light');
        }
    }

    function applyInitialTheme() {
        const savedTheme = localStorage.getItem(THEME_KEY);
        if (savedTheme) {
            applyTheme(savedTheme);
            return;
        }
        
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(prefersDark ? 'dark' : 'light');
    }

    applyInitialTheme();
    
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.querySelector(
            '.light-dark-mode, .btn-light-dark, .dark-mode-toggle, [data-toggle="dark-mode"]'
        );

        if (!toggleButton) return;

        function updateIcon(theme) {
            const iconElement = toggleButton.querySelector('i');
            if (!iconElement) return;

            const isDark = theme === 'dark';
            iconElement.classList.toggle('bx-moon', !isDark);
            iconElement.classList.toggle('bx-sun', isDark);
            iconElement.classList.toggle('ri-moon-line', !isDark);
            iconElement.classList.toggle('ri-sun-line', isDark);
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            applyTheme(newTheme);
            updateIcon(newTheme);
            localStorage.setItem(THEME_KEY, newTheme);
        }

        updateIcon(document.documentElement.getAttribute('data-bs-theme'));

        toggleButton.addEventListener('click', function(e) {
            e.preventDefault();
            toggleTheme();
        });
    });
    
    window.addEventListener('storage', function(e) {
        if (e.key === THEME_KEY && e.newValue) {
            applyTheme(e.newValue);
            
            const toggleButton = document.querySelector('.light-dark-mode, .btn-light-dark');
            if(toggleButton) {
                const iconElement = toggleButton.querySelector('i');
                const isDark = e.newValue === 'dark';
                if(iconElement){
                    iconElement.classList.toggle('bx-moon', !isDark);
                    iconElement.classList.toggle('bx-sun', isDark);
                    iconElement.classList.toggle('ri-moon-line', !isDark);
                    iconElement.classList.toggle('ri-sun-line', isDark);
                }
            }
        }
    });

})();
