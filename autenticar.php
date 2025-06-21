<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica qual formulário foi enviado
    if (isset($_POST['tipo_form']) && $_POST['tipo_form'] === 'funcionario') {
        // Dados do funcionário
        $nome = $_POST["nome"];
        $cpf = $_POST["cpf"];
        $rg = $_POST["rg"];
        $endereco = $_POST["endereco"];
        $genero = $_POST["genero"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];
        $nascimento = $_POST["nascimento"];
        $estado_civil = $_POST["estado"];
        $pis_pasep = $_POST["PIS/PASEP"];
        $carteira_trabalho = $_POST["carteira"];

        // Upload da imagem (opcional)
        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $fotoNome = uniqid() . "_" . $_FILES['foto']['name'];
            move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $fotoNome);
            $foto = 'uploads/' . $fotoNome;
        }

        $sql = "INSERT INTO funcionarios (nome, cpf, rg, endereco, genero, email, telefone, nascimento, estado_civil, pis_pasep, carteira_trabalho, foto)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $cpf, $rg, $endereco, $genero, $email, $telefone, $nascimento, $estado_civil, $pis_pasep, $carteira_trabalho, $foto]);

        echo "Funcionário adicionado com sucesso!";

    } elseif (isset($_POST['tipo_form']) && $_POST['tipo_form'] === 'profissional') {
        // Dados do profissional
        $nome = $_POST["nome"];
        $cargo = $_POST["cargo"];
        $setor = $_POST["setor"];
        $horario_entrada = $_POST["horario_entrada"];
        $horario_saida = $_POST["horario_saida"];
        $tipo_contrato = $_POST["tipo_contrato"];
        $data_admissao = $_POST["data_admissao"];
        $salario = $_POST["salario"];
        $sindicato = $_POST["sindicato"];

        $sql = "INSERT INTO profissional (nome, cargo, setor, horario_entrada, horario_saida, tipo_contrato, data_admissao, salario, sindicato)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $cargo, $setor, $horario_entrada, $horario_saida, $tipo_contrato, $data_admissao, $salario, $sindicato]);

        echo "Profissional adicionado com sucesso!";

    } elseif (isset($_POST['tipo_form']) && $_POST['tipo_form'] === 'dados_bancarios') {
        // Dados bancários
        $nome = $_POST["nome"];
        $banco = $_POST["banco"];
        $agencia = $_POST["agencia"];
        $tipo_corrente_poupanca = $_POST["tipo_corrente_poupanca"];
        $tipo_conta = $_POST["tipo_conta"];

        $sql = "INSERT INTO dados_bancarios (nome, banco, agencia, tipo_corrente_poupanca, tipo_conta)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $banco, $agencia, $tipo_corrente_poupanca, $tipo_conta]);

        echo "Dados bancários adicionados com sucesso!";

    } else {
        echo "Tipo de formulário não identificado.";
    }
}
?>
