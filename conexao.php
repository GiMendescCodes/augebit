<?php
$host = 'localhost';
$usuario = 'root'; // ou o usuário do seu MySQL
$senha = ''; // sua senha
$banco = 'semestral'; // nome do seu banco de dados

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>