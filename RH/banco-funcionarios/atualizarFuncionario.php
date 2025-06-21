<?php
include '../../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome']; // identificador para atualizar
    $banco = $_POST['banco'];
    $agencia = $_POST['agencia'];
    $tipo_corrente_poupanca = $_POST['tipo_corrente_poupanca'];
    $tipo_conta = $_POST['tipo_conta'];

    // Atualizar dados na tabela 'dados_bancarios'
    $sql = "UPDATE dados_bancarios 
            SET banco = ?, agencia = ?, tipo_corrente_poupanca = ?, tipo_conta = ? 
            WHERE nome = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $banco, $agencia, $tipo_corrente_poupanca, $tipo_conta, $nome);

    header('Content-Type: application/json');

    if ($stmt->execute()) {
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
