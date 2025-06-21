<?php
include '../../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $setor = $_POST['setor'];
    $horario_entrada = $_POST['horario_entrada'];
    $horario_saida = $_POST['horario_saida'];
    $tipo_contrato = $_POST['tipo_contrato'];
    $data_admissao = $_POST['data_admissao'];
    $salario = $_POST['salario'];
    $sindicato = $_POST['sindicato'];

    // Inserção no banco (tabela 'profissional', sem foto)
    $sql = "INSERT INTO profissional (nome, cargo, setor, horario_entrada, horario_saida, tipo_contrato, data_admissao, salario, sindicato)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $nome, $cargo, $setor, $horario_entrada, $horario_saida, $tipo_contrato, $data_admissao, $salario, $sindicato);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'profissional' => [
                'nome' => $nome,
                'cargo' => $cargo,
                'setor' => $setor,
                'horario_entrada' => $horario_entrada,
                'horario_saida' => $horario_saida,
                'tipo_contrato' => $tipo_contrato,
                'data_admissao' => $data_admissao,
                'salario' => $salario,
                'sindicato' => $sindicato,
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
