document.addEventListener('DOMContentLoaded', function() {
    const searchToggle = document.querySelector('.search-toggle');
    const searchForm = document.querySelector('.header-search .search-form');
    
    if (searchToggle && searchForm) {
        searchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = searchToggle.getAttribute('aria-expanded') === 'true';
            searchToggle.setAttribute('aria-expanded', !isExpanded);
            searchForm.classList.toggle('active');
            
            if (!isExpanded) {
                // Focus the search input when opening
                setTimeout(() => {
                    searchForm.querySelector('.search-field').focus();
                }, 100);
            }
        });

        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchForm.contains(e.target) && !searchToggle.contains(e.target)) {
                searchForm.classList.remove('active');
                searchToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close search on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchForm.classList.contains('active')) {
                searchForm.classList.remove('active');
                searchToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
}); 