<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '../../../../model/assets/php/db.php';

$pdo = getConnection();
$message = '';

$stmt = $pdo->prepare("SELECT * FROM noticias ORDER BY hora_postagem DESC LIMIT 6");
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($noticias)) {
    echo '<h1 class="titulo-categoria"><span><em></em></span>Destaques da semana</h1>';
    echo '<div class="container">';
    echo '<div class="destaque">';
    echo '<div id="noticiasDestaque" class="destaques">';
    foreach ($noticias as $index => $noticia) {
        if ($index < 3) {
            echo '<div class="destaque-item" style="background-image: url(\'' . htmlspecialchars($noticia['imagem'], ENT_QUOTES, 'UTF-8') . '\');">';
            echo '<a href="">';
            echo '<h2>' . htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8') . '</h2>';
            echo '</a>';
            echo '</div>';
        }
    }
    echo '</div>';
    echo '<button class="destaque-button prev" onclick="moveSlide(-1)">&#10094;</button>';
    echo '<button class="destaque-button next" onclick="moveSlide(1)">&#10095;</button>';
    echo '</div>'; 
    echo '<div class="noticias-adicionais">';
    foreach ($noticias as $key => $noticia) {
        if ($key >= 3) { 
            echo '<div class="noticia-item" style="background-image: url(\'' . htmlspecialchars($noticia['imagem'], ENT_QUOTES, 'UTF-8') . '\');">';
            echo '<a href="">';
            echo '<h2>' . htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8') . '</h2>';
            echo '</a>';
            echo '</div>';
        }
    }
    echo '</div>';
    echo '</div>';
} else {
    echo "<p>Não há notícias disponíveis.</p>";
}
?>
<script src="../../../controller/js/destaque.js"></script>