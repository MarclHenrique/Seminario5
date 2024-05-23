<?php
session_start();

require_once 'Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Cria uma instância do banco de dados e obtém a conexão
    $database = new Database();
    $conn = $database->getConnection();

    // Evita SQL Injection
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Consulta SQL para verificar o usuário e a senha
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$password' and tp_usuario = '$role'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // O usuário foi encontrado, redireciona para o painel apropriado
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
            if($role =='1'){
            header("Location: PainelControleAdm.php");
        } else if ($role == '2'){
            header("Location: PainelControleA.php");
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
