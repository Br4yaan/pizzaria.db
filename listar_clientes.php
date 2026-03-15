<?php
    // -- Listar os clientes --
    // Inclui o arquivo de conexão com o banco de dados.
    require_once 'conexao.php';

    // Define o título da página
    $pageTitle = "Listagem de Clientes";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle;?> - Pizzaria</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1><?php echo $pageTitle;?></h1>

<!-- link para voltar a pagina de cadastro -->
<div class="link-cadastro">
    <a href="index.html"> Cadastro Novo Cliente </a>
</div>

<table>
    <thead>
        <!-- cabecalho da tabela -->
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>E-mail</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
            // -- Logica para buscar e exibir os clientes --
            // Cria a consulta SQL para selecionar todos os clientes, ordenados por nome.
            $sql = "SELECT * FROM clientes ORDER BY nome ASC";

            // Executa a consulta no banco de dados.
            //mysql_query() retorna um objeto de resultado em caso de sucesso ou false em caso de erro.
            if($resultado = mysqli_query($conexao,$sql)){
                // Verifica se a consulta retornou alguma linha (algum cliente).
                if(mysqli_num_rows($resultado) > 0){
                    // mysqli_fetch_assoc() busca a proxima linha como um array associaivo.
                    while($cliente= mysqli_fetch_assoc($resultado)){
                        // inicia uma linha da tabela para cada cliente.
                        echo "<tr>";
                        echo "<td>".htmlspecialchars($cliente['id'])."</td>";
                        echo "<td>".htmlspecialchars($cliente['nome'])."</td>";
                        echo "<td>".htmlspecialchars($cliente['telefone'])."</td>";
                        echo "<td>".htmlspecialchars($cliente['endereco'])."</td>";
                        echo "<td>".htmlspecialchars($cliente['email'])."</td>";
                        echo "</tr>";
                    }
                }
            }
        ?>
    </tbody>
</table>

</body>
</html>
