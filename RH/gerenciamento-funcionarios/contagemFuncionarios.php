<?php
include '../../conexao.php';

$sql_total = "SELECT COUNT(*) as total FROM funcionarios";
$sql_homens = "SELECT COUNT(*) as homens FROM funcionarios WHERE genero = 'masculino'";
$sql_mulheres = "SELECT COUNT(*) as mulheres FROM funcionarios WHERE genero = 'feminino'";

$result_total = mysqli_query($conn, $sql_total);
$result_homens = mysqli_query($conn, $sql_homens);
$result_mulheres = mysqli_query($conn, $sql_mulheres);

$total = mysqli_fetch_assoc($result_total)['total'];
$homens = mysqli_fetch_assoc($result_homens)['homens'];
$mulheres = mysqli_fetch_assoc($result_mulheres)['mulheres'];

echo json_encode([
    'total' => $total,
    'homens' => $homens,
    'mulheres' => $mulheres
]);
?>
