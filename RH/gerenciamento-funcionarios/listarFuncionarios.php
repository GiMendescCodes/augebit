<?php
include '../../conexao.php';

header('Content-Type: application/json');

$sql = "SELECT nome, cpf, rg, endereco, genero, email, telefone, nascimento, estado, pis_pasep, carteira, foto FROM funcionarios";
$result = $conn->query($sql);

$funcionarios = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $funcionarios[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'funcionarios' => $funcionarios
]);

$conn->close();
?>
