document.addEventListener('DOMContentLoaded', function() {
    // Hamburger Menu
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('nav');
    let overlay = document.querySelector('.header-overlay');
    
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'header-overlay';
        document.body.appendChild(overlay);
    }
    
    function toggleMenu() {
        hamburger.classList.toggle('active');
        nav.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.classList.toggle('no-scroll');
    }
    
    if (hamburger) hamburger.addEventListener('click', toggleMenu);
    if (overlay) overlay.addEventListener('click', toggleMenu);
    
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', toggleMenu);
    });
});