document.addEventListener("DOMContentLoaded", function() {
    fetchNoticias();
});
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
            updateCarousel();
        })
        .catch(error => {
            console.error(error);
            document.getElementById("noticiasDestaque").innerHTML = "<p>Não foi possível carregar as notícias.</p>";
        });
}