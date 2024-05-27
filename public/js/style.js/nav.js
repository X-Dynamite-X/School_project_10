const userMenuButton = document.getElementById('user-menu-button');
const userMenu = document.getElementById('user_menu_button');

userMenuButton.addEventListener('mouseover', () => {
    userMenu.classList.remove('hidden');
});

userMenuButton.addEventListener('mouseout', (e) => {
    // Check if the mouse is leaving the button to the menu or outside both
    const toElement = e.relatedTarget;
    if (!userMenu.contains(toElement)) {
        userMenu.classList.add('hidden');
    }
});

userMenu.addEventListener('mouseleave', () => {
    userMenu.classList.add('hidden');
});

userMenu.addEventListener('mouseover', () => {
    userMenu.classList.remove('hidden');
});

const menuButton = document.getElementById('menu-button');
const mobileMenu = document.getElementById('mobile-menu');

menuButton.addEventListener('click', () => {
    const icons = menuButton.querySelectorAll('svg');
    mobileMenu.classList.toggle('hidden');
    icons[0].classList.toggle('hidden');
    icons[1].classList.toggle('hidden');
});
