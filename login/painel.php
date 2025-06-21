<?php
session_start();

if (!isset($_SESSION['funcionario_id'])) {
    header('Location: login.php');
    exit;
}

echo "<h1>Bem-vindo(a), " . htmlspecialchars($_SESSION['funcionario_nome']) . "!</h1>";
echo "<p>Você está logado no sistema Augebit.</p>";
echo "<a href='logout.php'>Sair</a>";
