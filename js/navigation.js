/**
 * Handle sticky header and navigation functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    // Sticky header functionality
    const header = document.querySelector('.site-header');
    if (header && header.classList.contains('sticky-enabled')) {
        let lastScroll = window.scrollY;
        const scrollThreshold = 100;
        let ticking = false;

        function handleScroll() {
            const currentScroll = window.scrollY;

            if (!ticking) {
                window.requestAnimationFrame(() => {
                    if (currentScroll > scrollThreshold) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }

                    if (currentScroll > lastScroll && currentScroll > header.offsetHeight) {
                        header.classList.add('header-hidden');
                    } else {
                        header.classList.remove('header-hidden');
                    }

                    lastScroll = currentScroll;
                    ticking = false;
                });

                ticking = true;
            }
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
    }

    // Navigation functionality
    const menuToggle = document.querySelector('.menu-toggle');
    const menuContainer = document.querySelector('.primary-menu-container');
    const subMenuParents = document.querySelectorAll('.menu-item-has-children');

    if (menuToggle && menuContainer) {
        menuToggle.addEventListener('click', function() {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            menuContainer.classList.toggle('active');
            document.body.style.overflow = !isExpanded ? 'hidden' : '';
        });
    }

    // Handle submenu toggles
    subMenuParents.forEach(item => {
        const link = item.querySelector('a');
        
        link.addEventListener('click', function(e) {
            if (this.parentNode.querySelector('.sub-menu')) {
                e.preventDefault();
                const parent = this.parentNode;
                parent.classList.toggle('active');
            }
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (menuContainer && menuContainer.classList.contains('active')) {
            const isClickInside = menuContainer.contains(e.target) || menuToggle.contains(e.target);
            
            if (!isClickInside) {
                menuToggle.setAttribute('aria-expanded', 'false');
                menuContainer.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
}); 