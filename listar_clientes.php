#listar_clientes.php
<?php
    // -- Listar os clientes --
    // Inclui o arquivo de conexão para acessar o banco de dados.
    require_once "conexao.php";

    //Define o tiulo da página
    $pageTitle = "Listagem de Clientes";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Pizzaria</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1><?php echo $pageTitle;?></h1>

<! -- Link para voltar para a página inicial -- >
    <div class="link-cadastro">
        <a href="index.html"> Cadastrar Novo Cliente</a>
    </div>

    <table>
        <thead>
            <! -- Cabeçalho da tabela -- >
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php
                // -- logica para buscar os clientes no banco de dados e exibi-los na tabela --
                // Consulta SQL para selecionar todos os clientes
                $sql = "SELECT * FROM clientes ORDER BY nome ASC";

                // Executa a consulta e armazena o resultado
                // mysqli_query() retorna um objeto de resultado em caso de sucesso ou false em caso de erro
                //caso de erro
                if ($resultado = mysqli_query($conexao, $sql)) {
                    // verifica se a consulta retornou alguma linha ( algum cliente encontrado)
                    if(mysqli_num_rows($resultado) > 0) {
                        // Loop para percorrer cada linha do resultado e exibir os dados na tabela
                        while ($cliente = mysqli_fetch_assoc($resultado)) {
                            // inicia a linha da tabela para cada cliente
                            echo "<tr>";
                            echo "<td>" .htmlspecialchars($cliente['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($cliente['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($cliente['telefone']) . "</td>";
                            echo "<td>" . ($cliente['endereco'] ? htmlspecialchars($cliente['endereco']) : '-') . "</td>";
                            echo "<td>" . ($cliente['email'] ? htmlspecialchars($cliente['email']) : '-') . "</td>";
                            // Cria a celula para os botoes de ação (editar e excluir)
                            echo "<td class='acoes'>";
                                    // cria o link para editar o cliente, passando o id do cliente como parametro na URL
                                    echo "<a href='editar_clientes.php?id=" . $cliente['id'] . "' class='btn-editar'>Editar</a>";
                                    // cria o link para excluir o cliente, passando o id do cliente como parametro na URL
                                    // Adiciona uma confirmação antes de excluir o cliente
                                    echo "<a href='excluir_clientes.php?id=" . $cliente['id'] . "' class='btn-excluir' onclick='return confirm(\"Tem certeza que deseja excluir este cliente? Esta ação não pode ser desfeita.');\">Excluir</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        // libera memória do resultado após o loop
                        mysqli_free_result($resultado);
                    } else {
                        // Se não houver clientes cadastrados, exibe uma mensagem na tabela
                        echo "<tr><td colspan='6'> Nenhum cliente encontrado. </td></tr>";

                    }
                   
                }else {
                        // Se a consulta não retornou nenhum cliente, exibe uma mensagem na tabela
                        // myqli_error() retorna uma string com a descrição do erro ocorrido na última operação de banco de dados
                        echo "<tr><td colspan='6'> Erro ao a consulta: " . mysqli_error($conexao) . "</td></tr>";

                }  
                 // fecha a conexão com o banco de dados após exibir os clientes
                    mysqli_close($conexao);
            ?>
        </tbody>
    </table>
   


</body>
</html>
