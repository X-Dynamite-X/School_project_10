// Function to toggle visibility of an element
const toggleVisibility = (element, action) => {
    element.classList[action]('hidden');
};

// Manage user menu visibility
const userMenuButton = document.getElementById('user-menu-button');
const userMenu = document.getElementById('user_menu_button');

let userMenuTimeout;

userMenuButton.addEventListener('mouseover', () => {
    clearTimeout(userMenuTimeout);
    toggleVisibility(userMenu, 'remove');
});

userMenuButton.addEventListener('mouseout', (e) => {
    userMenuTimeout = setTimeout(() => {
        if (!userMenu.contains(e.relatedTarget)) {
            toggleVisibility(userMenu, 'add');
        }
    }, 200); // Adjust the delay time (in milliseconds) as needed
});

userMenu.addEventListener('mouseover', () => {
    clearTimeout(userMenuTimeout);
    toggleVisibility(userMenu, 'remove');
});

userMenu.addEventListener('mouseleave', () => {
    userMenuTimeout = setTimeout(() => {
        toggleVisibility(userMenu, 'add');
    }, 200); // Adjust the delay time (in milliseconds) as needed
});

// Manage mobile menu visibility
const menuButton = document.getElementById('menu-button');
const mobileMenu = document.getElementById('mobile-menu');

menuButton.addEventListener('click', () => {
    const icons = menuButton.querySelectorAll('svg');
    toggleVisibility(mobileMenu, 'toggle');
    icons.forEach(icon => icon.classList.toggle('hidden'));
});
