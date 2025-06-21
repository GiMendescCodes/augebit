<?php
include '../../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Augebit</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="comeco">
    <img class="logo" src="./img/augebit.png" alt="">
    <div class="texto">
      <h1 class="saudacao1">Painel de Desempenho de Cursos</h1>
      <h1 class="saudacao2">Preencha abaixo os dados de desempenho dos cursos do funcionário</h1>
    </div>
  </div>

  <div class="tudo">
    <div class="tudo1">
      <div class="sidebar">
        <a href="" class="menu-item"><span class="icon home"></span></a>
        <a href="/augebit/RH/gerenciamento-funcionarios/index.php" class="menu-item"><span class="icon people"></span></a>
        <a href="" class="menu-item"><span class="icon docs"></span></a>
        <div class="icon-circle"><img src="img/chapeuu.png" alt="Home icon"></div>
        <a href="" class="menu-item"><span class="icon grafico"></span></a>
        <a href="" class="menu-item"><span class="icon calendario"></span></a>
      </div>
      <div class="perfil">
        <a class="person" href=""></a>
      </div>
    </div>

    <form action="salvar_dados.php" method="POST">
    
      <div class="informacoes">
        <input type="text" class="section-title-input" name="titulo_secao1" value="Cursos concluídos e seus resultados:">
        <input type="text" class="course-title-input" name="curso1" value="Design de Equipamentos Industriais">
        <div class="search-field">
        <input type="text" class="search-input" placeholder="Digite o nome do funcionário aqui..." id="funcionarioInput" name="nome_funcionario" >
        <div class="search-icon">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
        </div>
    </div>
        <div class="completed-section">
          <div class="section1">
            <div class="progress-circle">
              <div class="circle-bg">
                <div class="circle-inner">
                  <input type="number" class="percentage-input" name="porcentagem1" value="90" min="0" max="100">
                  <div class="percentage-label">% de acertos</div>
                </div>
              </div>
            </div>

            <div class="results-section">
              <div class="results-table">
                <div class="table-header">
                  <input type="text" class="table-header-input" value="Critério" disabled>
                  <input type="text" class="table-header-input" value="Resultado" disabled>
                </div>

                <!-- Repetição de critérios -->
                <?php
                $criterios = [
                  ["Concluído dentro do prazo", "Sim"],
                  ["Nota final / Aproveitamento", "9,5 / aprovado"],
                  ["Participação em fóruns", "100% - participou de todas"],
                  ["Melhora de performance", "Sim - aumento na eficiência"],
                  ["Aplicação prática", "Sim - melhorias na logística"],
                  ["Feedback do gestor", "Positivo - mais autônoma e técnica"],
                  ["Relevância do curso", "Alta"]
                ];

                foreach ($criterios as $c) {
                  echo '
                  <div class="table-row">
                    <input type="text" class="table-input" name="criterio1[]" value="' . $c[0] . '" placeholder="Digite o critério...">
                    <input type="text" class="table-input" name="resultado1[]" value="' . $c[1] . '" placeholder="Digite o resultado...">
                  </div>';
                }
                ?>
              </div>
            </div>
          </div>

          <div class="section">
            <div class="info">
              <img class="summary-icon" src=".\img\chapeu1.png" alt="">
              <select class="desempenho" name="classificacao">
                <option value="">Classifique o desempenho ▼</option>
                <option value="ruim">Ruim</option>
                <option value="regular">Regular</option>
                <option value="bom">Bom</option>
                <option value="ótimo">Ótimo</option>
                <option value="excelente">Excelente</option>
              </select>
            </div>

            <h1 class="resumo">Resumo da avaliação</h1>
            <div class="summary-card">
              <textarea class="summary-textarea" name="resumo">Giovanna, você concluiu o curso dentro do prazo, com excelente aproveitamento e participação ativa em todas as atividades. Aplicou rapidamente os conhecimentos no trabalho, desenvolvendo melhorias em equipamentos e aumentando a eficiência. Seu gestor destacou sua evolução técnica e maior iniciativa. Este curso foi extremamente relevante para suas atividades.</textarea>
            </div>
          </div>
        </div>

        <!-- CURSOS ATUAIS -->
        <input type="text" class="section-title-input" name="titulo_secao2" value="Cursos atuais:" placeholder="Digite o título da seção...">

        <div class="section2">
          <div class="current-courses">
            <?php
            $cursos_atuais = [
              [100, "Modelagem Paramétrica", "100% completo"],
              [50, "Prototipagem e Impressão 3D", "50% completo"],
              [30, "Desenho Técnico Mecânico", "30% completo"]
            ];

            foreach ($cursos_atuais as $curso) {
              echo '
              <div class="course-card1">
                <div class="course-progress">
                  <input type="number" class="progress-input" name="progresso_curso_atual[]" value="' . $curso[0] . '" min="0" max="100">%
                </div>
                <div class="course-info">
                  <input type="text" class="course-name-input" name="curso_atual_nome[]" value="Curso" placeholder="Nome do curso...">
                  <input type="text" class="course-desc-input1" name="curso_atual_desc1[]" value="' . $curso[1] . '" placeholder="Descrição do curso...">
                  <input type="text" class="course-desc-input" name="curso_atual_desc2[]" value="' . $curso[2] . '" placeholder="Descrição do curso...">
                </div>
              </div>';
            }
            ?>
          </div>
        </div>

        <!-- CURSOS PENDENTES -->
        <div class="section2">
          <input type="text" class="section-title-input" name="titulo_secao3" value="Cursos pendentes:" placeholder="Digite o título da seção...">
          <div class="pending-courses">
            <?php
            $pendentes = [
              ["Design Centrado no Usuário", "Curso que ensina a aplicar UX no desenvolvimento de produtos industriais mais intuitivos e eficientes.", "img1.png"],
              ["Ergonomia no Design de Produtos", "Curso que aborda como tornar produtos mais confortáveis e seguros para o uso humano.", "img2.png"],
              ["Desenho Técnico Mecânico", "Curso que ensina a criar e interpretar desenhos técnicos para projetos mecânicos.", "img3.png"],
              ["Materiais Industriais e Sustentáveis", "Curso sobre escolha e aplicação de materiais eficientes e ecológicos na indústria.", "img4.png"]
            ];

            foreach ($pendentes as $pendente) {
              echo '
              <div class="pending-card">
                <div class="pending-content">
                  <input type="text" class="pending-title-input" name="curso_pendente_nome[]" value="' . $pendente[0] . '" placeholder="Nome do curso...">
                  <textarea class="pending-desc-textarea" name="curso_pendente_desc[]" placeholder="Descrição do curso...">' . $pendente[1] . '</textarea>
                </div>
                <img class="pending-illustration" src="./img/' . $pendente[2] . '" alt="">
              </div>';
            }
            ?>
          </div>
        </div>

        <button class="save-button" type="submit">Salvar Todas as Alterações</button>
      </div>
    </form>

    <script src="script.js"></script>
  </div>
</body>
</html>
