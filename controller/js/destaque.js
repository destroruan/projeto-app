document.addEventListener("DOMContentLoaded", function() {
    function fetchNoticias() {
        fetch('view/assets/include/destaque.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar notícias: ' + response.statusText);
                }
                return response.text();
            })
            .then(data => {
                document.getElementById("noticias-destaques").innerHTML = data;
            })
            .catch(error => {
                console.error(error);
                document.getElementById("noticias-destaques").innerHTML = "<p>Não foi possível carregar as notícias.</p>";
            });
    }

    fetchNoticias();
});

let currentIndex = 0;

function moveSlide(direction) {
    const items = document.querySelectorAll('.destaque-item');
    currentIndex += direction;

    if (currentIndex < 0) {
        currentIndex = items.length - 1; // Volta para o último item
    } else if (currentIndex >= items.length) {
        currentIndex = 0; // Volta para o primeiro item
    }

    const carousel = document.querySelector('.destaques');
    const offset = -currentIndex * 100; // Move os itens com base no índice atual
    carousel.style.transform = `translateX(${offset}%)`;
}

// Automaticamente move os slides a cada 5 segundos
setInterval(() => {
    moveSlide(1);
}, 1000 * 15);