<?php
include '../../conexao.php'; // ajusta o caminho conforme sua estrutura
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
      <h1 class="saudacao1">Painel de Gerenciamento dos funcionários</h1> <!-- Exibe o nome dinâmico -->
      <h1 class="saudacao2">Adicione, atualize ou remova dados profissionais sobre os funcionários</h1>
    </div>
  </div>
  <div class="tudo">
    <div class="tudo1">
      <div class="sidebar">
        <a href="" class="menu-item">
          <span class="icon home"></span>
        </a>
        <div class="icon-circle">
          <img src="img/people.png" alt="Home icon">
        </div>
        <a href="" class="menu-item">
          <span class="icon docs"></span>
        </a>
        <a href="/augebit/RH/desempenho-cursos/index.php" class="menu-item">
          <span class="icon chapeu"></span>
        </a>
        <a href="" class="menu-item">
          <span class="icon grafico"></span>
        </a>
        <a href="" class="menu-item">
          <span class="icon calendario"></span>
        </a>
      </div>
      <div class="perfil">
        <a class="person" href=""></a>
      </div>
    </div>
    <div class="informacoes">
      <div class="part1">
        <div class="caixa1">
          <img class="img1" src="./img/man.png" alt="">
          <div class="textinhos">
            <a class="info-texto" id="totalFuncionarios" href="">00</a>
            <a class="info-subtexto" href="">Funcionários <br> Totais</a>
          </div>
        </div>
        <div class="caixa1">
          <img class="img1" src="./img/man.png" alt="">
          <div class="textinhos">
            <a class="info-texto" id="homens" href="">00</a>
            <a class="info-subtexto" href="">Funcionários <br> homens</a>
          </div>
        </div>
        <div class="caixa1">
          <img class="img1" src="./img/woman.png" alt="">
          <div class="textinhos">
            <a class="info-texto" id="mulheres" href="">00</a>
            <a class="info-subtexto" href="">Funcionárias <br> mulheres</a>
          </div>
        </div>
      </div>
      <div class="part2">
        <div class="pesquisa-barra">
          <img src="./img/lupa.png" alt="">
          <input id="inputPesquisar" class="pesquisa" type="text" placeholder="Pesquise pelo primeiro nome do funcionário">
        </div>
        <button id="openModal">+ informações</button>
      </div>
      <div id="modalAtualizar" class="modal">
        <div class="modal-content">
          <span class="close" id="fecharAtualizar">&times;</span>
          <div class="text-foto">
            <form id="formAtualizarFuncionario">
              <h2>Atualizar informação</h2>
          </div>
          <label>Nome Completo</label>
        <input class="nome" type="text" name="nome" required>

        <div class="input-duplo">
          <div>
            <label>Cargo</label>
            <input type="text" name="cargo" required>
          </div>
          <div>
            <label>Setor</label>
            <input class="setor" type="text" name="setor" required>
          </div>
        </div>

        <div class="input-duplo">
          <div>
            <label>Horário de Entrada</label>
            <input type="time" name="horario_entrada" required>
          </div>
          <div>
            <label>Horário de Saída</label>
            <input  class="setor" type="time" name="horario_saida" required>
          </div>
        </div>

        <div class="input-triplo">
          <div>
            <label>Tipo de Contrato</label>
            <input type="text" name="tipo_contrato" required>
          </div>
          <div>
            <label>Data de Admissão</label>
            <input type="date" name="data_admissao" required>
          </div>
          <div>
            <label>Salário</label>
            <input type="number" step="0.01" name="salario" required>
          </div>
        </div>

        <div class="input-unico">
          <label>Sindicato</label>
          <input class="sindicato" type="text" name="sindicato">
        </div>
        <div class="botoes">
        <button type="button" id="cancelarAtualizar">CANCELAR</button>
        <button type="submit" id="atualizar">ATUALIZAR</button>
        </div>
            </form>
        </div>
      </div>

      <div id="modal" class="modal">
  <div class="modal-content">
    <span class="close" id="fecharModal">&times;</span>
    <div class="text-foto">
      <form id="formFuncionario" action="gerenciarFuncionarios.php" method="POST">
      <input type="hidden" name="tipo_form" value="profissional">
        <h2>Adicionar informações</h2>
    </div>

        <label>Nome Completo</label>
        <input class="nome" type="text" name="nome" required>

        <div class="input-duplo">
          <div>
            <label>Cargo</label>
            <input type="text" name="cargo" required>
          </div>
          <div>
            <label>Setor</label>
            <input class="setor" type="text" name="setor" required>
          </div>
        </div>

        <div class="input-duplo">
          <div>
            <label>Horário de Entrada</label>
            <input type="time" name="horario_entrada" required>
          </div>
          <div>
            <label>Horário de Saída</label>
            <input  class="setor" type="time" name="horario_saida" required>
          </div>
        </div>

        <div class="input-triplo">
          <div>
            <label>Tipo de Contrato</label>
            <input type="text" name="tipo_contrato" required>
          </div>
          <div>
            <label>Data de Admissão</label>
            <input type="date" name="data_admissao" required>
          </div>
          <div>
            <label>Salário</label>
            <input type="number" step="0.01" name="salario" required>
          </div>
        </div>

        <div class="input-unico">
          <label>Sindicato</label>
          <input class="sindicato" type="text" name="sindicato">
        </div>

        <div class="botoes">
        <button type="button" id="cancelar">CANCELAR</button>
        <button type="submit" id="salvar">SALVAR</button>
        </div>
      </form>
  </div>
</div>

      <div class="part3">
        <table id="tabelaFuncionarios">
          <thead>
            <tr>
              <th>Nome <br> Completo</th>
              <th>Cargo</th>
              <th>Setor</th>
              <th>Horário de entrada</th>
              <th>Horário de saída</th>
              <th>Tipo Contrato</th>
              <th>Data de admissão</th>
              <th>Salário</th>
              <th>Sindicato</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="botoes-navegacao">
  <a class="voltar" href="../gerenciamento-funcionarios/index.php">❮ voltar ou</a>
  <a class="prosseguir" href="../banco-funcionarios/index.php">prosseguir ❯</a>
</div>
  <script src="script2.js"></script>
</body>
</html>
