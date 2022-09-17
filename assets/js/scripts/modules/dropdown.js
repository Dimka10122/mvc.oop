// Base content dropdown menu about pages

const dropdownBtn = document.querySelector('.dropdown-toggle');
const dropdownLinks = document.querySelector('.dropdown-menu') ?? [];

document.addEventListener('click', event => {
    dropdownLinks.style.display = 'none';
    if (event.target == dropdownBtn) {
        dropdownLinks.style.display = 'block';
    }
});
