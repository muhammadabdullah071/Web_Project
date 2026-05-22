// Add background to navbar when scrolling down
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar-glass');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(5, 5, 5, 0.9)';
            navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.5)';
        } else {
            navbar.style.background = 'rgba(5, 5, 5, 0.7)';
            navbar.style.boxShadow = 'none';
        }
    });

    // Mobile scroll initialization for horizontal product cards
    const scrollRows = document.querySelectorAll('.mobile-scroll-row');
    let isDown = false;
    let startX;
    let scrollLeft;

    scrollRows.forEach(row => {
        row.addEventListener('mousedown', (e) => {
            isDown = true;
            row.style.cursor = 'grabbing';
            startX = e.pageX - row.offsetLeft;
            scrollLeft = row.scrollLeft;
        });
        row.addEventListener('mouseleave', () => {
            isDown = false;
            row.style.cursor = 'grab';
        });
        row.addEventListener('mouseup', () => {
            isDown = false;
            row.style.cursor = 'grab';
        });
        row.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - row.offsetLeft;
            const walk = (x - startX) * 2; // scroll-fast
            row.scrollLeft = scrollLeft - walk;
        });
    });
});
