document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const primaryMenu = document.querySelector('.primary-menu-container');

    if (menuToggle && primaryMenu) {
        menuToggle.addEventListener('click', function() {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            menuToggle.classList.toggle('active');
            primaryMenu.classList.toggle('active');
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.main-navigation') && 
            menuToggle.getAttribute('aria-expanded') === 'true') {
            menuToggle.setAttribute('aria-expanded', 'false');
        }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 768) {
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        }, 250);
    });

    // Mobile Submenu Toggle
    const menuItemsWithChildren = document.querySelectorAll('.menu-item-has-children');
    
    menuItemsWithChildren.forEach(item => {
        // Create toggle button
        const toggleButton = document.createElement('button');
        toggleButton.className = 'submenu-toggle';
        toggleButton.setAttribute('aria-expanded', 'false');
        toggleButton.innerHTML = '<span class="screen-reader-text">Toggle Submenu</span>';
        
        // Only add toggle button for mobile view
        const handleResize = () => {
            if (window.innerWidth <= 768) {
                if (!item.querySelector('.submenu-toggle')) {
                    item.querySelector('a').after(toggleButton);
                }
            } else {
                const existingToggle = item.querySelector('.submenu-toggle');
                if (existingToggle) {
                    existingToggle.remove();
                }
            }
        };

        // Initial check
        handleResize();

        // Listen for window resize
        window.addEventListener('resize', handleResize);

        // Toggle submenu
        toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.classList.toggle('active');
            toggleButton.setAttribute(
                'aria-expanded',
                toggleButton.getAttribute('aria-expanded') === 'false' ? 'true' : 'false'
            );
        });
    });
}); 