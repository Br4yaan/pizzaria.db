#processa_alteração.php
<?php
    // Processa a alteração dos dados do cliente no banco de dados.

    require_once "conexao.php";

    // inicializa variáveis de feedback para o usuário.
    $mensagem = "";
    $tipo_mensagem = "";


    // verifica se requisição é POST e se o ID do cliente é válido.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // verifica se os campos obrigatórios estão presentes e se o ID é um inteiro positivo.
        // e não estão vazios.
        if (isset($_POST['id'], $_POST['nome'], $_POST['telefone']) &&
            filter_var($_POST['id'], FILTER_VALIDATE_INT) && // valida se o ID é um inteiro
            !empty(trim($_POST['nome'])) &&
            !empty(trim($_POST['telefone']))) {
                // Coleto e limpa os dados
                $id = $_POST['id']; // ID do cliente a ser atualizado
                $nome = trim($_POST['nome']);
                $telefone = trim($_POST['telefone']);
                // Campos opcionais (null se estiverem vazios)
                $endereco = isset($_POST['endereco']) && !empty(trim($_POST['endereco'])) ? trim($_POST['endereco']) : NULL;
                $email = isset($_POST['email']) && !empty(trim($_POST['email'])) ? trim($_POST['email']) : NULL;
                // Prepara a consulta SQL para atualizar os dados do cliente.
                // Query para atualizar os dados do cliente com base no ID fornecido.
                $sql = "UPDATE clientes SET nome = ?, telefone = ?, endereco = ?, email = ? WHERE id = ?";
                // Prepara a declaração SQL.
                if ($stmt = mysqli_prepare($conexao, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssi", $param_nome, $param_telefone, $param_endereco, $param_email, $param_id);



           
                    // Define os valores dos parâmetros  
                    $param_nome = $nome;
                    $param_telefone = $telefone;
                    $param_endereco = $endereco; // pode ser NULL
                    $param_email = $email; // pode ser NULL
                    $param_id = $id; // ID do cliente a ser atualizado  
                   
                    // Executa a declaração.
                    if (mysqli_stmt_execute($stmt)) {

                }
            }
        }  
    }
?>
