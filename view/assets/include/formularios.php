<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>millito, o seu portal de serviços! :)</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="http://localhost/projeto-app/view/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="http://localhost/projeto-app/view/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="http://localhost/projeto-app/view/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="http://localhost/projeto-app/view/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="http://localhost/projeto-app/view/assets/img/favicon/safari-pinned-tab.svg" color="#e40000">
    <meta name="msapplication-TileColor" content="#e40000">
    <meta name="theme-color" content="#e40000">
    <link rel="stylesheet" href="http://localhost/projeto-app/view/assets/css/default.css">
</head>
<body>
<header>
    <section class="flex" id="top-view">
        <a href="../../../index.php" id="logotipo-top"><img src="../img/favicon/composta.png" alt="" srcset=""></a>
    </section>
</header>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<?php if (is_null($tipo)) { ?>
    <div class="button-container">
        <h1 class="flex">Selecione uma opção:</h1>
        <button onclick="location.href='?tipo=publicidade'" class="btn btn-primary">Publicidade</button>
        <button onclick="location.href='?tipo=noticias'" class="btn btn-primary">Notícias</button>
    </div>
<?php } else { ?>
    <form action="../../../controller/php/process_form.php" method="post" enctype="multipart/form-data">
        <?php if ($tipo === "publicidade") { ?>
            <h1 class="flex">Formulário<br>Cadastro de Publicidade</h1>
            <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">
            
            <label for="tamanho">Tamanho:</label>
            <select name="tamanho" required>
                <option value="">Selecione</option>
                <option value="1">250x250px</option>
                <option value="2">250x970px</option>
                <option value="3">970x250px</option>
            </select>

            <label for="arq">Upload:</label>
            <input type="file" name="arq" required>

            <label for="link">Link:</label>
            <input type="url" name="link" required>

            <label for="prazo_expiracao">Prazo de Expiração:</label>
            <input type="date" name="prazo_expiracao" required>

        <?php } elseif ($tipo === "noticias") { ?>
            <h1 class="flex">Formulário<br>Cadastro de Notícias</h1>
            <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">

            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>

            <label for="subtitulo">Subtítulo:</label>
            <input type="text" name="subtitulo" required>

            <label for="categoria">Categoria:</label>
            <select name="categoria" required>
                <option value="">Selecione</option>
                <option value="Economia">Economia</option>
                <option value="Educação">Educação</option>
                <option value="Empreendedorismo">Empreendedorismo</option>
                <option value="Entretenimento">Entretenimento</option>
                <option value="Eventos">Eventos</option>
                <option value="Filosofia">Filosofia</option>
                <option value="Financeiro">Financeiro</option>
                <option value="Gastronomia">Gastronomia</option>
                <option value="Gaming">Gaming</option>
                <option value="História">História</option>
                <option value="Jornalismo">Jornalismo</option>
                <option value="Literatura">Literatura</option>
                <option value="Meio Ambiente">Meio Ambiente</option>
                <option value="Moda">Moda</option>
                <option value="Música">Música</option>
                <option value="Política">Política</option>
                <option value="Religião">Religião</option>
                <option value="Saúde">Saúde</option>
                <option value="Ciência">Ciência</option>
                <option value="Estilo de Vida">Estilo de Vida</option>
                <option value="Tecnologia">Tecnologia</option>
                <option value="Tecnologia Verde">Tecnologia Verde</option>
                <option value="Televisão">Televisão</option>
                <option value="Transporte">Transporte</option>
                <option value="Turismo">Turismo</option>
                <option value="Voluntariado">Voluntariado</option>
                <option value="Desenvolvimento Pessoal">Desenvolvimento Pessoal</option>
                <option value="Crimes">Crimes</option>
            </select>

            <label for="destaque">Destaque:</label>
            <select name="destaque" required>
                <option value="0">Não</option>
                <option value="1">Sim</option>
            </select>

            <label for="cidade">Coluna:</label>
            <select name="cidade" required>
                <option value="">Selecione</option>
                <option value="Belford Roxo">Belford Roxo</option>
                <option value="Duque de Caxias">Duque de Caxias</option>
                <option value="Magé">Magé</option>
                <option value="Nilópolis">Nilópolis</option>
                <option value="Nova Iguaçu">Nova Iguaçu</option>
                <option value="Portal Jardim do Beija-Flor">Portal Jardim do Beija-Flor</option>
                <option value="Portal Recanto da Alpinas">Portal Recanto da Alpinas</option>
                <option value="Portal Recanto das Peônias">Portal Recanto das Peônias</option>
                <option value="Queimados">Queimados</option>
                <option value="São João de Meriti">São João de Meriti</option>
                <option value="Xerém" selected>Xerém</option>
            </select>

            <label for="conteudo">Conteúdo:</label>
            <textarea name="conteudo" id="iconteudo" required></textarea>
            
            <label for="imagem">Imagem:</label>
            <input type="file" name="imagem" accept="image/*" required>
        <?php } ?>
        
        <button type="submit" class="btn btn-success"><?php echo ($tipo === "publicidade") ? 'Anunciar' : 'Publicar'; ?></button>
        <button type="button" onclick="location.href='../include/formularios.php'" class="btn btn-danger">Voltar</button>
    </form>
    
    <script>
        $(document).ready(function() {
            $('#iconteudo').summernote();
        });
    </script>
<?php } ?>
<?php include 'footer.php'; ?>