
    <script>
         const menu = document.querySelector('#mobile-menu');
        const menuLinks = document.querySelector('#nav-list');
        const themeBtn = document.querySelector('#theme-toggle');

        menu.addEventListener('click', () => {
            menu.classList.toggle('is-active');
            menuLinks.classList.toggle('active');
        });

        const currentTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', currentTheme);
        updateThemeIcon(currentTheme);

        themeBtn.addEventListener('click', () => {
            let theme = document.documentElement.getAttribute('data-theme');
            let newTheme = theme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(t) {
            themeBtn.querySelector('i').className = t === 'dark' ? 'bx bx-sun' : 'bx bx-moon';
        }
    </script>