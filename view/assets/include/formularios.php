<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
?>
<?php include 'header.php'; ?>
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
                <option value="Política">Política</option>
                <option value="Economia">Economia</option>
                <option value="Cultura">Cultura</option>
                <option value="Esportes">Esportes</option>
                <option value="Tecnologia">Tecnologia</option>
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