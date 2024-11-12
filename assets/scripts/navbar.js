document.addEventListener('DOMContentLoaded', function() {
    const categoryDropdown = document.querySelector('.navbar-category');
    const categoryDropdownMenu = categoryDropdown.querySelector('.dropdown-menu');
    const profileDropdown = document.querySelector('.navbar-profile');
    const profileDropdownMenu = profileDropdown.querySelector('.dropdown-menu');

    function toggleDropdown(menu) {
        menu.classList.toggle('hidden');
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

    // Close both dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!categoryDropdown.contains(event.target)) {
            categoryDropdownMenu.classList.add('hidden');
        }
        if (!profileDropdown.contains(event.target)) {
            profileDropdownMenu.classList.add('hidden');
        }
    });
});
