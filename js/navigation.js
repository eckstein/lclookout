/**
 * Handle sticky header functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.site-header');
    if (!header || !header.classList.contains('sticky-enabled')) return;

    let lastScroll = window.scrollY;
    const scrollThreshold = 100; // Amount of pixels to scroll before header changes
    let ticking = false;

    function handleScroll() {
        const currentScroll = window.scrollY;

        if (!ticking) {
            window.requestAnimationFrame(() => {
                // Add/remove scrolled class based on scroll position
                if (currentScroll > scrollThreshold) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }

                // Hide header when scrolling down, show when scrolling up
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
}); 