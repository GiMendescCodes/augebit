<?php
// auth_check.php - Arquivo para verificar se o usuário está logado
session_start();

function verificarLogin() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: login/index.php");
        exit();
    }
}

function obterUsuarioLogado() {
    verificarLogin();
    
    return array(
        'id' => $_SESSION['user_id'],
        'nome' => $_SESSION['user_name'],
        'email' => $_SESSION['user_email'],
        'cargo' => $_SESSION['user_cargo']
    );
}

function logout() {
    session_start();
    session_destroy();
    
    // Remover cookies se existirem
    if (isset($_COOKIE['user_email'])) {
        setcookie('user_email', '', time() - 3600, '/');
    }
    
    header("Location: login/index.php");
    exit();
}
?>