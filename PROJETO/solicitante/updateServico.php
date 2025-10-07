<?php
session_start();
include "../classes/Servico.php"; // Incluindo a classe Servico

include "../helpers/biblioteca.php";

verificarSessaoExpirada();
verificarAcesso("solicitante");


$servico = new Servico();

// Verificando se o ID do serviço foi passado via POST
if (isset($_POST['btn-editar'])) {
    $id_servico = $_POST['id_servico'];
    $servicoData = $servico->buscarPorId($id_servico);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Serviço - ChamuZé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<?php include "../header/header.php"; ?>
<main class="container d-flex flex-column justify-content-center">
    <h1 class="text-center mt-4 mb-4">Editar Serviço</h1>

    <?php if (!empty($servicoData)): ?>
        <form method="POST" action="../controller/updateServicoController.php" enctype="multipart/form-data" class="bg-white p-4 shadow-sm rounded">
            <input type="hidden" name="id_servico" value="<?= $servicoData['id_servico'] ?>">

            <?php
            //Exebição dos erros
                if (isset($_GET['erro'])){
                    switch ($_GET['erro']){
                        case 1:
                            echo "<div class=\"alert alert-danger\" role=\"alert\">
                            Ops, algo deu errado. O serviço não foi atualizado!
                            </div>";
                            break;
                        case 2: 
                            echo "<div class=\"alert alert-danger\" role=\"alert\">
                            
                            </div>";
                            break;
                }
            }
            ?>

            <!-- Título do serviço -->
            <div class="mb-3">
                <label for="titulo" class="form-label">Título do Serviço</label>
                <input type="text" class="form-control" name="titulo" id="titulo" 
                       value="<?= $servicoData['titulo'] ?>" placeholder="Título do Serviço" required>
            </div>

            <!-- Descrição do serviço -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição do Serviço</label>
                <textarea class="form-control" name="descricao" id="descricao" 
                          placeholder="Descrição do serviço" rows="4" required><?= $servicoData['descricao'] ?></textarea>
            </div>

            <!-- Imagem do serviço -->
            <div class="mb-3">
                <label for="img_servico" class="form-label">Imagem do Serviço</label>
                <input type="file" class="form-control" name="img_servico" id="img_servico">
                <p class="text-muted">Imagem atual: <?= $servicoData['img_servico'] ?></p>
                <input type="hidden" name="img_servico" value="<?= $servicoData['img_servico'];?>">
            </div>

            <!-- Categoria do serviço -->
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" name="categoria" id="categoria">
                    <option value="construcao" <?= ($servicoData['categoria'] == 'construcao') ? 'selected' : '' ?>>Construção</option>
                    <option value="encanamento" <?= ($servicoData['categoria'] == 'encanamento') ? 'selected' : '' ?>>Encanamento</option>
                    <option value="jardinagem" <?= ($servicoData['categoria'] == 'jardinagem') ? 'selected' : '' ?>>Jardinagem</option>
                </select>
            </div>

            <!-- Região do serviço -->
            <div class="mb-3">
                <label for="regiao" class="form-label">Região</label>
                <select class="form-select" name="regiao" id="regiao">
                    <?php
                    $bairros = [
                        "abranches", "agua_verde", "ahu", "alto_boqueirao", "alto_da_gloria",
                        "alto_da_rua_xv", "atuba", "augusta", "bacacheri", "bairro_alto",
                        "barreirinha", "batel", "bigorrilho", "boa_vista", "bom_retiro",
                        "boqueirao", "butiatuvinha", "cabral", "cachoeira", "cajuru",
                        "campina_do_siqueira", "campo_comprido", "campo_de_santana", "capao_raso", 
                        "capao_da_imbuia", "cascatinha", "caximba", "centro", "centro_civico", 
                        "cidade_industrial", "cristo_rei", "fanny", "fazendinha", "ganchinho", 
                        "guabirotuba", "guaira", "hauer", "hugo_lange", "jardim_botanico", 
                        "jardim_social", "jardim_das_americas", "juveve", "lamenha_pequena", 
                        "lindoia", "merces", "mossungue", "novo_mundo", "orleans", "parolin", 
                        "pilarzinho", "pinheirinho", "portao", "prado_velho", "reboucas", "riviera", 
                        "santa_candida", "santa_felicidade", "santa_quiteria", "santo_inacio", 
                        "seminario", "sitio_cercado", "sao_braz", "sao_francisco", "sao_joao", 
                        "sao_lourenco", "sao_miguel", "taboao", "taruma", "tatuquara", "tingui", 
                        "uberaba", "umbara", "vila_izabel", "vista_alegre", "xaxim"
                    ];
                    foreach ($bairros as $bairro) {
                        $selected = ($servicoData['regiao'] == $bairro) ? "selected" : "";
                        echo "<option value='$bairro' $selected>" . ucfirst(str_replace("_", " ", $bairro)) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Preço do serviço -->
            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" class="form-control" name="preco" id="preco" 
                       value="<?= $servicoData['preco'] ?>" placeholder="Preço R$" required>
            </div>

            <!-- Botão de editar -->
            <div class="d-flex justify-content-center">
                <button type="submit" name="btn-editar" class="btn btn-warning w-100">Atualizar</button>
            </div>
        </form>
    <?php else: ?>
        <p class="text-danger">Serviço não encontrado.</p>
    <?php endif; ?>
</main>
<?php include "../footer.php"; ?>
</body>
</html>
