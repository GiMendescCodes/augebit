<?php
// get_employee_performance.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Configuração do banco de dados
$servername = "localhost"; // Ajuste conforme sua configuração
$username = "root";        // Ajuste conforme sua configuração
$password = "";            // Ajuste conforme sua configuração
$dbname = "solicitacoes";  // Nome do seu banco

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro de conexão com o banco de dados: ' . $e->getMessage()]);
    exit;
}

// Verificar se o ID do funcionário foi fornecido
if (!isset($_GET['funcionario_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do funcionário é obrigatório']);
    exit;
}

$funcionario_id = (int)$_GET['funcionario_id'];

try {
    // Buscar dados do funcionário
    $stmt = $pdo->prepare("SELECT nome, cargo FROM funcionarios WHERE id = ?");
    $stmt->execute([$funcionario_id]);
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$funcionario) {
        http_response_code(404);
        echo json_encode(['error' => 'Funcionário não encontrado']);
        exit;
    }
    
    // Buscar a avaliação mais recente do funcionário
    $stmt = $pdo->prepare("
        SELECT * FROM desempenho 
        WHERE funcionario_id = ? 
        ORDER BY data_avaliacao DESC 
        LIMIT 1
    ");
    $stmt->execute([$funcionario_id]);
    $desempenho_atual = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$desempenho_atual) {
        http_response_code(404);
        echo json_encode(['error' => 'Nenhuma avaliação encontrada para este funcionário']);
        exit;
    }
    
    // Buscar histórico de avaliações (últimos 6 meses)
    $stmt = $pdo->prepare("
        SELECT 
            DATE_FORMAT(data_avaliacao, '%Y-%m') as mes,
            AVG(
                (pontualidade_nota * pontualidade_peso + 
                qualidade_nota * qualidade_peso + 
                produtividade_nota * produtividade_peso) / 
                (pontualidade_peso + qualidade_peso + produtividade_peso)
            ) AS media_ponderada
        FROM desempenho
        WHERE funcionario_id = ? 
          AND data_avaliacao >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY mes
        ORDER BY mes ASC
    ");
    $stmt->execute([$funcionario_id]);
    $historico = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Montar resposta JSON
    $response = [
        'funcionario' => $funcionario,
        'desempenho_atual' => $desempenho_atual,
        'historico' => $historico
    ];
    
    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro na consulta: ' . $e->getMessage()]);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Desempenho - ${employeeName}</title>
    <style>
        @font-face {
            font-family: 'fonte1';
            src: url('../fontes/eurostile.TTF');
        }

        @font-face {
            font-family: 'fonte2';
            src: url('../fontes/Montserrat-VariableFont_wght.ttf');
        }

        @font-face {
            font-family: 'fonte3';
            src: url('../fontes/MontserratAlternates-Regular.ttf');
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'fonte2', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            gap: 30px;
        }

        /* Sidebar */
        .sidebar {
            width: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 30px;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
            position: fixed;
            height: 500px;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 100;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            font-weight: bold;
        }

        .nav-item {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            font-size: 20px;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 120px;
            flex: 1;
        }

        .header {
            background: white;
            border-radius: 25px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-content h1 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .header-content p {
            color: #7f8c8d;
            font-size: 16px;
        }

        .greeting {
            font-size: 24px;
            color: #667eea;
            font-weight: 600;
        }

        /* Employee Info Card */
        .employee-card {
            background: white;
            border-radius: 25px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .employee-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
        }

        .employee-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: bold;
        }

        .employee-info h2 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .employee-info p {
            color: #7f8c8d;
            font-size: 16px;
        }

        /* Performance Section */
        .performance-section {
            background: white;
            border-radius: 25px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .performance-table {
            background: #f8f9ff;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .performance-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .performance-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
        }

        .performance-table td {
            padding: 20px;
            border-bottom: 1px solid #e8ecf4;
            font-size: 14px;
        }

        .performance-table tr:last-child td {
            border-bottom: none;
        }

        .performance-table tr:nth-child(even) {
            background: rgba(102, 126, 234, 0.02);
        }

        .score-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .score-progress {
            width: 100px;
            height: 8px;
            background: #e8ecf4;
            border-radius: 4px;
            overflow: hidden;
        }

        .score-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .score-fill.green { background: linear-gradient(90deg, #4CAF50, #45a049); }
        .score-fill.blue { background: linear-gradient(90deg, #667eea, #764ba2); }
        .score-fill.yellow { background: linear-gradient(90deg, #FFC107, #FF9800); }
        .score-fill.red { background: linear-gradient(90deg, #f44336, #d32f2f); }

        .score-value {
            font-weight: 600;
            color: #2c3e50;
            min-width: 25px;
        }

        /* Chart Section */
        .chart-section {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }

        .chart-container {
            background: white;
            border-radius: 25px;
            padding: 30px;
            flex: 2;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
        }

        .chart {
            display: flex;
            align-items: end;
            gap: 15px;
            height: 200px;
            padding: 20px;
            background: #f8f9ff;
            border-radius: 15px;
            justify-content: center;
        }

        .chart-bar {
            width: 35px;
            border-radius: 8px 8px 0 0;
            background: linear-gradient(180deg, #667eea, #764ba2);
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .chart-bar:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .chart-bar.current {
            background: linear-gradient(180deg, #4CAF50, #45a049);
        }

        .chart-labels {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
            font-size: 12px;
            color: #7f8c8d;
        }

        .chart-label {
            width: 35px;
            text-align: center;
        }

        /* Summary Card */
        .summary-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            flex: 1;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .summary-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            margin-bottom: 20px;
        }

        .summary-title {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .summary-text {
            color: #7f8c8d;
            line-height: 1.6;
            font-size: 14px;
        }

        .performance-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .performance-badge.excellent {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .performance-badge.good {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .performance-badge.average {
            background: linear-gradient(135deg, #FFC107, #FF9800);
            color: white;
        }

        /* Motivational Section */
        .motivational-section {
            background: white;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .motivational-content {
            flex: 1;
        }

        .motivational-title {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .motivational-text {
            color: #7f8c8d;
            line-height: 1.6;
            font-size: 16px;
        }

        .motivational-image {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }

        .back-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .employee-card, .performance-section, .chart-container, .summary-card, .motivational-section {
            animation: fadeIn 0.8s ease-out;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">A</div>
        <a href="/augebit/inicial/index.php" class="nav-item">🏠</a>
        <a href="/augebit/RH/gerenciamento-funcionarios/index.php" class="nav-item">👥</a>
        <a href="/augebit/justificativas/index.php" class="nav-item">📄</a>
        <a href="/augebit/RH/desempenho-cursos/index.php" class="nav-item">🎓</a>
        <a href="#" class="nav-item active">📊</a>
        <a href="/augebit/solicitacoes/index.php" class="nav-item">📅</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="greeting" id="greeting">Olá, <span id="employeeName">Carregando...</span></div>
                <p>Acompanhe seu desempenho profissional</p>
            </div>
            <a href="javascript:history.back()" class="back-btn">← Voltar</a>
        </div>

        <!-- Employee Info -->
        <div class="employee-card">
            <div class="employee-header">
                <div class="employee-avatar" id="employeeAvatar">
                    <!-- Inicial do nome -->
                </div>
                <div class="employee-info">
                    <h2 id="employeeFullName">Carregando...</h2>
                    <p id="employeePosition">Funcionário</p>
                    <p id="evaluationPeriod">Período da avaliação</p>
                </div>
            </div>
        </div>

        <!-- Performance Details -->
        <div class="performance-section">
            <h3 class="section-title">Seu desempenho em <span id="performanceMonth">junho</span>:</h3>
            <div class="performance-table">
                <table>
                    <thead>
                        <tr>
                            <th>Critério</th>
                            <th>Peso (1-5)</th>
                            <th>Nota (0-10)</th>
                            <th>Peso x Nota</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody id="performanceTableBody">
                        <!-- Será preenchido via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart and Summary -->
        <div class="chart-section">
            <div class="chart-container">
                <div class="chart-header">
                    <div class="chart-title">Seu desempenho nos últimos meses:</div>
                </div>
                <div class="chart" id="performanceChart">
                    <!-- Será preenchido via JavaScript -->
                </div>
                <div class="chart-labels" id="chartLabels">
                    <!-- Será preenchido via JavaScript -->
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon">📊</div>
                <h4 class="summary-title">Resumo de Avaliação</h4>
                <div class="performance-badge" id="performanceBadge">Carregando...</div>
                <p class="summary-text" id="summaryText">Carregando resumo...</p>
            </div>
        </div>

        <!-- Motivational Section -->
        <div class="motivational-section">
            <div class="motivational-content">
                <h3 class="motivational-title">Transforme cada desafio em uma oportunidade de crescimento</h3>
                <p class="motivational-text">Isso é o que realmente importa. Continue se dedicando e mantenha o foco nos seus objetivos profissionais. Cada avaliação é uma chance de evoluir!</p>
            </div>
            <div class="motivational-image">
                💡
            </div>
        </div>
    </div>

    <script>
        // Função para obter parâmetros da URL
        function getURLParams() {
            const params = new URLSearchParams(window.location.search);
            return {
                funcionario_id: params.get('funcionario_id'),
                nome: params.get('nome')
            };
        }

        // Função para obter cor da pontuação
        function getScoreColor(score) {
            if (score >= 9) return 'green';
            if (score >= 7) return 'blue';
            if (score >= 5) return 'yellow';
            return 'red';
        }

        // Função para obter nível de desempenho
        function getPerformanceLevel(score) {
            if (score >= 8.5) return { level: 'Desempenho excelente', class: 'excellent' };
            if (score >= 7) return { level: 'Desempenho bom', class: 'good' };
            return { level: 'Desempenho médio', class: 'average' };
        }

        // Função para carregar dados do funcionário
        async function loadEmployeeData(funcionarioId) {
            try {
                // Aqui você faria a requisição para seu backend PHP
                const response = await fetch(`get_employee_performance.php?funcionario_id=${funcionarioId}`);
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Erro ao carregar dados:', error);
                // Dados de exemplo para demonstração
                return {
                    funcionario: {
                        nome: 'Giovanna Silva',
                        cargo: 'Desenvolvedora',
                        id: funcionarioId
                    },
                    desempenho: {
                        mes: '2024-06',
                        criterios: [
                            { nome: 'Pontualidade e assiduidade', peso: 3, nota: 8, observacao: 'Chega no horário, mas tem 1 atraso no mês.' },
                            { nome: 'Cumprimento de prazos', peso: 4, nota: 9, observacao: 'Cumpre todos os prazos, muito proativo.' },
                            { nome: 'Qualidade do trabalho entregue', peso: 5, nota: 7, observacao: 'Entrega bom trabalho, mas com pequenas falhas.' },
                            { nome: 'Trabalho em equipe', peso: 3, nota: 6, observacao: 'Precisa melhorar a colaboração com a equipe.' },
                            { nome: 'Comunicação e clareza', peso: 2, nota: 9, observacao: 'Comunicação clara, sem dificuldades.' },
                            { nome: 'Proatividade', peso: 4, nota: 8, observacao: 'Sempre busca se envolver em novos projetos.' },
                            { nome: 'Capacidade de resolver problemas', peso: 4, nota: 7, observacao: 'Resolve problemas, mas algumas soluções são improvisadas.' }
                        ],
                        total_pontos: 191,
                        media: 7.64,
                        resumo: 'Seu desempenho foi sólido e positivo. Você cumpre prazos com pontualidade, demonstra proatividade e entrega trabalhos de boa qualidade, apesar de pequenos erros. Atua bem em equipe, mas pode melhorar na comunicação. Com 191 pontos, seu desempenho reflete comprometimento e potencial para alcançar a excelência.'
                    },
                    historico: [
                        { mes: 'Jan', pontuacao: 6.5 },
                        { mes: 'Fev', pontuacao: 7.2 },
                        { mes: 'Mar', pontuacao: 8.1 },
                        { mes: 'Abr', pontuacao: 8.5 },
                        { mes: 'Mai', pontuacao: 7.8 },
                        { mes: 'Jun', pontuacao: 7.64 }
                    ]
                };
            }
        }

        // Função para renderizar tabela de desempenho
        function renderPerformanceTable(criterios) {
            const tbody = document.getElementById('performanceTableBody');
            let totalPeso = 0;
            let totalPontos = 0;

            const rows = criterios.map(criterio => {
                const pontos = criterio.peso * criterio.nota;
                totalPeso += criterio.peso;
                totalPontos += pontos;

                return `
                    <tr>
                        <td>${criterio.nome}</td>
                        <td>${criterio.peso}</td>
                        <td>
                            <div class="score-bar">
                                <div class="score-progress">
                                    <div class="score-fill ${getScoreColor(criterio.nota)}" style="width: ${criterio.nota * 10}%"></div>
                                </div>
                                <span class="score-value">${criterio.nota}</span>
                            </div>
                        </td>
                        <td><strong>${pontos}</strong></td>
                        <td>${criterio.observacao}</td>
                    </tr>
                `;
            }).join('');

            tbody.innerHTML = rows + `
                <tr style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; font-weight: bold;">
                    <td>Total</td>
                    <td>${totalPeso}</td>
                    <td></td>
                    <td>${totalPontos}</td>
                    <td></td>
                </tr>
            `;
        }

        // Função para renderizar gráfico
        function renderChart(historico) {
            const chart = document.getElementById('performanceChart');
            const labels = document.getElementById('chartLabels');
            
            const maxScore = Math.max(...historico.map(h => h.pontuacao));
            
            const bars = historico.map((h, index) => {
                const height = (h.pontuacao / 10) * 160; // Máximo 160px
                const isLast = index === historico.length - 1;
                return `<div class="chart-bar ${isLast ? 'current' : ''}" style="height: ${height}px;" title="${h.mes}: ${h.pontuacao}"></div>`;
            }).join('');

            const chartLabels = historico.map(h => `<div class="chart-label">${h.mes}</div>`).join('');

            chart.innerHTML = bars;
            labels.innerHTML = chartLabels;
        }

        // Função principal para carregar a página
        async function loadPage() {
            const params = getURLParams();
            
            if (!params.funcionario_id) {
                alert('ID do funcionário não encontrado!');
                return;
            }

            try {
                const data = await loadEmployeeData(params.funcionario_id);
                
                // Preencher informações do funcionário
                document.getElementById('employeeName').textContent = data.funcionario.nome.split(' ')[0];
                document.getElementById('employeeFullName').textContent = data.funcionario.nome;
                document.getElementById('employeeAvatar').textContent = data.funcionario.nome.charAt(0).toUpperCase();
                document.getElementById('employeePosition').textContent = data.funcionario.cargo || 'Funcionário';
                
                // Preencher período
                const mesFormatado = new Date(data.desempenho.mes + '-01').toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' });
                document.getElementById('evaluationPeriod').textContent = `Avaliação de ${mesFormatado}`;
                document.getElementById('performanceMonth').textContent = new Date(data.desempenho.mes + '-01').toLocaleDateString('pt-BR', { month: 'long' });
                
                // Renderizar tabela
                renderPerformanceTable(data.desempenho.criterios);
                
                // Renderizar gráfico
                renderChart(data.historico);
                
                // Preencher resumo
                const performance = getPerformanceLevel(data.desempenho.media);
                document.getElementById('performanceBadge').textContent = performance.level;
                document.getElementById('performanceBadge').className = `performance-badge ${performance.class}`;
                document.getElementById('summaryText').textContent = data.desempenho.resumo;
                
            } catch (error) {
                console.error('Erro ao carregar página:', error);
                document.querySelector('.main-content').innerHTML = '<div class="loading">Erro ao carregar dados do funcionário.</div>';
            }
        }

        // Carregar página quando DOM estiver pronto
        document.addEventListener('DOMContentLoaded', loadPage);
    </script>
</body>
</html>