





<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Augebit - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        
        <main class="main-content">
            <div class="welcome-section">
                <h1 class="title">Bem-vindo ao<br>Sistema Augebit</h1>
                <p class="subtitle">Escolha seu perfil para acessar as funcionalidades adequadas.</p>
                
                <div class="profile-selection">
                    <p class="question">Você faz parte do RH ou é um funcionário?</p>
                    
                    <div class="buttons-container">
                        <button class="profile-btn funcionario-btn" id="funcionarioBtn">
                            <div class="btn-icon">
                                <!-- Espaço para imagem do funcionário -->
                                 
                                <img src="img/funcionario.png" alt="Funcionário" class="icon-image">
                            </div>
                             <a href="../inicial/index.php" class="btn-link" >
                            <span class="btn-text">FUNCIONÁRIO</span>
</a>
                        </button>
                        
                        <button class="profile-btn rh-btn" id="rhBtn">
                            <div class="btn-icon">
                                <!-- Espaço para imagem do RH -->
                                  <a href="../inicial/index.php" class="btn-link" >
                                <img src="img/rh.png" alt="Recursos Humanos" class="icon-image">
                            </div>
                           
                            <p class="btn-text">RECURSOS HUMANOS</p>
</a>
                        </button>
                        
                    </div>
                </div>
            </div>
            
            <div class="illustration-section">
                <div class="illustration-container">
                    <!-- Espaço para sua ilustração personalizada -->
                    <img class="gif" src="img/gif.gif" alt="">
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="script.js"></script>
</body>
</html>