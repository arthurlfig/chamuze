<?php session_start(); 
include "../helpers/biblioteca.php";

verificarSessaoExpirada();
verificarAcesso("solicitante");

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChamuZé - Solicitar Serviço</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light vh-100">

    <?php include "../header/header.php"; ?> <!-- Inclui o cabeçalho -->

    <main class="container d-flex flex-column justify-content-center">
        <h1 class="text-center mt-4 mb-4">Solicitar Serviço</h1>
        <form action="../controller/solicitarServicoController.php" method="POST" enctype="multipart/form-data"
            class="bg-white p-4 shadow-sm rounded">

            <?php
            //Exebição dos erros
            if (isset($_GET['erro'])) {
                switch ($_GET['erro']) {
                    case 1:
                        echo "<div class=\"alert alert-info\" role=\"alert\">
                            Você só pode enviar arquivos JPG, JPEG ou PNG!
                            </div>";
                        break;
                    case 2:
                        echo "<div class=\"alert alert-danger\" role=\"alert\">
                            Ops, algo deu errado. O serviço não foi solicitado!
                            </div>";
                        break;
                }
            }
            ?>
            <input type="hidden" name="id_solicitante" value="<?php echo $_SESSION['usuario']['id_usuario']; ?>">
            <!-- Título do serviço -->
            <div class="mb-3">
                <label for="titulo" class="form-label">Título do Serviço</label>
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título do Serviço"
                    required>
            </div>

            <!-- Descrição do serviço -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição do Serviço</label>
                <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição do serviço"
                    rows="4" required></textarea>
            </div>

            <!-- Imagem do serviço -->
            <div class="mb-3">
                <label for="img_servico" class="form-label">Imagem do Serviço</label>
                <input type="file" class="form-control" name="img_servico" id="img_servico" required>
            </div>

            <!-- Categoria do serviço -->
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" name="categoria" id="categoria">
                    <option value="null">Todas as categorias</option>
                    <option value="jardinagem">Jardinagem</option>
                    <option value="limpeza">Limpeza</option>
                    <option value="eletricidade">Elétrica</option>
                    <option value="encanamento">Encanamento</option>
                    <option value="pintura">Pintura</option>
                    <option value="construcao">Construção</option>
                    <option value="montagem_moveis">Montagem de Móveis</option>
                    <option value="cuidado_idosos">Cuidado de Idosos</option>
                    <option value="cuidado_infantil">Cuidado Infantil</option>
                    <option value="lavagem">Lavagem de Roupas</option>
                    <option value="passadoria">Passadoria</option>
                    <option value="cozinha">Cozinha</option>
                    <option value="cuidados_animais">Cuidados com Animais</option>
                    <option value="outros">Outros</option>
                </select>
            </div>

            <!-- Região do serviço -->
            <div class="mb-3">
                <label for="regiao" class="form-label">Região</label>
                <select class="form-select" name="regiao" id="regiao">
                    <option value="abranches">Abranches</option>
                    <option value="agua_verde">Água Verde</option>
                    <option value="ahu">Ahú</option>
                    <option value="alto_boqueirao">Alto Boqueirão</option>
                    <option value="alto_da_gloria">Alto da Glória</option>
                    <option value="alto_da_rua_xv">Alto da Rua XV</option>
                    <option value="atuba">Atuba</option>
                    <option value="augusta">Augusta</option>
                    <option value="bacacheri">Bacacheri</option>
                    <option value="bairro_alto">Bairro Alto</option>
                    <option value="barreirinha">Barreirinha</option>
                    <option value="batel">Batel</option>
                    <option value="bigorrilho">Bigorrilho</option>
                    <option value="boa_vista">Boa Vista</option>
                    <option value="bom_retiro">Bom Retiro</option>
                    <option value="boqueirao">Boqueirão</option>
                    <option value="butiatuvinha">Butiatuvinha</option>
                    <option value="cabral">Cabral</option>
                    <option value="cachoeira">Cachoeira</option>
                    <option value="cajuru">Cajuru</option>
                    <option value="campina_do_siqueira">Campina do Siqueira</option>
                    <option value="campo_comprido">Campo Comprido</option>
                    <option value="campo_de_santana">Campo de Santana</option>
                    <option value="capao_raso">Capão Raso</option>
                    <option value="capao_da_imbuia">Capão da Imbuia</option>
                    <option value="cascatinha">Cascatinha</option>
                    <option value="caximba">Caximba</option>
                    <option value="centro">Centro</option>
                    <option value="centro_civico">Centro Cívico</option>
                    <option value="cidade_industrial">Cidade Industrial</option>
                    <option value="cristo_rei">Cristo Rei</option>
                    <option value="fanny">Fanny</option>
                    <option value="fazendinha">Fazendinha</option>
                    <option value="ganchinho">Ganchinho</option>
                    <option value="guabirotuba">Guabirotuba</option>
                    <option value="guaira">Guaíra</option>
                    <option value="hauer">Hauer</option>
                    <option value="hugo_lange">Hugo Lange</option>
                    <option value="jardim_botanico">Jardim Botânico</option>
                    <option value="jardim_social">Jardim Social</option>
                    <option value="jardim_das_americas">Jardim das Américas</option>
                    <option value="juveve">Juvevê</option>
                    <option value="lamenha_pequena">Lamenha Pequena</option>
                    <option value="lindoia">Lindóia</option>
                    <option value="merces">Mercês</option>
                    <option value="mossungue">Mossunguê</option>
                    <option value="novo_mundo">Novo Mundo</option>
                    <option value="orleans">Orleans</option>
                    <option value="parolin">Parolin</option>
                    <option value="pilarzinho">Pilarzinho</option>
                    <option value="pinheirinho">Pinheirinho</option>
                    <option value="portao">Portão</option>
                    <option value="prado_velho">Prado Velho</option>
                    <option value="reboucas">Rebouças</option>
                    <option value="riviera">Riviera</option>
                    <option value="santa_candida">Santa Cândida</option>
                    <option value="santa_felicidade">Santa Felicidade</option>
                    <option value="santa_quiteria">Santa Quitéria</option>
                    <option value="santo_inacio">Santo Inácio</option>
                    <option value="seminario">Seminário</option>
                    <option value="sitio_cercado">Sítio Cercado</option>
                    <option value="sao_braz">São Braz</option>
                    <option value="sao_francisco">São Francisco</option>
                    <option value="sao_joao">São João</option>
                    <option value="sao_lourenco">São Lourenço</option>
                    <option value="sao_miguel">São Miguel</option>
                    <option value="taboao">Taboão</option>
                    <option value="taruma">Tarumã</option>
                    <option value="tatuquara">Tatuquara</option>
                    <option value="tingui">Tingui</option>
                    <option value="uberaba">Uberaba</option>
                    <option value="umbara">Umbará</option>
                    <option value="vila_izabel">Vila Izabel</option>
                    <option value="vista_alegre">Vista Alegre</option>
                    <option value="xaxim">Xaxim</option>
                </select>
            </div>

            <!-- Preço do serviço -->
            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" class="form-control" name="preco" id="preco" placeholder="Preço R$" required>
            </div>

            <!-- Botão de envio -->
            <div class="d-flex justify-content-center">
                <button type="submit" name="btn_solicitar" class="btn btn-warning w-100">Solicitar</button>
            </div>
        </form>
    </main>

    <?php include "../footer.php"; ?> <!-- Inclui o rodapé -->

</body>

</html>