<?php
session_start();
require_once 'Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cnpj = $_POST['cnpj'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Cria uma instância do banco de dados e obtém a conexão
    $database = new Database();
    $conn = $database->getConnection();

    // Evita SQL Injection
    $cnpj = $conn->real_escape_string($cnpj);
    $password = $conn->real_escape_string($password);

    // Consulta SQL para verificar o usuário e a senha
    $sql = "SELECT * FROM empresa WHERE cnpj = '$cnpj' AND senha = '$password'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // O usuário foi encontrado, redireciona para o painel apropriado
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
            if($role =='3'){
            header("Location: PainelControle.html");
        }
        exit();
    } else {
        echo "Usuário ou senha usuário incorretos!";
    }

    $conn->close();
} else {
    echo "Método de requisição inválido.";
}

?>
