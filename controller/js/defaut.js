let index = 0;
const images = document.querySelectorAll('.carousel img');

function showSlide() {
    const carousel = document.getElementById('carousel');
    const width = document.querySelector('.carousel img').clientWidth;
    carousel.style.transform = `translateX(${-index * width}px)`;
    
    images.forEach(img => img.classList.remove('active'));
    images[index].classList.add('active');
}

function prevSlide() {
    index = (index > 0) ? index - 1 : images.length - 1;
    showSlide();
}

function nextSlide() {
    index = (index < images.length - 1) ? index + 1 : 0;
    showSlide();
}

function autoSlide() {
    nextSlide();
    setTimeout(autoSlide, (1000)*5);
}
setTimeout(autoSlide, (1000)*5);

