# Arquivo: conexao.php
<?php
//Define
    define('DB_SERVER','localhost');

    define('DB_USERNAME','root');

    define('DB_PASSWORD','dev@2025');

    define('DB_NAME','pizzaria_db');

    $conexao = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conexao===false){
        die("ERRO: Nao foi possivel conectar ao banco de dados . " . mysqli_connect_error());
    }

    mysqli_set_charset($conexao, "utf8");
?>
