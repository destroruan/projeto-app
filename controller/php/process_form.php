<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../model/assets/php/db.php'; 
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT);

    if ($tipo === "publicidade") {
        
        $pdo = getConnection();
        $sql = "CREATE TABLE IF NOT EXISTS publicidades (
            id INT AUTO_INCREMENT PRIMARY KEY,
            tipo INT NOT NULL,
            imagem VARCHAR(255) NOT NULL,
            link VARCHAR(255) NOT NULL,
            prazo_expiracao DATE NOT NULL
        )";
        $pdo->exec($sql);
        $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_URL);
        $prazo_expiracao = htmlspecialchars($_POST['prazo_expiracao'], ENT_QUOTES, 'UTF-8');

        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $prazo_expiracao)) {
            die('Formato de data inválido. Use o formato YYYY-MM-DD.');
        }

        if (!isset($_FILES['arq']) || $_FILES['arq']['error'] !== UPLOAD_ERR_OK) {
            die('Erro no upload: ' . $_FILES['arq']['error']);
        }

        $target_dir = "../img/uploads/$tipo/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_file = $target_dir . basename($_FILES["arq"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["arq"]["tmp_name"]);
        if ($check === false) {
            $message = "Arquivo não é uma imagem.";
            $uploadOk = 0;
        }

        if ($_FILES["arq"]["size"] > 2000000) {
            $message = "Desculpe, seu arquivo é muito grande.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            $message = "Desculpe, somente arquivos JPG, JPEG, PNG e GIF são permitidos.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $message = "Desculpe, seu arquivo não foi enviado.";
        } else {
            if (move_uploaded_file($_FILES["arq"]["tmp_name"], $target_file)) {
                $stmt = $pdo->prepare("INSERT INTO publicidades (tipo, imagem, link, prazo_expiracao) VALUES (?, ?, ?, ?)");
                $stmt->execute([$tipo, "view/assets/img/uploads/$tipo/" . basename($_FILES["arq"]["name"]), $link, $prazo_expiracao]);

                if ($stmt->errorCode() != '00000') {
                    $message = "Erro ao inserir no banco de dados: " . implode(", ", $stmt->errorInfo());
                } else {
                    $message = "Publicidade registrada com sucesso!";
                }
            } else {
                $message = "Desculpe, houve um erro ao enviar seu arquivo.";
            }
        }
    } else {
        $pdo = getConnection();
        $sql = "CREATE TABLE IF NOT EXISTS noticias (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            subtitulo VARCHAR(255) NOT NULL,
            conteudo TEXT NOT NULL,
            categoria VARCHAR(255) NOT NULL,
            destaque TINYINT(1) NOT NULL,
            cidade VARCHAR(255) NOT NULL,
            hora_postagem DATETIME NOT NULL
        )";
        $pdo->exec($sql);

        $titulo = htmlspecialchars($_POST['titulo'], ENT_QUOTES, 'UTF-8');
        $subtitulo = htmlspecialchars($_POST['subtitulo'], ENT_QUOTES, 'UTF-8');
        $conteudo = htmlspecialchars($_POST['conteudo'], ENT_QUOTES, 'UTF-8');
        $categoria = htmlspecialchars($_POST['categoria'], ENT_QUOTES, 'UTF-8');
        $destaque = filter_input(INPUT_POST, 'destaque', FILTER_SANITIZE_NUMBER_INT);
        $cidade = htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8');
        
        $hora_postagem = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("INSERT INTO noticias (titulo, subtitulo, conteudo, categoria, destaque, cidade, hora_postagem) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt->execute([$titulo, $subtitulo, $conteudo, $categoria, $destaque, $cidade, $hora_postagem])) {
            $message = "Erro ao inserir no banco de dados: " . implode(", ", $stmt->errorInfo());
        } else {
            $message = "Notícia registrada com sucesso!";
        }
    }    
}

if (!empty($message)) {
    echo "<script>
        alert('$message');
        window.location.href = '../../view/assets/include/formularios.php';
    </script>";
    exit();
}
?>