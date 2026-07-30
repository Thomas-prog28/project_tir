//AFFICHAGE DU MENU CACHE (<1024px) EN CLIQUANT SUR LE BOUTON BURGER
const burger = document.querySelector('.header__burger');
const nav = document.querySelector('.header__nav');

burger.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('header__nav--open');
    burger.setAttribute('aria-expanded', isOpen);
})
