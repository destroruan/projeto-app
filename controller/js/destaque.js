document.addEventListener("DOMContentLoaded", function() {
    fetchNoticias();
});

let currentIndex = 0;
let items = [];

// Função para atualizar a exibição do carousel
function updateCarousel() {
    const totalItems = items.length;
    items.forEach((item, index) => {
        item.style.display = (index >= currentIndex && index < currentIndex + 6) ? 'block' : 'none';
    });
}

// Função para adicionar eventos aos botões após as notícias serem carregadas
function addEventListeners() {
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');

    if (prevButton) {
        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 6 + items.length) % items.length;
            if (currentIndex < 0) currentIndex = Math.max(0, items.length - 6);
            updateCarousel();
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 6) % items.length;
            if (currentIndex >= items.length) currentIndex = 0;
            updateCarousel();
        });
    }
}

// Função para buscar as notícias
function fetchNoticias() {
    fetch('view/assets/include/destaque.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao buscar notícias: ' + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById("noticiasDestaque").innerHTML = data;
            items = document.querySelectorAll('.destaque-item');
            currentIndex = 0;
            updateCarousel();
            addEventListeners(); // Adiciona os eventos aos botões
        })
        .catch(error => {
            document.getElementById("noticiasDestaque").innerHTML = "<p>Não foi possível carregar as notícias.</p>";
        });
}
