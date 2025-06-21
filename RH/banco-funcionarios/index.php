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
      <h1 class="saudacao1">Painel de Gerenciamento dos funcionários</h1>
      <h1 class="saudacao2">Adicione, atualize ou remova dados bancários dos funcionários</h1>
    </div>
  </div>
  <div class="tudo">
    <div class="tudo1">
      <div class="sidebar">
        <a href="" class="menu-item"><span class="icon home"></span></a>
        <div class="icon-circle"><img src="img/people.png" alt="Home icon"></div>
        <a href="" class="menu-item"><span class="icon docs"></span></a>
        <a href="/augebit/RH/desempenho-cursos/index.php" class="menu-item"><span class="icon chapeu"></span></a>
        <a href="" class="menu-item"><span class="icon grafico"></span></a>
        <a href="" class="menu-item"><span class="icon calendario"></span></a>
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
          <input id="inputPesquisar" class="pesquisa" type="text" placeholder="Pesquise pelo nome do funcionário">
        </div>
        <button id="openModal">+ informações</button>
      </div>

      <!-- Modal Atualizar -->
      <div id="modalAtualizar" class="modal">
        <div class="modal-content">
          <span class="close" id="fecharAtualizar">&times;</span>
          <form id="formAtualizarFuncionario">
            <h2>Atualizar dados bancários</h2>

            <label>Nome Completo</label>
            <input type="text" name="nome" required>

            <label>Nome do Banco</label>
            <input type="text" name="banco" required>

            <label>Agência</label>
            <input type="text" name="agencia" required>

            <label>Corrente ou Poupança</label>
            <input type="text" name="tipo_corrente_poupanca" required>

            <label>Tipo de Conta</label>
            <input type="text" name="tipo_conta" required>

            <div class="botoes">
              <button type="button" id="cancelarAtualizar">CANCELAR</button>
              <button type="submit" id="atualizar">ATUALIZAR</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Modal Adicionar -->
      <div id="modal" class="modal">
        <div class="modal-content">
          <span class="close" id="fecharModal">&times;</span>
          <form id="formFuncionario" action="gerenciarFuncionarios.php" method="POST">
            <input type="hidden" name="tipo_form" value="dados_bancarios">
            <h2>Adicionar dados bancários</h2>

            <label>Nome Completo</label>
            <input type="text" name="nome" required>

            <label>Nome do Banco</label>
            <input type="text" name="banco" required>

            <label>Agência</label>
            <input type="text" name="agencia" required>

            <label>Corrente ou Poupança</label>
            <input type="text" name="tipo_corrente_poupanca" required>

            <label>Tipo de Conta</label>
            <input type="text" name="tipo_conta" required>

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
              <th>Nome Completo</th>
              <th>Nome do Banco</th>
              <th>Agência</th>
              <th>Corrente ou<br> Poupança</th>
              <th>Tipo de <br> Conta</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <!-- Conteúdo dinâmico será inserido via JS ou PHP -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="botoes-navegacao">
    <a class="voltar" href="../gerenciamento-funcionarios/index.php">❮ voltar</a>
  </div>

  <script src="script2.js"></script>
</body>
</html>
