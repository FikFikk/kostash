(function() {
    'use strict';
    
    const THEME_KEY = 'kostash_theme';
    
    // Get saved theme or detect system preference
    function getInitialTheme() {
        const savedTheme = localStorage.getItem(THEME_KEY);
        if (savedTheme) return savedTheme;
        
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        return prefersDark ? 'dark' : 'light';
    }
    
    // Apply theme immediately to prevent flash
    function applyThemeImmediate(theme) {
        const html = document.documentElement;
        
        if (theme === 'dark') {
            html.setAttribute('data-bs-theme', 'dark');
            html.setAttribute('data-layout-mode', 'dark');
            html.setAttribute('data-theme', 'dark');
        } else {
            html.setAttribute('data-bs-theme', 'light');
            html.setAttribute('data-layout-mode', 'light');
            html.setAttribute('data-theme', 'light');
        }
    }
    
    // Apply theme immediately
    const initialTheme = getInitialTheme();
    applyThemeImmediate(initialTheme);
    localStorage.setItem(THEME_KEY, initialTheme);
})();

// 2. DOM ready handler for toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    const THEME_KEY = 'kostash_theme';
    
    // Find toggle button (multiple selectors for different layouts)
    const toggleSelectors = [
        '.light-dark-mode',
        '.btn-light-dark',
        '.dark-mode-toggle',
        '[data-toggle="dark-mode"]'
    ];
    
    let toggleButton = null;
    for (const selector of toggleSelectors) {
        toggleButton = document.querySelector(selector);
        if (toggleButton) break;
    }
    
    if (!toggleButton) {
        console.warn('KostASH: Dark mode toggle button not found');
        return;
    }
    
    const iconElement = toggleButton.querySelector('i');
    
    // Theme application function
    function setTheme(theme, saveToStorage = true) {
        const html = document.documentElement;
        const body = document.body;
        
        if (theme === 'dark') {
            html.setAttribute('data-bs-theme', 'dark');
            html.setAttribute('data-layout-mode', 'dark');
            html.setAttribute('data-theme', 'dark');
            body.classList.add('dark');
            
            // Update icon (support multiple icon libraries)
            if (iconElement) {
                // Bootstrap Icons
                iconElement.classList.remove('bi-moon', 'bx-moon');
                iconElement.classList.add('bi-sun', 'bx-sun');
                
                // Feather Icons
                if (iconElement.getAttribute('data-feather')) {
                    iconElement.setAttribute('data-feather', 'sun');
                }
                
                // Font Awesome
                iconElement.classList.remove('fa-moon');
                iconElement.classList.add('fa-sun');
            }
        } else {
            html.setAttribute('data-bs-theme', 'light');
            html.setAttribute('data-layout-mode', 'light');
            html.setAttribute('data-theme', 'light');
            body.classList.remove('dark');
            
            // Update icon
            if (iconElement) {
                // Bootstrap Icons
                iconElement.classList.remove('bi-sun', 'bx-sun');
                iconElement.classList.add('bi-moon', 'bx-moon');
                
                // Feather Icons
                if (iconElement.getAttribute('data-feather')) {
                    iconElement.setAttribute('data-feather', 'moon');
                }
                
                // Font Awesome
                iconElement.classList.remove('fa-sun');
                iconElement.classList.add('fa-moon');
            }
        }
        
        if (saveToStorage) {
            localStorage.setItem(THEME_KEY, theme);
        }
        
        // Trigger custom event for other components
        window.dispatchEvent(new CustomEvent('kostashThemeChanged', { 
            detail: { theme, timestamp: Date.now() } 
        }));
        
        // Re-initialize feather icons if present
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }
    
    // Initialize with saved theme
    const currentTheme = localStorage.getItem(THEME_KEY) || 'light';
    setTheme(currentTheme, false);
    
    // Toggle event listener
    toggleButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const current = localStorage.getItem(THEME_KEY) || 'light';
        const newTheme = current === 'light' ? 'dark' : 'light';
        
        setTheme(newTheme);
        
        // Add click effect
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.style.transform = '';
        }, 150);
    });
    
    // Listen for system theme changes
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.addEventListener('change', function(e) {
        // Only auto-switch if user hasn't manually set a preference
        const hasManualPreference = localStorage.getItem(THEME_KEY + '_manual');
        if (!hasManualPreference) {
            setTheme(e.matches ? 'dark' : 'light');
        }
    });
    
    // Mark as manually set when user clicks toggle
    toggleButton.addEventListener('click', function() {
        localStorage.setItem(THEME_KEY + '_manual', 'true');
    });
    
    console.log('KostASH: Dark mode initialized successfully');
});

// 3. Optional: Auto-sync across tabs
window.addEventListener('storage', function(e) {
    if (e.key === 'kostash_theme' && e.newValue !== e.oldValue) {
        location.reload(); // Simple approach to sync across tabs
    }
});