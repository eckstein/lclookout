/**
 * Combine menus for mobile view
 */
function combineMobileMenus() {
    const mobileContainer = document.getElementById('mobile-combined-menu');
    const catMenu = document.getElementById('mobile-cat-menu');
    const primaryMenu = document.getElementById('mobile-primary-menu');
    const socialMenu = document.getElementById('mobile-social-menu');
    
    if (!mobileContainer) return;
    
    // Clear existing content
    mobileContainer.innerHTML = '';
    
    // Clone and append each menu in order
    if (catMenu) {
        const catClone = catMenu.cloneNode(true);
        catClone.id = 'combined-cat-menu';
        catClone.classList.add('combined-menu-section', 'cat-menu-section');
        mobileContainer.appendChild(catClone);
    }
    
    if (primaryMenu) {
        const primaryClone = primaryMenu.cloneNode(true);
        primaryClone.id = 'combined-primary-menu';
        primaryClone.classList.add('combined-menu-section', 'primary-menu-section');
        mobileContainer.appendChild(primaryClone);
    }
    
    if (socialMenu) {
        const socialClone = socialMenu.cloneNode(true);
        socialClone.id = 'combined-social-menu';
        socialClone.classList.add('combined-menu-section', 'social-menu-section');
        mobileContainer.appendChild(socialClone);
    }
    
    // Re-attach submenu toggles to cloned elements
    attachSubmenuToggles();
}

/**
 * Attach submenu toggle handlers to mobile menu items
 */
function attachSubmenuToggles() {
    const mobileContainer = document.getElementById('mobile-combined-menu');
    if (!mobileContainer) return;
    
    const subMenuParents = mobileContainer.querySelectorAll('.menu-item-has-children');
    
    subMenuParents.forEach(item => {
        const link = item.querySelector('a');
        const subMenu = item.querySelector('.sub-menu');
        
        if (link && subMenu) {
            // Remove existing listeners by cloning
            const newLink = link.cloneNode(true);
            link.parentNode.replaceChild(newLink, link);
            
            newLink.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                item.classList.toggle('active');
            });
        }
    });
}

/**
 * Handle sticky header and navigation functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    // Combine menus for mobile
    combineMobileMenus();
    
    // Re-combine on window resize to handle orientation changes
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            combineMobileMenus();
        }, 250);
    });
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

    // Navigation functionality for mobile combined menu
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenuContainer = document.getElementById('mobile-combined-menu');
    const body = document.body;

    if (menuToggle && mobileMenuContainer) {
        // Initialize ARIA attributes
        menuToggle.setAttribute('aria-expanded', 'false');
        
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', (!isExpanded).toString());
            mobileMenuContainer.classList.toggle('active');
            
            // Toggle body scroll
            if (!isExpanded) {
                body.style.overflow = 'hidden';
            } else {
                body.style.overflow = '';
            }
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mobileMenuContainer && mobileMenuContainer.classList.contains('active')) {
            const isClickInside = mobileMenuContainer.contains(e.target) || menuToggle.contains(e.target);
            
            if (!isClickInside) {
                menuToggle.setAttribute('aria-expanded', 'false');
                mobileMenuContainer.classList.remove('active');
                body.style.overflow = '';
            }
        }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenuContainer && mobileMenuContainer.classList.contains('active')) {
            menuToggle.setAttribute('aria-expanded', 'false');
            mobileMenuContainer.classList.remove('active');
            body.style.overflow = '';
        }
    });
}); 