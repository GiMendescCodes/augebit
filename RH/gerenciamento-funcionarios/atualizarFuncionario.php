<?php
include '../../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf']; // identificador para atualizar
    $rg = $_POST['rg'];
    $endereco = $_POST['endereco'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    $estado = $_POST['estado'];
    $pis_pasep = $_POST['pis_pasep'];
    $carteira = $_POST['carteira'];

    // Primeiro: buscar foto atual no banco
    $foto_atual = null;
    $queryFoto = $conn->prepare("SELECT foto FROM funcionarios WHERE cpf = ?");
    $queryFoto->bind_param("s", $cpf);
    $queryFoto->execute();
    $resultado = $queryFoto->get_result();
    if ($resultado->num_rows > 0) {
        $linha = $resultado->fetch_assoc();
        $foto_atual = $linha['foto'];
    }
    $queryFoto->close();

    // Upload da foto (opcional)
    $foto_nome = $foto_atual; // começa com a foto atual, só muda se tiver upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nome = uniqid() . "." . $extensao;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto_nome);

        // Opcional: deletar a foto antiga do servidor para não acumular arquivos
        if ($foto_atual && file_exists("uploads/" . $foto_atual)) {
            unlink("uploads/" . $foto_atual);
        }
    }

    // Atualizar dados incluindo foto (que pode ser a antiga se não mudou)
    $sql = "UPDATE funcionarios SET nome=?, rg=?, endereco=?, genero=?, email=?, telefone=?, nascimento=?, estado=?, pis_pasep=?, carteira=?, foto=? WHERE cpf=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", $nome, $rg, $endereco, $genero, $email, $telefone, $nascimento, $estado, $pis_pasep, $carteira, $foto_nome, $cpf);

    if ($stmt->execute()) {
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
