<?php
session_start();
include '../conexao.php';

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $cpf = trim($_POST['cpf']);

    if (empty($nome) || empty($cpf)) {
        $error_message = "Preencha todos os campos!";
    } else {
        $sql = "SELECT * FROM funcionarios WHERE nome = ? AND cpf = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nome, $cpf);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();

        if ($usuario) {
            $id = $usuario['id'];
            // Você pode salvar dados na sessão para controle de login, por exemplo:
            $_SESSION['funcionarios_id'] = $id;
            $_SESSION['funcionarios_nome'] = $usuario['nome'];

            header("Location: /augebit/FUNCIONARIO/inicial-funcionario/index.php?id=$id");
            exit;
        } else {
            $error_message = "Nome ou CPF inválidos.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Augebit</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }

        .error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef5350;
        }

        .success {
            background-color: #e8f5e8;
            color: #2e7d32;
            border: 1px solid #4caf50;
        }

        .form-loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <main class="main-container">
        <div class="login-section">
            <div class="login-header">
                <h2>LOGIN</h2>
                <p>Entre com sua conta corporativa para <br> acessar o sistema de funcionários Augebit</p>
            </div>

            <div class="login-form-container">
                <?php if ($error_message): ?>
                    <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>

                <?php if ($success_message): ?>
                    <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
                <?php endif; ?>

                <form class="login-form" method="POST" id="loginForm" <?php if ($success_message)
<<<<<<< HEAD
                    echo 'style="display:none;"';?>
                    <div class="input-group">
                        <div class="input-wrapper">
                            <span class="input-icon">🧑</span>
=======
                    echo 'style="display:none;"';?>>
                    <div class="input-group">
                        <div class="input-wrapper">
                            <span class="input-icon"><img src="img/imgNome.png" alt=""></span>
>>>>>>> b26db88 (up)
                            <input type="text" id="nome" name="nome" placeholder="Nome completo" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-wrapper">
<<<<<<< HEAD
                            <span class="input-icon">🆔</span>
=======
                            <span class="input-icon"><img src="img/imgCpf.png" alt=""></span>
>>>>>>> b26db88 (up)
                            <input type="text" id="cpf" name="cpf" placeholder="CPF (somente números)" required
                                pattern="\d+">
                        </div>
                    </div>

                    <button type="submit" class="login-button" id="loginButton">Entrar</button>
                </form>
            </div>
        </div>

        <div class="illustration-section">
            <img class="gif" src="img/gif.gif" alt="">
        </div>
    </main>

    <script>
        // Feedback visual no formulário
        document.getElementById('loginForm').addEventListener('submit', function () {
            const button = document.getElementById('loginButton');
            const form = document.getElementById('loginForm');

            button.textContent = 'Entrando...';
            button.disabled = true;
            form.classList.add('form-loading');
        });

        // Validar CPF: apenas números
        document.getElementById('cpf').addEventListener('input', function (e) {
            const valor = e.target.value;
            if (!/^\d*$/.test(valor)) {
                e.target.setCustomValidity('Digite apenas números no CPF');
            } else {
                e.target.setCustomValidity('');
            }
        });

        // Esconde mensagens depois de 5s
        setTimeout(function () {
            const messages = document.querySelectorAll('.message');
            messages.forEach(function (message) {
                message.style.opacity = '0';
                setTimeout(function () {
                    message.style.display = 'none';
                }, 500);
            });
        }, 5000);
    </script>
</body>

</html>