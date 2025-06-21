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
      <h1 class="saudacao2">Adicione, atualize ou remova dados pessoais sobre os funcionários</h1>
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
        <button id="openModal">+ funcionários</button>
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
                  <label>CPF</label>
                  <input type="text" name="cpf" required>
                </div>
                <div>
                  <label>RG</label>
                  <input class="RG" type="text" name="rg" required>
                </div>
              </div>

              <div class="input-duplo">
                <div>
                  <label>Endereço</label>
                  <input type="text" name="endereco" required>
                </div>
                <div>
                  <label>Gênero</label>
                  <input class="genero" type="text" name="genero" required>
                </div>
              </div>

              <div class="input-triplo">
                <div>
                  <label>E-mail</label>
                  <input type="email" name="email" required>
                </div>
                <div>
                  <label>Telefone</label>
                  <input type="text" name="telefone" required>
                </div>
                <div>
                  <label>Nascimento</label>
                  <input type="date" name="nascimento" required>
                </div>
              </div>

              <div class="input-triplo">
                <div>
                  <label>Estado Civil</label>
                  <input type="text" name="estado" required>
                </div>
                <div>
                  <label>PIS/PASEP</label>
                  <input type="text" name="pis_pasep" required>
                </div>
                <div>
                  <label>Carteira de Trabalho</label>
                  <input type="text" name="carteira" required>
                </div>
              </div>

              <div class="botoes">
                <div class="img-container">
                  <img id="previewImagemAtualizar" class="add" src="./img/add.png" alt="Prévia da foto de perfil">
                  <input type="file" id="uploadImagemAtualizar" accept="image/*" name="foto">
                </div>
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
          <form id="formFuncionario" action="gerenciarFuncionarios.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="tipo_form" value="funcionario">
              <h2>Adicionar funcionário</h2>
          </div>
              <label>Nome Completo</label>
              <input class="nome" type="text" name="nome" required>

              <div class="input-duplo">
                <div>
                  <label>CPF</label>
                  <input type="text" name="cpf" required>
                </div>
                <div>
                  <label>RG</label>
                  <input class="RG" type="text" name="rg" required>
                </div>
              </div>
              <div class="input-duplo">
                <div>
                  <label>Endereço</label>
                  <input type="text" name="endereco" required>
                </div>
                <div>
                  <label>Gênero</label>
                  <input class="genero" type="text" name="genero" required>
                </div>
              </div>
              <div class="input-triplo">
                <div>
                  <label>E-mail</label>
                  <input type="email" name="email" required>
                </div>
                <div>
                  <label>Telefone</label>
                  <input type="text" name="telefone" required>
                </div>
                <div>
                  <label>Nascimento</label>
                  <input type="date" name="nascimento" required>
                </div>
              </div>
              <div class="input-triplo">
                <div>
                  <label>Estado Civil</label>
                  <input type="text" name="estado" required>
                </div>
                <div>
                  <label>PIS/PASEP</label>
                  <input type="text" name="pis_pasep" required>
                </div>
                <div>
                  <label>Carteira de Trabalho</label>
                  <input type="text" name="carteira" required>
                </div>
              </div>

              <div class="botoes">
                <div class="img-container">
                  <img id="previewImagem" class="add" src="./img/add.png" alt="Prévia da foto de perfil">
                  <input type="file" id="uploadImagem" accept="image/*" name="foto">
                </div>
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
              <th>CPF</th>
              <th>RG</th>
              <th>Nascimento</th>
              <th>Gênero</th>
              <th>Endereço</th>
              <th>Telefone</th>
              <th>E-mail</th>
              <th>Estado <br> Civil</th>
              <th>PIS/ <br> PASEP</th>
              <th>Carteira de <br> trabalho</th>
              <th>Foto</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <a class="prosseguir" href="../profissional-funcionarios/index.php">prosseguir ❯</a>
  <script src="script2.js"></script>
</body>
</html>
