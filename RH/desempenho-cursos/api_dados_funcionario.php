<?php
header('Content-Type: application/json');
include '../../conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo json_encode(['erro' => 'ID não informado']);
    exit;
}

$sql = "SELECT * FROM avaliacoes_funcionarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo json_encode(['erro' => 'Avaliação não encontrada']);
    exit;
}
$row = $result->fetch_assoc();

// Decodifica os campos JSON armazenados
$row['criterios'] = json_decode($row['criterios'], true);
$row['resultados'] = json_decode($row['resultados'], true);
$row['cursos_atuais'] = json_decode($row['cursos_atuais'], true);
$row['cursos_pendentes'] = json_decode($row['cursos_pendentes'], true);

echo json_encode($row, JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
