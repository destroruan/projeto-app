<?php 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $acao = $_GET['acao'] ?? null;
    $parametro = $_GET['parametro'] ?? null;
    require_once __DIR__ . '../../../model/assets/php/db.php';
    if ($acao === "destaque") {
        try {
            $pdo = getConnection();
            $stmt = $pdo->prepare("SELECT * FROM noticias WHERE destaque = 1 ORDER BY hora_postagem DESC LIMIT 12");
            $stmt->execute();
            $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($noticias)) {
                ?>
                <div class="container">
                    <div class="flex">
                        <h1 class="titulo-categoria">Destaques da semana</h1>
                        <span class="bar-categoria"></span>
                    </div>
                    <div class="destaque">
                        <div id="noticiasDestaque" class="destaques">
                            <?php
                            foreach ($noticias as $noticia) {
                                echo '<div class="destaque-item" style="background-image: url(\'' . htmlspecialchars($noticia['imagem'], ENT_QUOTES, 'UTF-8') . '\');">';
                                echo '<a href="">';
                                echo '<span class="categoria" style="background: var(--tag-'. htmlspecialchars($noticia['categoria'], ENT_QUOTES, 'UTF-8') . ');">' . htmlspecialchars($noticia['categoria'], ENT_QUOTES, 'UTF-8') . '</span>';
                                echo '<h2>' . htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8') . '</h2>';
                                echo '</a>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div class="bolinha-container">
                            <?php for ($i = 0; $i < ceil(count($noticias) / 6); $i++): ?>
                                <span class="bolinha" data-index="<?php echo $i; ?>"></span>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo "<p>Não há notícias disponíveis.</p>";
            }
        } catch (PDOException $e) {
            // Log de erro para depuração
            error_log('Erro ao consultar notícias: ' . $e->getMessage());
            echo "<p>Ocorreu um erro ao tentar recuperar as notícias.</p>";
        }
    }
    if ($acao == "publicidade-centro"){
        try {
            $pdo = getConnection();
            $stmt = $pdo->prepare("SELECT * FROM publicidades WHERE prazo_expiracao >= CURDATE() AND tamanho = 3");
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
        echo '<script src="controller/js/carousel.js"></script>';
    }
    if ($acao === "categoria") {
        try {
            $pdo = getConnection();
            $stmt = $pdo->prepare("SELECT * FROM noticias WHERE categoria = :parametro ORDER BY hora_postagem DESC LIMIT 2");
            $stmt->bindParam(':parametro', $parametro);
            $stmt->execute();
            $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            if (!empty($noticias)) {
                ?>
                <div class="container">
                    <div class="flex">
                    <h1 class="titulo-categoria" style="color: var(--tag-<?php echo htmlspecialchars($noticias[0]['categoria'], ENT_QUOTES, 'UTF-8'); ?>);">
                        <?php echo htmlspecialchars($noticias[0]['categoria'], ENT_QUOTES, 'UTF-8'); ?>
                    </h1>
                    <span class="bar-categoria"></span>
                    </div>
                    <div class="destaque">
                        <div id="noticiasDestaque" class="destaques">
                            <?php
                            foreach ($noticias as $noticia) {
                                echo '<div class="destaque-item" style="background-image: url(\'' . htmlspecialchars($noticia['imagem'], ENT_QUOTES, 'UTF-8') . '\');">';
                                echo '<a href="">';
                                echo '<span class="categoria" style="background: var(--tag-' . htmlspecialchars($noticia['categoria'], ENT_QUOTES, 'UTF-8') . ');">' . htmlspecialchars($noticia['categoria'], ENT_QUOTES, 'UTF-8') . '</span>';
                                echo '<h2>' . htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8') . '</h2>';
                                echo '</a>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo "<p>Não há notícias disponíveis.</p>";
            }
        } catch (PDOException $e) {
            // Log de erro para depuração
            error_log('Erro ao consultar notícias: ' . $e->getMessage());
            echo "<p>Ocorreu um erro ao tentar recuperar as notícias.</p>";
        }        
    }
    if ($acao === "cidade") {
        try {
            $pdo = getConnection();
            $stmt = $pdo->prepare("SELECT * FROM noticias WHERE cidade = :parametro ORDER BY hora_postagem DESC LIMIT 2");
            $stmt->bindParam(':parametro', $parametro);
            $stmt->execute();
            $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            if (!empty($noticias)) {
                ?>
                <div class="container">
                    <div class="flex">
                    <h1 class="titulo-categoria" style="color: var(--tag-<?php echo htmlspecialchars($noticias[0]['categoria'], ENT_QUOTES, 'UTF-8'); ?>);">
                        <?php echo htmlspecialchars($noticias[0]['cidade'], ENT_QUOTES, 'UTF-8'); ?>
                    </h1>
                    <span class="bar-categoria"></span>
                    </div>
                    <div class="destaque">
                        <div id="noticiasDestaque" class="destaques">
                            <?php
                            foreach ($noticias as $noticia) {
                                echo '<div class="destaque-item" style="background-image: url(\'' . htmlspecialchars($noticia['imagem'], ENT_QUOTES, 'UTF-8') . '\');">';
                                echo '<a href="">';
                                echo '<span class="categoria" style="background: var(--tag-' . htmlspecialchars($noticia['categoria'], ENT_QUOTES, 'UTF-8') . ');">' . htmlspecialchars($noticia['categoria'], ENT_QUOTES, 'UTF-8') . '</span>';
                                echo '<h2>' . htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8') . '</h2>';
                                echo '</a>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo "<p>Não há notícias disponíveis.</p>";
            }
        } catch (PDOException $e) {
            // Log de erro para depuração
            error_log('Erro ao consultar notícias: ' . $e->getMessage());
            echo "<p>Ocorreu um erro ao tentar recuperar as notícias.</p>";
        }        
    }
}
?>