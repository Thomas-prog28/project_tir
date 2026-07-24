const burger = document.querySelector('.header__burger');
const mobileNav = document.querySelector('.header__mobile-nav');

if (burger && mobileNav) {
    burger.addEventListener('click', () => {
        mobileNav.style.display =
            mobileNav.style.display === 'block' ? 'none' : 'block';
    });
}
