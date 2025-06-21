<?php
include '../../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['cpf']) || empty($_POST['cpf'])) {
        echo json_encode(['success' => false, 'error' => 'CPF não fornecido']);
        exit;
    }

    $cpf = $_POST['cpf'];

    // Primeiro: pegar o nome da foto para excluir do servidor (se existir)
    $queryFoto = $conn->prepare("SELECT foto FROM funcionarios WHERE cpf = ?");
    $queryFoto->bind_param("s", $cpf);
    $queryFoto->execute();
    $resultado = $queryFoto->get_result();

    if ($resultado->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Funcionário não encontrado']);
        exit;
    }

    $linha = $resultado->fetch_assoc();
    $foto = $linha['foto'];
    $queryFoto->close();

    // Apagar o funcionário do banco
    $sql = "DELETE FROM funcionarios WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);

    if ($stmt->execute()) {
        // Se tinha foto, apagar do servidor
        if ($foto && file_exists("uploads/" . $foto)) {
            unlink("uploads/" . $foto);
        }

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
