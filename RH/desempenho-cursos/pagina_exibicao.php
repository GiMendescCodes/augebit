<?php
include '../../conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID não informado.";
    exit;
}

$sql = "SELECT * FROM avaliacoes_funcionarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Avaliação não encontrada.";
    exit;
}
$row = $result->fetch_assoc();

// Decodificar os JSON para arrays
$criterios = json_decode($row['criterios'], true);
$resultados = json_decode($row['resultados'], true);
$cursos_atuais = json_decode($row['cursos_atuais'], true);
$cursos_pendentes = json_decode($row['cursos_pendentes'], true);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Exibição de Avaliação</title>
    <link rel="stylesheet" href="style1.css" />
</head>
<body>
    <div class="comeco">
        <img class="logo" src="./img/augebit.png" alt="" />
        <div class="texto">
              <h1 class="saudacao1">Olá, <?= htmlspecialchars($row['nome_funcionario']) ?>!</h1>
    <h1 class="saudacao2">Acompanhe seu desempenho nos treinamentos complementares</h1>
        </div>
    </div>
    <div class="tudo">
        <div class="tudo1">
         <div class="sidebar">
                <a href="/augebit/FUNCIONARIO/inicial-funcionario/index.php?id=<?= $id ?>" class="menu-item"><span class="icon home"></span></a>
                   <a href="notebook.html" class="menu-item"><span class="icon notebook"></span></a>
                <div class="icon-circle">
                <img src="img/chapeuu.png" alt="Home icon">
                  </div>
                <a href="chart.html" class="menu-item"><span class="icon chart"></span></a>
                <a href="phone.html" class="menu-item"><span class="icon phone"></span></a>
            </div>
            <div class="perfil"><a class="person" href=""></a></div>
        </div>

        <div class="informacoes">
            <!-- SEÇÃO 1 -->
            <input type="text" class="section-title-input" value="<?= htmlspecialchars($row['titulo_secao1']) ?>" disabled />
            <input type="text" class="course-title-input" value="<?= htmlspecialchars($row['curso1']) ?>" disabled />
            <div class="search-field">
                
            </div>

            <div class="completed-section">
                <div class="section1">
                    <div class="progress-circle">
                        <div class="circle-bg">
                            <div class="circle-inner">
                                <input type="number" class="percentage-input" value="<?= htmlspecialchars($row['porcentagem1']) ?>" min="0" max="100" disabled />
                                <div class="percentage-label">% de acertos</div>
                            </div>
                        </div>
                    </div>

                    <div class="results-section">
                        <div class="results-table">
                            <div class="table-header">
                                <input type="text" class="table-header-input" value="Critério" disabled />
                                <input type="text" class="table-header-input" value="Resultado" disabled />
                            </div>

                            <?php
                            if ($criterios && $resultados) {
                                foreach ($criterios as $index => $criterio) {
                                    $resultado = $resultados[$index] ?? '';
                                    echo '
                                    <div class="table-row">
                                        <input type="text" class="table-input" value="' . htmlspecialchars($criterio) . '" disabled />
                                        <input type="text" class="table-input" value="' . htmlspecialchars($resultado) . '" disabled />
                                    </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="info">
                        <img class="summary-icon" src="./img/chapeu1.png" alt="" />
                        <input type="text" class="desempenho" value="<?= htmlspecialchars($row['classificacao']) ?>" disabled />
                    </div>

                    <h1 class="resumo">Resumo da avaliação</h1>
                    <div class="summary-card">
                        <textarea class="summary-textarea" disabled><?= htmlspecialchars($row['resumo']) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SEÇÃO 2: CURSOS ATUAIS -->
            <input type="text" class="section-title-input" value="<?= htmlspecialchars($row['titulo_secao2']) ?>" disabled />

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

            <!-- SEÇÃO 3: CURSOS PENDENTES -->
            <input type="text" class="section-title-input" value="<?= htmlspecialchars($row['titulo_secao3']) ?>" disabled />
            <div class="section2">
                <div class="pending-courses">
                    <?php
                    if ($cursos_pendentes) {
                        // Cursos pendentes: array associativo com 'nome' e 'desc' arrays
                        $count_p = count($cursos_pendentes['nome'] ?? []);
                        for ($i = 0; $i < $count_p; $i++) {
                            $nome_pendente = $cursos_pendentes['nome'][$i] ?? '';
                            $desc_pendente = $cursos_pendentes['desc'][$i] ?? '';
                            echo '
                            <div class="pending-card">
                                <div class="pending-content">
                                    <input type="text" class="pending-title-input" value="' . htmlspecialchars($nome_pendente) . '" disabled />
                                    <textarea class="pending-desc-textarea" disabled>' . htmlspecialchars($desc_pendente) . '</textarea>
                                </div>
                                <img class="pending-illustration" src="./img/img' . ($i + 1) . '.png" alt="" />
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
<?php
$stmt->close();
$conn->close();
?>
