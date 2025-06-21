<?php
include '../../conexao.php';

header('Content-Type: application/json');

// Consulta na tabela dados_bancarios com os campos informados
$sql = "SELECT nome, banco, agencia, tipo_corrente_poupanca, tipo_conta FROM dados_bancarios";
$result = $conn->query($sql);

$dados_bancarios = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $dados_bancarios[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'dados_bancarios' => $dados_bancarios
]);

$conn->close();
?>
