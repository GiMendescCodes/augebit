<?php
include '../../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['nome']) || empty($_POST['nome'])) {
        echo json_encode(['success' => false, 'error' => 'Nome não fornecido']);
        exit;
    }

    $nome = $_POST['nome'];

    // Verificar se o profissional existe
    $query = $conn->prepare("SELECT * FROM profissional WHERE nome = ?");
    $query->bind_param("s", $nome);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Profissional não encontrado']);
        exit;
    }

    $query->close();

    // Apagar o profissional do banco
    $sql = "DELETE FROM profissional WHERE nome = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
}
?>
