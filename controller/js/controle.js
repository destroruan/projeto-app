document.addEventListener("DOMContentLoaded", function() {
    function carregarNotDestaque() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'controller/php/controle.php?tipo=not-destaque', true);
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('not-destaque').innerHTML = this.responseText;
            } else {
                document.getElementById('not-destaque').innerHTML = 'Erro ao carregar o conteúdo.';
            }
        };
        xhr.onerror = function() {
            document.getElementById('not-destaque').innerHTML = 'Erro ao tentar fazer a requisição.';
        };
        xhr.send();
    }
    carregarNotDestaque();
});