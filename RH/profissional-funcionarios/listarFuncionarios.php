<?php
include '../../conexao.php';

header('Content-Type: application/json');

// Consulta na tabela profissional com os campos informados
$sql = "SELECT nome, cargo, setor, horario_entrada, horario_saida, tipo_contrato, data_admissao, salario, sindicato FROM profissional";
$result = $conn->query($sql);

$profissional = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $profissional[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'profissional' => $profissional
]);

$conn->close();
?>
