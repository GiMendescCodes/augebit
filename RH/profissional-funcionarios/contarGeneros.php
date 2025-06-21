<?php
include '../../conexao.php'; // ajuste o caminho conforme sua estrutura

$sql = "SELECT genero FROM funcionarios"; // troque 'funcionarios' se o nome for diferente
$result = $conn->query($sql);

$homens = 0;
$mulheres = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $genero = strtolower(trim($row['genero']));
        if ($genero === "feminino") {
            $mulheres++;
        } elseif ($genero === "masculino") {
            $homens++;
        }
    }
}

$total = $homens + $mulheres;

echo json_encode([
    'homens' => $homens,
    'mulheres' => $mulheres,
    'total' => $total
]);
?>
