<?php
require_once 'model/assets/php/db.php';
if (isset($tipo) && $tipo == "global") { ?>
    <section class="flex" id="publicidade-centro">
        <?php
        try {
            $pdo = getConnection();
            $stmt = $pdo->prepare("SELECT * FROM publicidades WHERE prazo_expiracao >= CURDATE()");
            $stmt->execute();
            $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($noticias)) {
                echo '<div id="noticiasCarousel" class="carousel slide" data-ride="carousel">';
                echo '<div class="carousel-inner">';
                foreach ($noticias as $index => $noticia) {
                    $activeClass = ($index === 0) ? 'active' : '';
                    echo '<div class="carousel-item ' . $activeClass . '">';
                    echo '<a href="' . htmlspecialchars($noticia["link"]) . '" target="_blank"><img src="' . htmlspecialchars($noticia['imagem']) . '" class="d-block w-100" alt="Publicidade relacionada ao produto ou serviço"></a>';
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
            } else {
                echo "<p>Não há publicidades ativas.</p>";
            }
        } catch (PDOException $e) {
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
        ?>
    </section>
<?php } ?>
<script src="controller/js/carousel.js"></script>