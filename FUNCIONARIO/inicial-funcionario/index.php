<?php
session_start();
include '../../conexao.php';

if (!isset($_GET['id'])) {
    echo "Funcionário não identificado.";
    exit;
}

$id_funcionario = intval($_GET['id']);

<<<<<<< HEAD
$sql = "SELECT * FROM funcionarios WHERE id = ?";
$stmt = $conn->prepare($sql);
=======
// Buscar dados do funcionário
$sql = "SELECT * FROM funcionarios WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro ao preparar consulta de funcionário: " . $conn->error);
}
>>>>>>> b26db88 (up)
$stmt->bind_param("i", $id_funcionario);
$stmt->execute();
$result = $stmt->get_result();
$funcionario = $result->fetch_assoc();

if (!$funcionario) {
    echo "Funcionário não encontrado.";
    exit;
}
<<<<<<< HEAD
?>

=======

// Buscar dados de desempenho para gráfico
$sql_avaliacoes = "
    SELECT data_registro, porcentagem1 AS average 
    FROM avaliacoes_funcionarios 
    WHERE nome_funcionario = ? 
    ORDER BY data_registro ASC
";

$stmt_av = $conn->prepare($sql_avaliacoes);
if (!$stmt_av) {
    die("Erro ao preparar consulta de avaliações: " . $conn->error);
}
$stmt_av->bind_param("s", $funcionario['nome']);
$stmt_av->execute();
$result_av = $stmt_av->get_result();

$avaliacoes = [];
while ($row = $result_av->fetch_assoc()) {
    $dateObj = new DateTime($row['data_registro']);
    $avaliacoes[] = [
        "month" => $dateObj->format('M'),  // abreviação do mês
        "score" => floatval($row['average'])
    ];
}

// Buscar cursos atuais
$sql_cursos = "SELECT cursos_atuais FROM avaliacoes_funcionarios WHERE nome_funcionario = ?";
$stmt_cursos = $conn->prepare($sql_cursos);
if (!$stmt_cursos) {
    die("Erro ao preparar consulta de cursos: " . $conn->error);
}
$stmt_cursos->bind_param("s", $funcionario['nome']);
$stmt_cursos->execute();
$result_cursos = $stmt_cursos->get_result();
$row = $result_cursos->fetch_assoc();

$cursos_atuais_raw = $row['cursos_atuais'] ?? '{}';
$cursos_json = json_decode($cursos_atuais_raw, true);

$cursos_atuais = [];
$count = count($cursos_json['progresso'] ?? []);

for ($i = 0; $i < $count; $i++) {
    $cursos_atuais[] = [
        'progresso' => $cursos_json['progresso'][$i] ?? '',
        'nome' => $cursos_json['nome'][$i] ?? '',
        'desc1' => $cursos_json['desc1'][$i] ?? '',
        'desc2' => $cursos_json['desc2'][$i] ?? ''
    ];
}
?>



>>>>>>> b26db88 (up)
<!DOCTYPE html>
<html lang="pt-br">

<head>
<<<<<<< HEAD
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Augebit</title>
    <link rel="stylesheet" href="./style.css">
=======
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Augebit</title>
    <link rel="stylesheet" href="./style.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
>>>>>>> b26db88 (up)
</head>

<body>
    <div class="comeco">
<<<<<<< HEAD
        <img class="logo" src="./img/augebit.png" alt="">
        <div class="texto">
            <h1 class="saudacao1">Olá, <?= htmlspecialchars($funcionario['nome_funcionario']) ?>!</h1>
            <h1 class="saudacao2">Veja suas atividades para hoje</h1>
=======
        <img class="logo" src="./img/augebit.png" alt="Logo Augebit" />
        <div class="texto">
            <h1 class="saudacao1">Olá, <?= htmlspecialchars($funcionario['nome']) ?>!</h1>
            <h2 class="saudacao2">Veja suas atividades para hoje</h2>
>>>>>>> b26db88 (up)
        </div>
    </div>
    <div class="tudo">
        <div class="tudo1">
            <div class="sidebar">
                <div class="icon-circle">
<<<<<<< HEAD
                    <img src="img/casa.png" alt="Home icon">
                </div>
                <a href="notebook.html" class="menu-item"><span class="icon notebook"></span></a>
                <a href="/augebit/RH/desempenho-cursos/pagina_exibicao.php?id=<?= $id ?>" class="menu-item"><span
                        class="icon cap"></span></a>
=======
                    <img src="img/casa.png" alt="Home icon" />
                </div>
                <a href="notebook.html" class="menu-item"><span class="icon notebook"></span></a>
                <a href="/augebit/RH/desempenho-cursos/pagina_exibicao.php?id=<?= $id_funcionario ?>" class="menu-item"><span class="icon cap"></span></a>
>>>>>>> b26db88 (up)
                <a href="chart.html" class="menu-item"><span class="icon chart"></span></a>
                <a href="phone.html" class="menu-item"><span class="icon phone"></span></a>
            </div>
            <div class="perfil"><a class="person" href=""></a></div>
        </div>

        <div class="informacoes">
            <div class="part1">
                <div class="caixa1">
<<<<<<< HEAD
                    <img class="img1" src="./img/img1.png" alt="">
=======
                    <img class="img1" src="./img/img1.png" alt="" />
>>>>>>> b26db88 (up)
                    <div class="textinhos">
                        <a class="info-texto" href="">Solicitações</a>
                        <a class="info-subtexto" href="">Solicitar férias, folgas, etc</a>
                    </div>
                </div>
                <div class="caixa1">
