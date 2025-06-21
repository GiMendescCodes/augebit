<?php
// Incluir verificação de autenticação
include '../auth_check.php';

// Verificar se usuário está logado
verificarLogin();

// Obter dados do usuário logado
$usuario_logado = obterUsuarioLogado();

// Configurações de conexão com o banco de dados
$host = 'localhost';
$username = 'root';
$password = '';
$database = '1';

// Criar conexão
$conn = new mysqli($host, $username, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Definir charset para UTF-8
$conn->set_charset("utf8");

// Buscar dados do funcionário logado
$sql = "SELECT * FROM funcionarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_logado['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $funcionario = $result->fetch_assoc();
} else {
    // Se não encontrar o funcionário, usar dados da sessão
    $funcionario = array(
        'id' => $usuario_logado['id'],
        'nome' => $usuario_logado['nome'],
        'cpf' => '',
        'rg' => '',
        'nascimento' => '',
        'genero' => '',
        'endereco' => '',
        'telefone' => '',
        'email' => $usuario_logado['email'],
        'estado' => '',
        'pis_pasep' => '',
        'carteira' => '',
        'foto' => 'img/sakke.png'
    );
}

$stmt->close();
$conn->close();

// Formatar CPF se necessário
function formatarCpf($cpf) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $cpf);
}

// Formatar RG se necessário
function formatarRg($rg) {
    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{1})/", "$1.$2.$3-$4", $rg);
}

// Formatar data se necessário
function formatarData($data) {
    if ($data && $data != '0000-00-00') {
        return date('d/m/Y', strtotime($data));
    }
    return $data;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Perfil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <div class="logo-icon">
                    <img src="img/augebit.png" class="icon">
                </div>
            </div>
            <div class="header-content">
                <h1>Visualização de perfil</h1>
                <p>Acompanhe seu perfil augebit</p>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Sidebar Navigation -->
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

            <!-- Content Area -->
            <div class="content-area">
                <!-- Main Layout -->
                <div class="main-layout">
                    <!-- Left Section - Profile and Work Info -->
                    <div class="left-section">
                        <!-- Profile Card -->
                        <div class="profile-card">
                            <div class="profile-image-container">
                                <img id="profileImage" src="<?php echo htmlspecialchars($funcionario['foto'] ?: 'img/sakke.png'); ?>" alt="Foto do Perfil" class="profile-image">
                            </div>
                            <div class="profile-info">
                                <h2 id="profileName" class="profile-name"><?php echo htmlspecialchars($funcionario['nome']); ?></h2>
                                <p id="profileEmail" class="profile-email"><?php echo htmlspecialchars($funcionario['email']); ?></p>
                                
                                <div class="profile-details">
                                    <div class="detail-row">
                                        <i class="fas fa-id-card"></i>
                                        <span>CPF: <span id="profileCpf"><?php echo htmlspecialchars(formatarCpf($funcionario['cpf'])); ?></span></span>
                                        <span>RG: <span id="profileRg"><?php echo htmlspecialchars(formatarRg($funcionario['rg'])); ?></span></span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-birthday-cake"></i>
                                        <span>Nascimento: <span id="profileBirth"><?php echo htmlspecialchars(formatarData($funcionario['nascimento'])); ?></span></span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-venus-mars"></i>
                                        <span>Gênero: <span id="profileGender"><?php echo htmlspecialchars($funcionario['genero']); ?></span></span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-heart"></i>
                                        <span>Estado Civil: <span id="profileMaritalStatus"><?php echo htmlspecialchars($funcionario['estado']); ?></span></span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>End: <span id="profileAddress"><?php echo htmlspecialchars($funcionario['endereco']); ?></span></span>
                                        <span>Tell: <span id="profilePhone"><?php echo htmlspecialchars($funcionario['telefone']); ?></span></span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-file-alt"></i>
                                        <span>PIS: <span id="profilePis"><?php echo htmlspecialchars($funcionario['pis_pasep']); ?></span></span>
                                        <span>Carteira: <span id="profileCarteira"><?php echo htmlspecialchars($funcionario['carteira']); ?></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Info Card -->
                        <div class="info-card work-info">
                            <div class="card-header">
                                <h3>Diretor geral/RH</h3>
                            </div>
                            <div class="card-content">
                                <p><span id="workLocation">Sala 405 - Edifício Administrativo</span></p>
                                <p><span id="workSchedule">Segunda a sexta-feira, das 8h às 17h (1 hora de almoço)</span></p>
                                <p><strong>CLT</strong> (Consolidação das Leis do Trabalho)</p>
                                <p>Data de Admissão: <span id="admissionDate">14 de março de 2022</span></p>
                                <p>Salário: <span id="salary">R$ 18.500,00</span></p>
                                <p>Sindicato: <span id="syndicate">SINDARPH (Sindicato dos Administradores e Executivos de Recursos Humanos)</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section - Performance and Bank Info -->
                    <div class="right-section">
                        <!-- Performance Chart Card -->
                        <div class="info-card performance-card">
                            <div class="card-header">
                                <h3>Desempenho Profissional em %</h3>
                            </div>
                            <div class="card-content">
                                <canvas id="performanceChart" width="300" height="200"></canvas>
                                <p class="performance-note">
                                    Você teve um desempenho mediano ao longo do ano, mas demonstrou um grande avanço no último mês. Parabéns pela evolução e continue nesse ritmo!
                                </p>
                            </div>
                        </div>

                        <!-- Bank Info Card -->
                        <div class="info-card bank-info">
                            <div class="card-header">
                                <h3>Banco do Brasil</h3>
                                <div class="bank-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                            </div>
                            <div class="card-content">
                                <p>Tipo de Conta: <span id="accountType">Corrente</span></p>
                                <p>Número da Conta: <span id="accountNumber">12345-6</span></p>
                                <p>Agência: <span id="agency">001 - Centro Empresarial</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>