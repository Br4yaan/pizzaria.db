#index.html
<!DOCTYPE html>
<html lang="en">  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Clientes - Pizzaria</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Cadastro de Clientes</h1>

    <!--indica o formulário de cadastro-->
    <!--action = processa_cadastro.php: Para onde os dados do formulário serão enviados para processamento-->
    <form action="processa_cadastro.php" method="POST">
        <div>
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <div>
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" placeholder="(XX)XXXXX-XXXX" required>
        </div>

        <div>
            <label for="endereco">Endereço Completo:</label>
            <textarea name="endereco" name="endereco" rows="3" required></textarea>
        </div>

        <div>
            <label for="email">E-mail (Opcional):</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <input type="submit" value="Cadastrar">
        </div>

        <div class="navegacao-extra">
            <a href="listar_clientes.php">Clientes Cadastrados</a>
    </form>
</body>
</html>
