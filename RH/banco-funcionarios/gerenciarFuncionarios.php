<?php
include '../../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados
    $nome = $_POST['nome'];
    $banco = $_POST['banco'];
    $agencia = $_POST['agencia'];
    $tipo_corrente_poupanca = $_POST['tipo_corrente_poupanca'];
    $tipo_conta = $_POST['tipo_conta'];

    // Inserção no banco (tabela 'dados_bancarios')
    $sql = "INSERT INTO dados_bancarios (nome, banco, agencia, tipo_corrente_poupanca, tipo_conta)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $banco, $agencia, $tipo_corrente_poupanca, $tipo_conta);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'dados_bancarios' => [
                'nome' => $nome,
                'banco' => $banco,
                'agencia' => $agencia,
                'tipo_corrente_poupanca' => $tipo_corrente_poupanca,
                'tipo_conta' => $tipo_conta,
            ]
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
}
?>
