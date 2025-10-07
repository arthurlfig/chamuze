<?php
session_start();

include "../classes/Servico.php";
include "../helpers/biblioteca.php";

//Verificação de restrição de acesso
verificarSessaoExpirada();
verificarAcesso('prestador');


//Criação da instancia de serviço
$servico = new Servico();

//Captura dos filtros da URL
$categoriaSelecionada = isset($_GET['categoria']) && $_GET['categoria'] !== 'null' ? $_GET['categoria'] : null;
$regiaoSelecionada = isset($_GET['local_servico']) && $_GET['local_servico'] !== 'null' ? $_GET['local_servico'] : null;


//Verificação de existencia de filtros e busca variada de acordo com o filtro
if ($categoriaSelecionada && $regiaoSelecionada) {
    $servicos = $servico->buscarPorCategoriaeRegiao($regiaoSelecionada, $categoriaSelecionada);
} elseif ($categoriaSelecionada) {
    $servicos = $servico->buscarPorCategoria($categoriaSelecionada);
} elseif ($regiaoSelecionada) {
    $servicos = $servico->buscarPorRegiao($regiaoSelecionada);
} else {
    $servicos = $servico->buscarTodosDisponiveis();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChamuZé - Início Prestador</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estiloInicialPrestador.css">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header/header.php"; ?>

    <main class="container  py-5">
        <h1 class="text-center mt-4 mb-4">Serviços Disponíveis</h1>
        <div class="mb-3">
            <form action="" method="GET" class="filtrod-flex flex-row">
                <div class="d-flex">
                    <div class="m-2">
                        <select name="categoria" class="form-select">
                            <option value="null">Todas as categorias</option>
                            <option value="jardinagem" <?= $categoriaSelecionada == "jardinagem" ? "selected" : "" ?>>Jardinagem</option>
                            <option value="limpeza" <?= $categoriaSelecionada == "limpeza" ? "selected" : "" ?>>Limpeza</option>
                            <option value="eletricidade" <?= $categoriaSelecionada == "eletrica" ? "selected" : "" ?>>Elétrica</option>
                            <option value="encanamento" <?= $categoriaSelecionada == "encanamento" ? "selected" : "" ?>>Encanamento</option>
                            <option value="pintura" <?= $categoriaSelecionada == "pintura" ? "selected" : "" ?>>Pintura</option>
                            <option value="construcao" <?= $categoriaSelecionada == "construcao" ? "selected" : "" ?>>Construção</option>
                            <option value="montagem" <?= $categoriaSelecionada == "montagem_moveis" ? "selected" : "" ?>>Montagem de Móveis</option>
                            <option value="cuidado_idosos" <?= $categoriaSelecionada == "cuidado_idosos" ? "selected" : "" ?>>Cuidado de Idosos</option>
                            <option value="cuidado_infantil" <?= $categoriaSelecionada == "cuidado_infantil" ? "selected" : "" ?>>Cuidado Infantil</option>
                            <option value="lavagem" <?= $categoriaSelecionada == "lavagem" ? "selected" : "" ?>>Lavagem de Roupas</option>
                            <option value="passadoria" <?= $categoriaSelecionada == "passadoria" ? "selected" : "" ?>>Passadoria</option>
                            <option value="cozinha" <?= $categoriaSelecionada == "cozinha" ? "selected" : "" ?>>Cozinha</option>
                            <option value="cuidados_animais" <?= $categoriaSelecionada == "cuidados_animais" ? "selected" : "" ?>>Cuidados com Animais</option>
                            <option value="outros" <?= $categoriaSelecionada == "outros" ? "selected" : "" ?>>Outros</option>
                        </select>
                    </div>
                    <div class="m-2">
                        <select name="local_servico" class="form-select">
                            <option value="null" <?= $regiaoSelecionada == "null" ? "selected" : "" ?>>Todas as regiões</option>
                            <option value="abranches" <?= $regiaoSelecionada == "abranches" ? "selected" : "" ?>>Abranches</option>
                            <option value="agua_verde" <?= $regiaoSelecionada == "agua_verde" ? "selected" : "" ?>>Água Verde
                            </option>
                            <option value="ahu" <?= $regiaoSelecionada == "ahu" ? "selected" : "" ?>>Ahú</option>
                            <option value="alto_boqueirao" <?= $regiaoSelecionada == "alto_boqueirao" ? "selected" : "" ?>>Alto
                                Boqueirão</option>
                            <option value="alto_da_gloria" <?= $regiaoSelecionada == "alto_da_gloria" ? "selected" : "" ?>>Alto da
                                Glória</option>
                            <option value="alto_da_xv" <?= $regiaoSelecionada == "alto_da_xv" ? "selected" : "" ?>>Alto da XV
                            </option>
                            <option value="barreirinha" <?= $regiaoSelecionada == "barreirinha" ? "selected" : "" ?>>Barreirinha
                            </option>
                            <option value="batel" <?= $regiaoSelecionada == "batel" ? "selected" : "" ?>>Batel</option>
                            <option value="boa_vista" <?= $regiaoSelecionada == "boa_vista" ? "selected" : "" ?>>Boa Vista</option>
                            <option value="boqueirao" <?= $regiaoSelecionada == "boqueirao" ? "selected" : "" ?>>Boqueirão</option>
                            <option value="cachoeira" <?= $regiaoSelecionada == "cachoeira" ? "selected" : "" ?>>Cachoeira</option>
                            <option value="cajuru" <?= $regiaoSelecionada == "cajuru" ? "selected" : "" ?>>Cajuru</option>
                            <option value="campo_comprido" <?= $regiaoSelecionada == "campo_comprido" ? "selected" : "" ?>>Campo
                                Comprido</option>
                            <option value="capao_da_imbuia" <?= $regiaoSelecionada == "capao_da_imbuia" ? "selected" : "" ?>>Capão
                                da Imbuia</option>
                            <option value="capao_raso" <?= $regiaoSelecionada == "capao_raso" ? "selected" : "" ?>>Capão Raso
                            </option>
                            <option value="centro" <?= $regiaoSelecionada == "centro" ? "selected" : "" ?>>Centro</option>
                            <option value="cic" <?= $regiaoSelecionada == "cic" ? "selected" : "" ?>>CIC</option>
                            <option value="cidade_industrial" <?= $regiaoSelecionada == "cidade_industrial" ? "selected" : "" ?>>
                                Cidade Industrial</option>
                            <option value="cristore" <?= $regiaoSelecionada == "cristore" ? "selected" : "" ?>>Cristo Rei</option>
                            <option value="fanny" <?= $regiaoSelecionada == "fanny" ? "selected" : "" ?>>Fanny</option>
                            <option value="ganchinho" <?= $regiaoSelecionada == "ganchinho" ? "selected" : "" ?>>Ganchinho</option>
                            <option value="guabirotuba" <?= $regiaoSelecionada == "guabirotuba" ? "selected" : "" ?>>Guabirotuba
                            </option>
                            <option value="hauer" <?= $regiaoSelecionada == "hauer" ? "selected" : "" ?>>Hauer</option>
                            <option value="jardim_botanico" <?= $regiaoSelecionada == "jardim_botanico" ? "selected" : "" ?>>Jardim
                                Botânico</option>
                            <option value="jardim_social" <?= $regiaoSelecionada == "jardim_social" ? "selected" : "" ?>>Jardim
                                Social</option>
                            <option value="juveve" <?= $regiaoSelecionada == "juveve" ? "selected" : "" ?>>Juvevê</option>
                            <option value="lindoia" <?= $regiaoSelecionada == "lindoia" ? "selected" : "" ?>>Lindóia</option>
                            <option value="mercês" <?= $regiaoSelecionada == "mercês" ? "selected" : "" ?>>Mercês</option>
                            <option value="monte_castelo" <?= $regiaoSelecionada == "monte_castelo" ? "selected" : "" ?>>Monte
                                Castelo</option>
                            <option value="novo_mundo" <?= $regiaoSelecionada == "novo_mundo" ? "selected" : "" ?>>Novo Mundo
                            </option>
                            <option value="parolin" <?= $regiaoSelecionada == "parolin" ? "selected" : "" ?>>Parolin</option>
                            <option value="pinheirinho" <?= $regiaoSelecionada == "pinheirinho" ? "selected" : "" ?>>Pinheirinho
                            </option>
                            <option value="portao" <?= $regiaoSelecionada == "portao" ? "selected" : "" ?>>Portão</option>
                            <option value="reboucas" <?= $regiaoSelecionada == "reboucas" ? "selected" : "" ?>>Rebouças</option>
                            <option value="santa_candida" <?= $regiaoSelecionada == "santa_candida" ? "selected" : "" ?>>Santa
                                Cândida</option>
                            <option value="santo_inacio" <?= $regiaoSelecionada == "santo_inacio" ? "selected" : "" ?>>Santo Inácio
                            </option>
                            <option value="sao_braz" <?= $regiaoSelecionada == "sao_braz" ? "selected" : "" ?>>São Braz</option>
                            <option value="sao_francisco" <?= $regiaoSelecionada == "sao_francisco" ? "selected" : "" ?>>São
                                Francisco</option>
                            <option value="sitio_cercado" <?= $regiaoSelecionada == "sitio_cercado" ? "selected" : "" ?>>Sítio
                                Cercado</option>
                            <option value="taquaral" <?= $regiaoSelecionada == "taquaral" ? "selected" : "" ?>>Taquaral</option>
                            <option value="tingui" <?= $regiaoSelecionada == "tingui" ? "selected" : "" ?>>Tingui</option>
                            <option value="uberaba" <?= $regiaoSelecionada == "uberaba" ? "selected" : "" ?>>Uberaba</option>
                            <option value="umbara" <?= $regiaoSelecionada == "umbara" ? "selected" : "" ?>>Umbará</option>
                            <option value="xaxim" <?= $regiaoSelecionada == "xaxim" ? "selected" : "" ?>>Xaxim</option>
                        </select>
                    </div>
                    <div><button type="submit" class="btn btn-warning m-2"><i class="bi bi-funnel-fill"></i> Filtrar</button></div>
                </div>
            </form>
        </div>

        <?php
        // Verifica se a variável $servicos está vazia (não possui nenhum serviço publicado)
        if (count($servicos) < 1) {
            echo '<div class="alert alert-info mt-4" role="alert">
                    Nenhum serviço disponível no momento.
                </div>';
        }
        ?>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php foreach ($servicos as $row):?>
                <div class="col">
                    <div class="card shadow-sm h-100 position-relative">
                        <a href="verServico.php?id_servico=<?= $row['id_servico'] ?>" class="text-decoration-none text-dark">
                            <div class="card-header d-flex">
                                <h5 class="card-title mb-0"><?= $row['titulo'] ?></h5>
                            </div>

                            <div class="row-1">
                                <div class="card-body d-flex flex-column flex-md-row">
                                    
                                    <div class="flex-shrink-0 me-md-3 mb-3 mb-md-0 text-center">
                                        <img src="<?= $row['img_servico'] ?>" class="img-fluid rounded" alt="Imagem do Serviço"
                                            style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 small"><strong>Categoria:</strong> <?= $row['categoria'] ?>
                                        </p>
                                        <p class="text-muted mb-1 small"><strong>Região:</strong> <?= $row['local_servico'] ?>
                                        </p>
                                        <p class="card-text small"><?= $row['descricao'] ?></p>
                                        <p class="text-muted mb-2 small"><strong>Disponibilidade Serviço:</strong>
                                            <?= $row['status_servico'] ?></p>
                                        <p class="fw-bold text-success mb-0" style="font-size: 1.1em;">
                                            <i class="bi bi-currency-dollar"></i> R$: <?= $row['preco'] ?>
                                        </p>
                                    </div>
                                
                                </div>
                            </div>
                        </a>

                        <div class="row-2">
                            <form action="../solicitante/paginaSolicitante.php" method="GET">
                                <?php $solicitante = buscarSolicitanteNoBancoPeloId($row['id_solicitante']) ?>
                                <button class="botao-prestador-responsavel" 
                                        style="display:<?= $stiloPrestadorResponsavel ?>" 
                                        name="id_solicitante" 
                                        value="<?= $row['id_solicitante'] ?>">
                                    <strong><i class="bi bi-person-video"></i> Solicitante:</strong> <?= $solicitante['nome'] ?>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include "../footer.php"; ?>
</body>

</html>