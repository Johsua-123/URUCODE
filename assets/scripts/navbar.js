document.addEventListener('DOMContentLoaded', function() {
    const categoryDropdown = document.querySelector('.navbar-category');
    const categoryDropdownMenu = categoryDropdown.querySelector('.dropdown-menu');
    const profileDropdown = document.querySelector('.navbar-profile');
    const profileDropdownMenu = profileDropdown.querySelector('.dropdown-menu');
    const cartDropdown = document.querySelector('.cart-section');
    const cartDropdownMenu = cartDropdown.querySelector('.dropdown-menu');
    const cartCounter = document.querySelector('.cart-counter');

    function toggleDropdown(menu) {
        menu.classList.toggle('hidden');
    }

    function closeDropdown(menu) {
        menu.classList.add('hidden');
    }

    // Toggle category dropdown
    categoryDropdown.addEventListener('click', function(event) {
        toggleDropdown(categoryDropdownMenu);
        event.stopPropagation();
    });

    // Toggle profile dropdown
    profileDropdown.addEventListener('click', function(event) {
        toggleDropdown(profileDropdownMenu);
        event.stopPropagation();
    });

    // Toggle cart dropdown
    cartDropdown.addEventListener('click', function(event) {
        toggleDropdown(cartDropdownMenu);
        event.stopPropagation();
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!categoryDropdown.contains(event.target)) {
            closeDropdown(categoryDropdownMenu);
        }
        if (!profileDropdown.contains(event.target)) {
            closeDropdown(profileDropdownMenu);
        }
        if (!cartDropdown.contains(event.target)) {
            closeDropdown(cartDropdownMenu);
        }
    });

    // Close dropdowns when pressing "Escape" key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDropdown(categoryDropdownMenu);
            closeDropdown(profileDropdownMenu);
            closeDropdown(cartDropdownMenu);
        }
    });

    // Example function to update cart item count
    function updateCartCounter(count) {
        cartCounter.textContent = count;
    }

    // Dummy example to set the cart count to 3
    updateCartCounter(3);
});
