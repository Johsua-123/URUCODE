document.addEventListener('DOMContentLoaded', function() {
    const categoryDropdown = document.querySelector('.navbar-category');
    const categoryDropdownMenu = categoryDropdown.querySelector('.dropdown-menu');
    const profileDropdown = document.querySelector('.navbar-profile');
    const profileDropdownMenu = profileDropdown.querySelector('.dropdown-menu');

    function toggleDropdown(menu) {
        menu.classList.toggle('hidden');
    }

    categoryDropdown.addEventListener('click', function(event) {
        toggleDropdown(categoryDropdownMenu);
        event.stopPropagation();
    });

    profileDropdown.addEventListener('click', function(event) {
        toggleDropdown(profileDropdownMenu);
        event.stopPropagation();
    });

    document.addEventListener('click', function(event) {
        if (!categoryDropdown.contains(event.target)) {
            categoryDropdownMenu.classList.add('hidden');
        }
        if (!profileDropdown.contains(event.target)) {
            profileDropdownMenu.classList.add('hidden');
        }
    });
});
