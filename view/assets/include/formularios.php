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
        <button onclick="location.href='?tipo=publicidade'">Publicidade</button>
        <button onclick="location.href='?tipo=noticias'">Notícias</button>
    </div>
<?php } else{?>
<form action="../../../controller/php/process_form.php" method="post" enctype="<?php echo ($tipo === "publicidade") ? 'multipart/form-data' : ''; ?>">
    <?php if ($tipo === "publicidade") { ?>
        <h1 class="flex">formulário<br>cadastro de publicidade</h1>
        <input type="hidden" name="tipo" id="tipo" value="<?php echo htmlspecialchars($tipo); ?>">       
        <label for="tipo">Tipo:</label>
        <select name="tipo" id="itipo" required>
            <option value="0">Selecione</option>
            <option value="1">250x250px</option>
            <option value="2">250x970px</option>
            <option value="3">970x250px</option>
        </select>
        
        <label for="arq">Upload:</label>
        <input type="file" name="arq" id="iarq" required>
        
        <label for="link">Link:</label>
        <input type="url" name="link" id="ilink" required>
        
        <label for="prazo_expiracao">Prazo de Expiração:</label>
        <input type="date" name="prazo_expiracao" id="iprazo_expiracao" required>

    <?php } elseif ($tipo === "noticias") { ?>
        <h1 class="flex">formulário<br>cadastro de notícias</h1>
        <input type="hidden" name="tipo" id="tipo" value="<?php echo htmlspecialchars($tipo); ?>">
        
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="ititulo" required>

        <label for="subtitulo">Subtítulo:</label>
        <input type="text" name="subtitulo" id="isubtitulo" required>

        <label for="categoria">Categoria:</label>
        <select name="categoria" id="icategoria" required>
            <option value="0">Selecione</option>
            <option value="1">Política</option>
            <option value="2">Economia</option>
            <option value="3">Cultura</option>
            <option value="4">Esportes</option>
            <option value="5">Tecnologia</option>
        </select>

        <label for="destaque">Destaque:</label>
        <select name="destaque" id="idestaque" required>
            <option value="0">Não</option>
            <option value="1">Sim</option>
        </select>

        <label for="local">Coluna:</label>
        <select name="local" id="ilocal" required>
            <option value="0">Selecione</option>
            <option value="1">Belford Roxo</option>
            <option value="2">Duque de Caxias</option>
            <option value="3">Magé</option>
            <option value="4">Nilópolis</option>
            <option value="5">Nova Iguaçu</option>
            <option value="6">Portal Jardim do Beija-Flor</option>
            <option value="7">Portal Recanto da Alpinas</option>
            <option value="8">Portal Recando das Peônias</option>
            <option value="9">Queimados</option>
            <option value="10">São João de Meriti</option>
            <option value="11" selected>Xerém</option>
        </select>

        <label for="conteudo">Conteúdo:</label>
        <textarea name="conteudo" id="iconteudo" required></textarea>
    <?php } ?>

    <button type="submit"><?php echo ($tipo === "publicidade") ? 'Anunciar' : 'Publicar'; ?></button>
    <button type="button" onclick="location.href='../include/formularios.php'" class="voltar">Voltar</button>
</form>
<script>
    $(document).ready(function() {
        $('#iconteudo').summernote();
    });
  </script>
<?php }?>
<?php include 'footer.php'; ?>