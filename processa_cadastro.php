#processa_cadastro.php
<?php
// Inclui o arquivo de conexão com o banco de dados.
// 'require_once' garante que o arquivo seja incluído apenas 1 vez.
// Gera um erro fatal se o arquivo não for encontrado, interrompendo o script
require_once 'conexao.php';

// Criar variáveis para armazenar mensagens de feedback (sucesso ou erro)
$mensagem = "";
$tipo_mensagem = ""; // sucesso ou erro

// Verifica se a requisição HTTP foi feita
// Isso garante que o script só executa a lógica de inserção se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // -- Validação de entrada --
    // Verifica se os campos obrigatórios (nome e telefone) foram enviados e não estão vazios.
    // trim() remove espaços em branco do início e do fim da string.
    if (
        isset($_POST['nome']) && isset($_POST['telefone']) &&
        !empty(trim($_POST['nome'])) &&
        !empty(trim($_POST['telefone']))
    ) {

        // -- Coleta de dados --
        // Obtém valores dos campos do formulário
        // Usar trim() novamente aqui é uma boa prática
        $nome = trim($_POST['nome']);
        $telefone = trim($_POST['telefone']);

        // Para campos não obrigatórios, verifica se foram enviados antes de atribuir.
        // Usa o operador ternário: (condição) ? valor se verdadeiro : valor se falso.
        // Se 'endereco' foi enviado e não está vazio após o trim(), usa o valor;
        // Senão, define como NULL.
        $endereco = isset($_POST['endereco']) && !empty(trim($_POST['endereco']))
            ? trim($_POST['endereco'])
            : null;

        // Se 'email' foi enviado e não está vazio.
        $email = isset($_POST['email']) && !empty(trim($_POST['email']))
            ? trim($_POST['email'])
            : null;

        // Define a string com placeholders (?) para segurança
        $sql = "INSERT INTO clientes (nome, telefone, email, endereco) VALUES (?, ?, ?, ?)";

        // CORREÇÃO AQUI:
        // Usamos mysqli_prepare (passando a conexão e o SQL) em vez de mysqli_stmt_prepare.
        // Retorna um objeto de statement (declaração) ou 'false' em caso de erro
        if ($stmt = mysqli_prepare($conexao, $sql)) {

            // -- Vinculação dos Parâmetros (Binding) --
            // Associa as variáveis PHP aos placeholders, tipos: var1, var2....
            // 's' indica que o tipo de dado é uma string
            // Para NULL, podemos usar 's' e passar NULL diretamente (mysqli lida com isso se a coluna permitir NULL).
            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $nome,        // $param_nome
                $telefone,    // $param_telefone
                $email,       // $param_email (pode ser NULL)
                $endereco     // $param_endereco (pode ser NULL)
            );

            // -- Execução da Consulta --
            // Tenta executar a declaração preparada (agora com os valores vinculados).
            // Retorna 'true' em caso de sucesso ou false em caso de erro.
            if (mysqli_stmt_execute($stmt)) {
                // Se a execução foi bem-sucedida, define a mensagem de sucesso.
                $mensagem = "Cliente cadastrado com sucesso!";
                $tipo_mensagem = "sucesso"; // Define o tipo para usar no CSS              
            } else {
                // Se ocorreu um erro durante a execução, define mensagem de erro.
                // mysqli_stmt_error() retorna a descrição do erro da última operação.
                // Tratamento específico para erro de chave única (UNIQUE) no email.
                if (mysqli_errno($conexao) == 1062) { // Código de erro MySQL para entrada duplicada
                    $mensagem = "Erro ao cadastrar: O e-mail informado (" . htmlspecialchars($email) . ") já está cadastrado.";
                    $tipo_mensagem = "erro";
                } else {
                    $mensagem = "Erro ao cadastrar o cliente: " . mysqli_stmt_error($stmt);
                    $tipo_mensagem = "erro";
                }
            }

            // -- Fecha o Statement --
            // Libera os recursos associados ao objeto de statement preparado.
            mysqli_stmt_close($stmt);
        } else {
            // Se a preparação da consulta falhou (ex.: SQL inválido), define erro.
            $mensagem = "Erro na preparação da consulta: " . mysqli_error($conexao);
            $tipo_mensagem = "erro";
        }
    } else {
        // Se os campos obrigatórios não foram preenchidos, define a mensagem de erro.
        $mensagem = "Por favor, preencha todos os campos obrigatórios: Nome e Telefone.";
        $tipo_mensagem = "erro"; // Define o tipo para usar no CSS
    }
}

// Fecha a conexão com o banco de dados para liberar recursos do servidor.
mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do cadastro</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <div class="container-resultado">
        <h1>Resultado do Cadastro</h1>

        <?php
        //verifica se existe uma mensagem para exibir
        if (!empty($mensagem)) {
            // exibe a mensagem dentro de uma div com a classe CSS apropriada
            //(mensagem-sucesso ou mensagem-erro).
            //htmlspecialchars() é usado para prevenir ataque malicioso.
            echo "<div class='mensagem-" . htmlspecialchars($tipo_mensagem) . "'>" . htmlspecialchars($mensagem) . "</div>";
        }
        ?>

        <a href="index.html" class="botao-voltar">Voltar para o cadastro</a>
    </div>
</body>

</html>
