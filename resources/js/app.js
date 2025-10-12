import './bootstrap';

// Theme toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    const mobileThemeToggleBtn = document.getElementById('mobile-theme-toggle');
    const mobileThemeToggleDarkIcon = document.getElementById('mobile-theme-toggle-dark-icon');
    const mobileThemeToggleLightIcon = document.getElementById('mobile-theme-toggle-light-icon');

    // Show the appropriate icon based on current theme
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon?.classList.remove('hidden');
        mobileThemeToggleLightIcon?.classList.remove('hidden');
    } else {
        themeToggleDarkIcon?.classList.remove('hidden');
        mobileThemeToggleDarkIcon?.classList.remove('hidden');
    }

    function toggleTheme() {
        // Toggle icons
        themeToggleDarkIcon?.classList.toggle('hidden');
        themeToggleLightIcon?.classList.toggle('hidden');
        mobileThemeToggleDarkIcon?.classList.toggle('hidden');
        mobileThemeToggleLightIcon?.classList.toggle('hidden');

        // If set via local storage previously
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        }
    }

    themeToggleBtn?.addEventListener('click', toggleTheme);
    mobileThemeToggleBtn?.addEventListener('click', toggleTheme);
});
