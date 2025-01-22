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
    const body = document.body;

    if (menuToggle && menuContainer) {
        // Initialize ARIA attributes
        menuToggle.setAttribute('aria-expanded', 'false');
        
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', (!isExpanded).toString());
            menuContainer.classList.toggle('active');
            
            // Toggle body scroll
            if (!isExpanded) {
                body.style.overflow = 'hidden';
            } else {
                body.style.overflow = '';
            }
        });
    }

    // Handle submenu toggles
    if (subMenuParents.length > 0) {
        subMenuParents.forEach(item => {
            const link = item.querySelector('a');
            const subMenu = item.querySelector('.sub-menu');
            
            if (link && subMenu) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isActive = item.classList.contains('active');
                    
                    // Close other open submenus
                    subMenuParents.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });
                    
                    item.classList.toggle('active');
                });
            }
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (menuContainer && menuContainer.classList.contains('active')) {
            const isClickInside = menuContainer.contains(e.target) || menuToggle.contains(e.target);
            
            if (!isClickInside) {
                menuToggle.setAttribute('aria-expanded', 'false');
                menuContainer.classList.remove('active');
                body.style.overflow = '';
            }
        }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && menuContainer && menuContainer.classList.contains('active')) {
            menuToggle.setAttribute('aria-expanded', 'false');
            menuContainer.classList.remove('active');
            body.style.overflow = '';
        }
    });
}); 