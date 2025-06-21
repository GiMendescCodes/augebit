<?php
include '../../conexao.php'; // mesma conexão usada no index

// Pega os dados do formulário
$nome_funcionario = $_POST['nome_funcionario'];
$titulo_secao1 = $_POST['titulo_secao1'];
$curso1 = $_POST['curso1'];
$porcentagem1 = $_POST['porcentagem1'];
$classificacao = $_POST['classificacao'];
$resumo = $_POST['resumo'];
$titulo_secao2 = $_POST['titulo_secao2'];
$titulo_secao3 = $_POST['titulo_secao3'];

// Arrays
$criterios = $_POST['criterio1'];
$resultados = $_POST['resultado1'];
$progresso_curso_atual = $_POST['progresso_curso_atual'];
$curso_atual_nome = $_POST['curso_atual_nome'];
$curso_atual_desc1 = $_POST['curso_atual_desc1'];
$curso_atual_desc2 = $_POST['curso_atual_desc2'];
$curso_pendente_nome = $_POST['curso_pendente_nome'];
$curso_pendente_desc = $_POST['curso_pendente_desc'];

// Converte arrays para JSON
$criterios_json = json_encode($criterios, JSON_UNESCAPED_UNICODE);
$resultados_json = json_encode($resultados, JSON_UNESCAPED_UNICODE);
$cursos_atuais = json_encode([
    'progresso' => $progresso_curso_atual,
    'nome' => $curso_atual_nome,
    'desc1' => $curso_atual_desc1,
    'desc2' => $curso_atual_desc2
], JSON_UNESCAPED_UNICODE);
$cursos_pendentes = json_encode([
    'nome' => $curso_pendente_nome,
    'desc' => $curso_pendente_desc
], JSON_UNESCAPED_UNICODE);

// Insere no banco
$sql = "INSERT INTO avaliacoes_funcionarios (
    nome_funcionario, titulo_secao1, curso1, porcentagem1,
    criterios, resultados, classificacao, resumo,
    titulo_secao2, cursos_atuais,
    titulo_secao3, cursos_pendentes
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssssss",
    $nome_funcionario,
    $titulo_secao1,
    $curso1,
    $porcentagem1,
    $criterios_json,
    $resultados_json,
    $classificacao,
    $resumo,
    $titulo_secao2,
    $cursos_atuais,
    $titulo_secao3,
    $cursos_pendentes
);
if ($stmt->execute()) {
    $ultimo_id = $stmt->insert_id; // pega o ID recém-inserido
    echo "<script>
        alert('Dados salvos com sucesso!');
        window.location.href='pagina_exibicao.php?id={$ultimo_id}';
    </script>";
} else {
    echo "Erro ao salvar: " . $stmt->error;
}

$stmt->close();
$conn->close();
