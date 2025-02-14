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

self.addEventListener('install', (event) => {
    console.log('Service Worker instalado');
});

self.addEventListener('fetch', (event) => {
    console.log('Interceptando request:', event.request.url);
});

let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault(); // Evita o pop-up automático
    deferredPrompt = e; // Armazena o evento para uso posterior
    document.getElementById('addToHome').style.display = 'block'; // Exibe o botão quando disponível
});

document.getElementById('addToHome').addEventListener('click', () => {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('Usuário aceitou adicionar à tela inicial.');
            } else {
                console.log('Usuário recusou adicionar à tela inicial.');
            }
            deferredPrompt = null;
        });
    } else {
        alert('Opção de adicionar à tela inicial não disponível.');
    }
});
