document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.hero__carousel-slide');

    if (!slides.length) return;

    let current = 0;
    slides[current].classList.add('is-active');
    
    setInterval(() => {
        slides[current].classList.remove('is-active');
        current = (current + 1) % slides.length;
        slides[current].classList.add('is-active');;
    }, 5000);
});