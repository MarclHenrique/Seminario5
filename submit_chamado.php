<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['username'])) {
    die("Acesso negado. Por favor, faça login primeiro.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cnpj = $_POST['cnpj'];
    $nome = $_POST['nome'];
    $status_ticket = $_POST['status_ticket'];
    $prioridade = $_POST['prioridade'];
    $descricao = $_POST['descricao'];
    $cod_empresa = $_POST['cod_empresa'];
    $data_hora = date('Y-m-d H:i:s'); // Data e hora atuais

    // Conectando ao banco de dados
    $database = new Database();
    $conn = $database->getConnection();

    // Evitar SQL Injection
    $cnpj = $conn->real_escape_string($cnpj);
    $nome = $conn->real_escape_string($nome);
    $status_ticket = $conn->real_escape_string($status_ticket);
    $prioridade = $conn->real_escape_string($prioridade);
    $descricao = $conn->real_escape_string($descricao);
    $cod_empresa = $conn->real_escape_string($cod_empresa);

    // Inserindo os dados no banco de dados
    $sql = "INSERT INTO ticket (status_ticket, data_hora, prioridade, descricao, cod_empresa)
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $status_ticket, $data_hora, $prioridade, $descricao, $cod_empresa);

    if ($stmt->execute()) {
        echo "Chamado cadastrado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
