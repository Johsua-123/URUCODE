document.addEventListener('DOMContentLoaded', function() {
    const categoryDropdown = document.querySelector('.navbar-category');
    const dropdownMenu = categoryDropdown.querySelector('.dropdown-menu');

    function toggleDropdown(event) {
        dropdownMenu.classList.toggle('hidden');
        event.stopPropagation(); 
    }
    
    categoryDropdown.addEventListener('click', toggleDropdown);
    
    document.addEventListener('click', function(event) {
        if (!categoryDropdown.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
});
