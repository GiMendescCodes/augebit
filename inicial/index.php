<?php
// Configurações de conexão com o banco de dados
$host = 'localhost';
$username = 'root'; // Altere conforme sua configuração
$password = '';     // Altere conforme sua configuração

// Conexão com o banco 'semestral'
try {
    $pdo = new PDO("mysql:host=$host;dbname=semestral;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão com banco semestral: " . $e->getMessage());
}

// Buscar dados da tabela solicitacoes
$sql_solicitacoes = "SELECT id, data_escolhida, opcao FROM solicitacoes ORDER BY data_escolhida DESC";
$stmt_solicitacoes = $pdo->prepare($sql_solicitacoes);
$stmt_solicitacoes->execute();
$solicitacoes = $stmt_solicitacoes->fetchAll(PDO::FETCH_ASSOC);

// Contar total de solicitações
$sql_count_solicitacoes = "SELECT COUNT(*) as total FROM solicitacoes";
$stmt_count_solicitacoes = $pdo->prepare($sql_count_solicitacoes);
$stmt_count_solicitacoes->execute();
$total_solicitacoes = $stmt_count_solicitacoes->fetch(PDO::FETCH_ASSOC)['total'];

// Buscar dados da tabela justificativas
$sql_justificativas = "SELECT id, data_escolhida, opcao FROM justificativas ORDER BY data_escolhida DESC";
$stmt_justificativas = $pdo->prepare($sql_justificativas);
$stmt_justificativas->execute();
$justificativas = $stmt_justificativas->fetchAll(PDO::FETCH_ASSOC);

// Contar total de justificativas
$sql_count_justificativas = "SELECT COUNT(*) as total FROM justificativas";
$stmt_count_justificativas = $pdo->prepare($sql_count_justificativas);
$stmt_count_justificativas->execute();
$total_justificativas = $stmt_count_justificativas->fetch(PDO::FETCH_ASSOC)['total'];

// Função para formatar data
function formatarData($data) {
    $timestamp = strtotime($data);
    return date('d/m', $timestamp);
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Augebit</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
    </div>
  </div>

          <div class="sidebar">
                <div class="icon-circle">
          <img src="img/home.png" alt="Home icon">
        </div>
        <a href="img/person.png" class="menu-item">
          <span class="icon people"></span>
        </a>
        <a href="img/justificativas.png" class="menu-item">
          <span class="icon docs"></span>
        </a>
        <a href="img/chapeuzinho.png" class="menu-item">
          <span class="icon chapeu"></span>
        </a>
        <a href="img/grafiquinho.png" class="menu-item">
          <span class="icon grafico"></span>
        </a>
        <a href="img/calendarinho.png" class="menu-item">
          <span class="icon calendario"></span>
        </a>
        <a href="img/mapinha.png" class="menu-item">
          <span class="icon mapa"></span>
        </a>
      </div>

        <div class="perfil">
        <a class="person" href="img/person.png"></a>
      </div>

    <!-- Main Content -->
    <div class="main">
        <!-- Header -->
        <div class="header">
            <div class="logo-container">
                <img src="img/augebit.png" alt="">
                <div class="title-text">
                    <h1>Olá, Jorge</h1>
                    <p>Gerencie o perfil e acesso dos funcionários ao site aqui</p>
                </div>
            </div>
        </div>

        <!-- Cards -->
        <div class="cards-container">
<div class="part1">
                  <div class="caixa1">
                    <img class="img1" src="img/solicitaçoes.png" alt="">
                    <div class="textinhos">
                    <a class="info-texto" href="">Solicitações</a>
                    <br>
                    <a class="info-subtexto" href="">Solicitar férias, folgas, etc</a>
                    </div>
                    </div>
                    <div class="caixa1">
                      <img class="img2" src="img/cursos.png" alt="">
                      <div class="textinhos">
                      <a class="info-texto2" href="">Cursos</a>
                      <br>
                      <a class="info-subtexto2" href="">Desempenho nos cursos</a>
                    </div>
               </div>
               <div class="caixa1">
                <img class="img3" src="img/justificativa.png" alt="">
                <div class="textinhos">
                  <a class="info-texto3" href="">Justificativa</a>
                  <br>
                <a class="info-subtexto3" href="">Justifique atrasos, faltas, etc</a>
              </div>
            </div>
  </div>
            <div class="empty-card">
                <button class="add-button">+</button>
            </div>
        </div>

        <!-- Sections -->
        <div class="sections-container">
            <div>
                <div class="section">
                    <h2 class="section-title">Solicitações</h2>
                    <?php if (!empty($solicitacoes)): ?>
                        <?php foreach ($solicitacoes as $solicitacao): ?>
                            <div class="request-item">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#6c63ff" width="18" height="18">
                                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-6.1 0-10 4-10 10h20c0-6-3.9-10-10-10z"></path>
                                        </svg>
                                    </div>
                                    <div class="user-name">ID: <?php echo htmlspecialchars($solicitacao['id']); ?></div>
                                </div>
                                <div class="request-badge"><?php echo htmlspecialchars($solicitacao['opcao']); ?></div>
                                <div class="request-date"><?php echo formatarData($solicitacao['data_escolhida']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="request-item">
                            <div class="user-info">
                                <div class="user-name">Nenhuma solicitação encontrada</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="count-badge"><?php echo sprintf('%02d', $total_solicitacoes); ?></div>
                </div>
                
                <div class="section">
                    <h2 class="section-title">Justificativas</h2>
                    <?php if (!empty($justificativas)): ?>
                        <?php foreach ($justificativas as $justificativa): ?>
                            <div class="request-item">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#6c63ff" width="18" height="18">
                                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-6.1 0-10 4-10 10h20c0-6-3.9-10-10-10z"></path>
                                        </svg>
                                    </div>
                                    <div class="user-name">ID: <?php echo htmlspecialchars($justificativa['id']); ?></div>
                                </div>
                                <div class="request-badge"><?php echo htmlspecialchars($justificativa['opcao']); ?></div>
                                <div class="request-date"><?php echo formatarData($justificativa['data_escolhida']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="request-item">
                            <div class="user-info">
                                <div class="user-name">Nenhuma justificativa encontrada</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="count-badge"><?php echo sprintf('%02d', $total_justificativas); ?></div>
                </div>
            </div>
            
            <div>
                <div class="section stats-card">
                    <div class="stats-info">
                        <div class="stats-number">10</div>
                        <div class="stats-label">Funcionários Totais</div>
                    </div>
                    <div class="stats-icon">
                        <img src="img/icon.png" viewBox="0 0 24 24" fill="#6c63ff" width="75" height="75">
                    </div>
                </div>
                
                <div class="section stats-card">
                    <div class="stats-info">
                        <div class="stats-number">8</div>
                        <div class="stats-label">Pontos Registrados</div>
                    </div>
                    <div class="stats-icon">
                        <img src="img/cartao.png" viewBox="0 0 24 24" fill="#6c63ff" width="100" height="100">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
  </body>
  </html>