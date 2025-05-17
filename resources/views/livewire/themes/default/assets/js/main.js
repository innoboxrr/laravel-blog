document.addEventListener('DOMContentLoaded', function () {
    // Mostrar / ocultar barra de búsqueda
    const searchBtn = document.querySelector('.header-top-search-btn');
    const searchForm = document.getElementById('search-form');

    if (searchBtn && searchForm) {
        searchBtn.addEventListener('click', () => {
            searchForm.classList.toggle('hidden');
        });
    }

    // Mostrar / ocultar menú de navegación principal (móvil)
    const menuBtn = document.getElementById('menu-animate-icon');
    const desktopNav = document.querySelector('.header-nav-desktop');

    if (menuBtn && desktopNav) {
        menuBtn.addEventListener('click', (e) => {
            e.preventDefault(); // evita que el enlace recargue la página
            desktopNav.classList.toggle('hidden');
        });
    }
});
