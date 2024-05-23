<?php
session_start();
require_once 'database.php';

// Função para inserir um novo analista
function inserirAnalista($nome, $email, $senha, $telefone)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Use prepared statements para evitar SQL injection
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, telefone, tp_usuario) VALUES (?, ?, ?, ?, '2')");
    $stmt->bind_param("ssss", $nome, $email, $senha, $telefone);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

// Função para deletar um analista
function deletarAnalista($id)
{
    $db = new Database();
    $conn = $db->getConnection();
    
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

// Função para atualizar os dados de um analista
function atualizarAnalista($id, $nome, $email, $senha, $telefone)
{
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ?, telefone = ? WHERE id_usuario = ?");
    $stmt->bind_param("ssssi", $nome, $email, $senha, $telefone, $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

// Função para buscar todos os analistas
function buscarAnalistas()
{
    $db = new Database();
    $conn = $db->getConnection();

    $result = $conn->query("SELECT id_usuario, nome, email, telefone FROM usuarios WHERE tp_usuario = '2'");

    $analistas = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $analistas[] = $row;
        }
    }

    $conn->close();

    return $analistas;
}

// Se o método de requisição for POST, verifica qual ação realizar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == "inserir") {
            inserirAnalista($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['telefone']);
        } elseif ($action == "deletar") {
            deletarAnalista($_POST['id']);
        } elseif ($action == "atualizar") {
            atualizarAnalista($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['telefone']);
        }
    }
}

// Busca todos os analistas
$analistas = buscarAnalistas();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipe - Gerenciamento de Analistas</title>
    <link rel="stylesheet" href="assets/css/styleEquipe.css">
</head>

<body>
    <div class="container">
        <h2>Gerenciamento de Analistas</h2>

        <h3>Inserir Novo Analista</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="action" value="inserir">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required><br>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required><br>
            <button type="submit">Inserir</button>
        </form>

        <h3>Analistas Cadastrados</h3>
        <table>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($analistas as $analista) : ?>
                <tr>
                    <td><?php echo $analista['nome']; ?></td>
                    <td><?php echo $analista['email']; ?></td>
                    <td><?php echo $analista['telefone']; ?></td>
                    <td>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="action" value="deletar">
                            <input type="hidden" name="id" value="<?php echo $analista['id_usuario']; ?>">
                            <button type="submit">Deletar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>
