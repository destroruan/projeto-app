<?php
require_once __DIR__ . '../../../../model/assets/php/db.php';
$pdo = getConnection();
$message = '';
$stmt = $pdo->prepare("SELECT * FROM noticias ORDER BY hora_postagem DESC LIMIT 6");
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($noticias)) {
?>
    <div class="container">
        <h1 class="titulo-categoria"><span><em></em></span>Destaques da semana</h1>
        <div class="destaque">
            <div id="noticiasDestaque" class="destaques">
                <?php
                foreach ($noticias as $noticia) {
                    echo '<div class="destaque-item" style="background-image: url(\'' . htmlspecialchars($noticia['imagem'], ENT_QUOTES, 'UTF-8') . '\');">';
                    echo '<a href="">';
                    echo '<h2>' . htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8') . '</h2>';
                    echo '<span class="categoria">' . htmlspecialchars($noticia['categoria'], ENT_QUOTES, 'UTF-8') . '</span>'; // Tag de categoria
                    echo '</a>';
                    echo '</div>';
                }
                ?>
            </div>
            <button class="destaque-button prev">&#10094;</button>
            <button class="destaque-button next">&#10095;</button>
        </div>
    </div>
<?php
} else {
    echo "<p>Não há notícias disponíveis.</p>";
}
?>