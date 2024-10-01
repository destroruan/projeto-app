<?php
require_once __DIR__ . '../../../../model/assets/php/db.php';
$pdo = getConnection();
$message = '';
$stmt = $pdo->prepare("SELECT * FROM noticias ORDER BY hora_postagem DESC LIMIT 12");
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($noticias)) {
?>
    <style>
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 20px;
    }
    .titulo-categoria {
        text-align: center;
        margin-bottom: 20px;
    }
    .destaque {
        position: relative;
    }
    .destaques {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .destaque-item {
        width: 30%;
        margin: 10px;
        border-radius: 8px;
        color: white;
        text-align: justify;
        padding: 20px;
        background-size: cover;
        background-position: center;
    }
    .destaque-item:hover {
        transform: scale(1.05);
    }
    .categoria {
        display: block;
        margin-top: 5px;
        font-size: 1em;
        text-align: left;
        background-color: var(--vermelho);
        width: max-content;
        padding: 2px;
        font-size: var(--fonte-apoio);
    }
    .destaque-item a h2 {
        font-size: var(--fonte-padrao);
        margin-top: 20px;
        background-color: rgb(0,0,0,0.7);
        padding: 10px;
    }
    .destaque-item a {
        text-decoration: none;
        color: var(--branco);
        text-shadow: var(--sombra-texto);
    }
    .destaque-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        z-index: 10;
    }
    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }
</style>
    <div class="container">
        <h1 class="titulo-categoria"><span><em></em></span>Destaques da semana</h1>
        <div class="destaque">
            <div id="noticiasDestaque" class="destaques">
                <?php
                foreach ($noticias as $noticia) {
                    echo '<div class="destaque-item" style="background-image: url(\'' . htmlspecialchars($noticia['imagem'], ENT_QUOTES, 'UTF-8') . '\');">';
                    echo '<a href="">';
                    echo '<span class="categoria">' . htmlspecialchars($noticia['categoria'], ENT_QUOTES, 'UTF-8') . '</span>';
                    echo '<h2>' . htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8') . '</h2>';
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