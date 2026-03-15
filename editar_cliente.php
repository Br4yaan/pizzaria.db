# Arquivo: editar_clientes.php
<?php
    //Editar as informações do cliente
    require_once 'conexao.php';

    // Inicializa variáveis para os dados do cliente e mensagens de erro.
    $cliente = null;
    $mensagem_erro="";
    $id_cliente = null;

    //verifica se um ID foi passado via GET e se é um inteiro positivo.
    if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT, ["options" =>["min_range" => 1]])) {
        // Armazena o ID do cliente de forma segura.
        $id_cliente = $_GET['id'];

        // Busca os dados do cliente no banco
        // Prepara a consulta SQL para selecionar o cliente com o ID fornecido.
        $sql = "SELECT * FROM clientes WHERE id = ?";

        //Prepara a declaração.
        if ($stmt = mysqli_prepare($conexao, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id_cliente);

            //Executa a declaração.
            if (mysqli_stmt_execute($stmt)) {
                // Obtém o resultado da consulta.
                $resultado = mysqli_stmt_get_result($stmt);

                // Verifica se encontrou um cliente com ID selecionado.
                if (mysqli_num_rows($resultado) == 1) {
                    //busca os dados do cliente como um array associativo.
                    $cliente = mysqli_fetch_assoc($resultado);
                } else{
                    // se não encontrou o cliente(ID inválido na URL, por exemplo)
                    $mensagem_erro = "Cliente não encontrado!";
                }
                // Libera o resultado.
                mysqli_free_result($resultado);
                } else {
                    // se a execução da query falhar
                    $mensagem_erro = "Erro ao buscar dados do cliente: " .mysqli_stmt_error($stmt);
                }
                // Fecha a declaração
                mysqli_stmt_close($stmt);

        }else {
            // Se o ID não foi fornecido ou é inválido.
            $mensagem_erro = "ID do cliente inválido ou não fornecido.";
        }
        $pageTitle = $cliente ? "Editar cliente: " . htmlspecialchars($cliente['nome'])
        : "Erro ao Editar Cliente";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Pizzaria</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1><?php echo $pageTitle; ?></h1>


<?php
    // Exibe a mensagem de erro, se houver.
    if (!empty($mensagem_erro)): ?>
    <div class="mensagem-erro"><?php echo htmlspecialchars($mensagem_erro); ?></div>
    <p><a href="listar_clientes.php">Voltar para a listagem </a></p>
        <?php
        //se não houver erro e o cliente foi encontrado, exibe o formulário de edição.
        elseif ($cliente):
        ?>
        <form action="processa_cadastro.php" method="post">
            <! -- Campo oculto para armazenar o ID do cliente, necessário para identificar qual cliente está sendo editado no processamento do formulário -- >
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_cliente); ?>">
       
            <div>
                <label for="nome">Nome:</label>
                <!-- Pré preenche o campo com o nome do cliente, usando htmlspecialchars para evitar problemas de segurança -->
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required>
            </div>
            <div>
                <label for="telefone">Telefone:</label>
                <input type="tel" name="telefone" id="telefone" value="<?php
                echo htmlspecialchars($cliente['telefone']); ?>" placeholder="(XX) XXXXX-XXXX" required>
            </div>
            <div>
                <label for="endereco">Endereço:</label>
                <textarea name="endereco" id="endereco" rows="3"><?php echo htmlspecialchars($cliente['endereco'] ?? ''); ?></textarea>
            </div>

            <div>
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($cliente['email'] ?? ''); ?>">
            </div>

            <! -- botao para submter as alterações do cliente -- >
            <input type="submit" value="Salvar Alterações">
            </div>

</form>

            <div class="navegacao-extra">
                <a href="listar_clientes.php">Cancela e Voltar</a>
            </div>
<?php endif; ?>
<?php
    //fecha a conexao que foi aberta no inicio do arquivo.
   
    if(isset($conexao)) {
        mysqli_close($conexao);
    }
    ?>
</body>
</html>
