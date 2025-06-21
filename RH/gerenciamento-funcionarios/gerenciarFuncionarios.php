<?php
include '../../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber e sanitizar os dados (pode adicionar validação mais tarde)
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $endereco = $_POST['endereco'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    $estado = $_POST['estado'];
    $pis_pasep = $_POST['pis_pasep'];
    $carteira = $_POST['carteira'];

    // Upload da foto
    $foto_nome = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nome = uniqid() . "." . $extensao;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto_nome);
    }

    // Inserção no banco
    $sql = "INSERT INTO funcionarios (nome, cpf, rg, endereco, genero, email, telefone, nascimento, estado, pis_pasep, carteira, foto)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", $nome, $cpf, $rg, $endereco, $genero, $email, $telefone, $nascimento, $estado, $pis_pasep, $carteira, $foto_nome);

    if ($stmt->execute()) {
        // Retorna os dados cadastrados em JSON
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'funcionario' => [
                'nome' => $nome,
                'cpf' => $cpf,
                'rg' => $rg,
                'endereco' => $endereco,
                'genero' => $genero,
                'email' => $email,
                'telefone' => $telefone,
                'nascimento' => $nascimento,
                'estado' => $estado,
                'pis_pasep' => $pis_pasep,
                'carteira' => $carteira,
                'foto' => $foto_nome,
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
