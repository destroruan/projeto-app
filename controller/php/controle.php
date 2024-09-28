<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../model/assets/php/db.php'; 
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
if (isset($tipo) && $tipo == "not-destaque") {
    $pdo = getConnection();
    $tempo = date('Y-m-d H:i:s', strtotime('-3 hours'));
    $stmt = $pdo->prepare("SELECT * FROM noticias WHERE destaque = 1 AND hora_postagem >= ? ORDER BY hora_postagem DESC");
    $stmt->execute([$tempo]); 
    $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    if (count($noticias) > 0) { 
        ?> 
            <div id="destaques" class="categorias">
                <div class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $noticiasPorGrupo = 4;
                        $totalNoticias = count($noticias);
                        $totalSlides = ceil($totalNoticias / $noticiasPorGrupo);
                        for ($i = 0; $i < $totalSlides; $i++) {
                            $activeClass = ($i === 0) ? 'active' : '';
                            echo "<div class='carousel-item $activeClass'>";
                            echo "<div class='row'>";
                            for ($j = 0; $j < $noticiasPorGrupo; $j++) {
                                $index = ($i * $noticiasPorGrupo) + $j;
                                if ($index < $totalNoticias) {
                                    $titulo = htmlspecialchars($noticias[$index]['titulo'], ENT_QUOTES, 'UTF-8'); 
                                    echo "<div class='col-md-3'>";
                                    echo "<h1>$titulo</h1>";
                                    echo "</div>";
                                }
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php
    } else {
        echo "<p>Nenhuma notícia disponível.</p>";
    }
}
?>