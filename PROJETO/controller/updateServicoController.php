<?php
include "../classes/Servico.php"; // Incluindo a classe Servico

// Criando a instância da classe Servico
$servico = new Servico();

// Verificar se os dados do formulário foram recebidos via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebendo os dados do formulário
    $id_servico = $_POST['id_servico'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $regiao = $_POST['regiao'];
    $preco = $_POST['preco'];

    // Inicializar o caminho da imagem
    $caminhoImgServico = '';

    // Verificar se foi enviado um novo arquivo de imagem
    if (isset($_FILES['img_servico']) && $_FILES['img_servico']['error'] == UPLOAD_ERR_OK) {
        // Diretório onde a imagem será salva
        $diretorio = '../uploads/servicos';
        
        // Obter informações sobre o arquivo
        $arquivoTmp = $_FILES['img_servico']['tmp_name'];
        $nomeArquivo = $_FILES['img_servico']['name'];
        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
        
        // Gerar um nome único para o arquivo (pode adicionar mais segurança se necessário)
        $novoNomeArquivo = uniqid('img_') . '.' . $extensao;
        $caminhoImgServico = $diretorio . $novoNomeArquivo;
        
        // Mover o arquivo para o diretório de uploads
        move_uploaded_file($arquivoTmp, $caminhoImgServico);
    } else {
        // Caso não haja upload de imagem, manter o caminho da imagem anterior (você pode buscar essa informação da tabela no banco, se necessário)
        $caminhoImgServico = $_POST['img_servico']; // Ou pegar a imagem atual de alguma forma se necessário
    }

    // Chamar o método para atualizar o serviço
    $resultado = $servico->atualizar(
        $id_servico, 
        $titulo, 
        $descricao, 
        $categoria, 
        $regiao, 
        $caminhoImgServico, 
        $preco
    );

    // Verificar se a atualização foi bem-sucedida
    if ($resultado) {
        // Redirecionar de volta para a página de serviços ou outra página de sua escolha
        header("Location: ../solicitante/visualizarServicos.php");
        exit;
    } else {
        // Se houver algum erro, exibir uma mensagem
        header("Location: ../solicitante/updateServico.php?erro=1"); //Erro 1: Algo deu errado na atualização
    }
}
?>
