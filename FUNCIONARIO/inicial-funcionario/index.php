<?php
session_start();
include '../../conexao.php';

if (!isset($_GET['id'])) {
    echo "Funcionário não identificado.";
    exit;
}

$id_funcionario = intval($_GET['id']);

$sql = "SELECT * FROM funcionarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_funcionario);
$stmt->execute();
$result = $stmt->get_result();
$funcionario = $result->fetch_assoc();

if (!$funcionario) {
    echo "Funcionário não encontrado.";
    exit;
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
    <div class="comeco">
        <img class="logo" src="./img/augebit.png" alt="">
        <div class="texto">
            <h1 class="saudacao1">Olá, <?= htmlspecialchars($funcionario['nome_funcionario']) ?>!</h1>
            <h1 class="saudacao2">Veja suas atividades para hoje</h1>
        </div>
    </div>
    <div class="tudo">
        <div class="tudo1">
            <div class="sidebar">
                <div class="icon-circle">
                    <img src="img/casa.png" alt="Home icon">
                </div>
                <a href="notebook.html" class="menu-item"><span class="icon notebook"></span></a>
                <a href="/augebit/RH/desempenho-cursos/pagina_exibicao.php?id=<?= $id ?>" class="menu-item"><span
                        class="icon cap"></span></a>
                <a href="chart.html" class="menu-item"><span class="icon chart"></span></a>
                <a href="phone.html" class="menu-item"><span class="icon phone"></span></a>
            </div>
            <div class="perfil"><a class="person" href=""></a></div>
        </div>

        <div class="informacoes">
            <div class="part1">
                <div class="caixa1">
                    <img class="img1" src="./img/img1.png" alt="">
                    <div class="textinhos">
                        <a class="info-texto" href="">Solicitações</a>
                        <a class="info-subtexto" href="">Solicitar férias, folgas, etc</a>
                    </div>
                </div>
                <div class="caixa1">
                    <img class="img2" src="./img/img2.png" alt="">
                    <div class="textinhos">
                        <a class="info-texto2"
                            href="/augebit/RH/desempenho-cursos/pagina_exibicao.php?id=<?= $id ?>">Cursos</a>
                        <a class="info-subtexto2" href="">Desempenho nos cursos</a>
                    </div>
                </div>
                <div id="caixaJustificativa" class="caixa1" style="display: none;">
                    <img class="img3" src="./img/img3.png" alt="">
                    <div class="textinhos">
                        <a class="info-texto3" href="">Justificativa</a>
                        <a class="info-subtexto3" href="">Justifique atrasos, faltas, etc</a>
                    </div>
                </div>
                <div class="caixa4" id="caixaAdicionar">
                    <button id="adicionarJustificativa">
                        <img class="mais" src="./img/mais.png" alt="">
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
                            <input class="data-entrada" type="date">
                            <label class="hora">Hora:</label>
                            <input class="hora-entrada" type="time">
                            <button class="botao-salvar">
                                <h1 class="titulo-salvar">salvar</h1>
                            </button>
                        </div>
                    </div>
                    <div class="entrada">
                        <h1 class="Check-in">Dia e Horário de saída</h1>
                        <div class="linha1">
                            <label>Data:</label>
                            <input class="data-entrada" type="date">
                            <label class="hora">Hora:</label>
                            <input class="hora-entrada" type="time">
                            <button class="botao-salvar">
                                <h1 class="titulo-salvar">salvar</h1>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="caixa5">
                    <h1 class="info-texto5">Desempenho Profissional em %</h1>
                </div>
            </div>

            <div class="section2">
                <div class="current-courses">
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
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>