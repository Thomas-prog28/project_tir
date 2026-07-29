const burger = document.querySelector('.header__burger');
const menu = document.querySelector('.header__menu');

burger.addEventListener('click', () => {
    const isOpen = menu.classList.toggle('header__menu--open');
    burger.setAttribute('aria-expanded', isOpen);
})
