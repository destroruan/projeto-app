document.addEventListener("DOMContentLoaded", function() {
    fetchNoticias();
    fetchPublicidade();
    fetchCategorias();
});
let currentIndex = 0;
let items = [];
// Função para atualizar a exibição do carousel
function updateCarousel() {
    const totalItems = items.length;
    items.forEach((item, index) => {
        item.style.display = (index >= currentIndex && index < currentIndex + 6) ? 'block' : 'none';
    });
    updateActiveBolinha(); // Atualiza a bolinha ativa
}
// Função para atualizar a bolinha ativa
function updateActiveBolinha() {
    const bolinhas = document.querySelectorAll('.bolinha');
    bolinhas.forEach((bolinha, index) => {
        bolinha.classList.toggle('active', index === Math.floor(currentIndex / 6));
    });
}
// Função para adicionar eventos às bolinhas após as notícias serem carregadas
function addEventListeners() {
    const bolinhas = document.querySelectorAll('.bolinha');

    bolinhas.forEach((bolinha, index) => {
        bolinha.addEventListener('click', () => {
            currentIndex = index * 6; // Atualiza o índice com base na bolinha clicada
            updateCarousel();
        });
    });
}
// Função para buscar as publicidades
function fetchPublicidade() {
    fetch('controller/php/controlador.php?acao=publicidade-centro')
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao buscar notícias: ' + response.statusText);
        }
        return response.text();
    })
    .then(data => {
        document.getElementById("publicidade-centro").innerHTML = data;
    })
    .catch(error => {
        document.getElementById("publicidade-centro").innerHTML = "<p>Não foi possível carregar as notícias.</p>";
    });
    $(document).ready(function(){
        $('#noticiasCarousel').carousel({
            interval: (1000)*(15)
        });
    });
}
// Função para buscar as notícias
function fetchNoticias() {
    fetch('controller/php/controlador.php?acao=destaque')
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
            addEventListeners(); // Adiciona os eventos às bolinhas
        })
        .catch(error => {
            document.getElementById("noticiasDestaque").innerHTML = "<p>Não foi possível carregar as notícias.</p>";
        });
}
// Função para buscar as categorias
function fetchCategorias() {
    const categoriaElements = document.querySelectorAll(".categoria-noticias");
    
    categoriaElements.forEach((element) => {
        const categoriaValue = element.textContent.trim();
        console.log('Buscando categoria:', categoriaValue);
        
        fetch(`controller/php/controlador.php?acao=categoria&parametro=${encodeURIComponent(categoriaValue)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar notícias: ' + response.statusText);
                }
                return response.text();
            })
            .then(data => {
                console.log('Dados recebidos:', data); // Para verificar o que está sendo retornado
                element.innerHTML = data; // Atualiza o conteúdo do elemento atual
            })
            .catch(error => {
                element.innerHTML = "<p>Não foi possível carregar as notícias.</p>";
                console.error(error);
            });
    });
}