<<<<<<< HEAD
                    <img class="img2" src="./img/img2.png" alt="">
                    <div class="textinhos">
                        <a class="info-texto2"
                            href="/augebit/RH/desempenho-cursos/pagina_exibicao.php?id=<?= $id ?>">Cursos</a>
=======
                    <img class="img2" src="./img/img2.png" alt="" />
                    <div class="textinhos">
                        <a class="info-texto2" href="/augebit/RH/desempenho-cursos/pagina_exibicao.php?id=<?= $id_funcionario ?>">Cursos</a>
>>>>>>> b26db88 (up)
                        <a class="info-subtexto2" href="">Desempenho nos cursos</a>
                    </div>
                </div>
                <div id="caixaJustificativa" class="caixa1" style="display: none;">
<<<<<<< HEAD
                    <img class="img3" src="./img/img3.png" alt="">
=======
                    <img class="img3" src="./img/img3.png" alt="" />
>>>>>>> b26db88 (up)
                    <div class="textinhos">
                        <a class="info-texto3" href="">Justificativa</a>
                        <a class="info-subtexto3" href="">Justifique atrasos, faltas, etc</a>
                    </div>
                </div>
                <div class="caixa4" id="caixaAdicionar">
                    <button id="adicionarJustificativa">
<<<<<<< HEAD
                        <img class="mais" src="./img/mais.png" alt="">
=======
                        <img class="mais" src="./img/mais.png" alt="Adicionar justificativa" />
>>>>>>> b26db88 (up)
                    </button>
                </div>
            </div>

            <div class="part2">
                <div class="caixa2">
                    <h1 class="info-texto4">Check-in / Check-out</h1>
                    <div class="entrada">
                        <h1 class="Check-in">Dia e Horário de entrada</h1>
                        <div class="linha">
                            <label>Data:</label>
<<<<<<< HEAD
                            <input class="data-entrada" type="date">
                            <label class="hora">Hora:</label>
                            <input class="hora-entrada" type="time">
=======
                            <input class="data-entrada" type="date" />
                            <label class="hora">Hora:</label>
                            <input class="hora-entrada" type="time" />
>>>>>>> b26db88 (up)
                            <button class="botao-salvar">
                                <h1 class="titulo-salvar">salvar</h1>
                            </button>
                        </div>
                    </div>
                    <div class="entrada">
                        <h1 class="Check-in">Dia e Horário de saída</h1>
                        <div class="linha1">
                            <label>Data:</label>
<<<<<<< HEAD
                            <input class="data-entrada" type="date">
                            <label class="hora">Hora:</label>
                            <input class="hora-entrada" type="time">
=======
                            <input class="data-entrada" type="date" />
                            <label class="hora">Hora:</label>
                            <input class="hora-entrada" type="time" />
>>>>>>> b26db88 (up)
                            <button class="botao-salvar">
                                <h1 class="titulo-salvar">salvar</h1>
                            </button>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
                <div class="caixa5">
                    <h1 class="info-texto5">Desempenho Profissional em %</h1>
=======

                <div class="chart-container">
                    <div class="chart-title">Desempenho Profissional em %</div>
                    <canvas id="graficoDesempenho" width="400" height="200"></canvas>
>>>>>>> b26db88 (up)
                </div>
            </div>

            <div class="section2">
                <div class="current-courses">
<<<<<<< HEAD
                    <?php
                    if ($cursos_atuais) {
                        // É um array associativo com 'progresso', 'nome', 'desc1', 'desc2' sendo arrays
                        $count = count($cursos_atuais['progresso'] ?? []);
                        for ($i = 0; $i < $count; $i++) {
                            $progresso = $cursos_atuais['progresso'][$i] ?? '';
                            $nome = $cursos_atuais['nome'][$i] ?? '';
                            $desc1 = $cursos_atuais['desc1'][$i] ?? '';
                            $desc2 = $cursos_atuais['desc2'][$i] ?? '';
                            echo '
                            <div class="course-card1">
                                <div class="course-progress">
                                    <input type="number" class="progress-input" value="' . htmlspecialchars($progresso) . '" min="0" max="100" disabled />%
                                </div>
                                <div class="course-info">
                                    <input type="text" class="course-name-input" value="' . htmlspecialchars($nome) . '" disabled />
                                    <input type="text" class="course-desc-input1" value="' . htmlspecialchars($desc1) . '" disabled />
                                    <input type="text" class="course-desc-input" value="' . htmlspecialchars($desc2) . '" disabled />
                                </div>
                            </div>';
                        }
                    }
                    ?>
=======
                    <?php if (!empty($cursos_atuais)) : ?>
                        <?php foreach ($cursos_atuais as $curso) : ?>
                            <div class="course-card1">
                                <div class="course-progress">
                                    <input type="number" class="progress-input" value="<?= htmlspecialchars($curso['progresso']) ?>" min="0" max="100" disabled />%
                                </div>
                                <div class="course-info">
                                    <input type="text" class="course-name-input" value="<?= htmlspecialchars($curso['nome']) ?>" disabled />
                                    <input type="text" class="course-desc-input1" value="<?= htmlspecialchars($curso['desc1']) ?>" disabled />
                                    <input type="text" class="course-desc-input" value="<?= htmlspecialchars($curso['desc2']) ?>" disabled />
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Este funcionário ainda não possui cursos atuais.</p>
                    <?php endif; ?>
>>>>>>> b26db88 (up)
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
=======

    <!-- Passar os dados do gráfico para o JS -->
    <script>
        window.chartData = <?= json_encode($avaliacoes) ?>;
    </script>

>>>>>>> b26db88 (up)
    <script src="script.js"></script>
</body>

</html>