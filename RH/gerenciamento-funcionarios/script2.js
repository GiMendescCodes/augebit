// --- Função para atualizar os contadores (total, homens, mulheres) ---
function atualizarContadores() {
  fetch('contagemFuncionarios.php')
    .then(response => response.json())
    .then(data => {
      document.getElementById('totalFuncionarios').textContent = data.total.toString().padStart(2, '0');
      document.getElementById('homens').textContent = data.homens.toString().padStart(2, '0');
      document.getElementById('mulheres').textContent = data.mulheres.toString().padStart(2, '0');
    })
    .catch(error => console.error('Erro ao buscar contagem:', error));
}

// --- Abertura e fechamento dos modais ---
const btnAbrirModal = document.getElementById('openModal');
const modal = document.getElementById('modal');
const btnFecharModal = document.getElementById('fecharModal');

btnAbrirModal.addEventListener('click', () => {
  modal.style.display = 'block';
});

btnFecharModal.addEventListener('click', () => {
  modal.style.display = 'none';
});

window.addEventListener('click', (event) => {
  if (event.target === modal) {
    modal.style.display = 'none';
  }
});

// --- Envio do formulário de cadastro ---
const formFuncionario = document.getElementById('formFuncionario');
const tabela = document.getElementById('tabelaFuncionarios').querySelector('tbody');

formFuncionario.addEventListener('submit', function(event) {
  event.preventDefault();

  const formData = new FormData(formFuncionario);

  fetch('gerenciarFuncionarios.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const f = data.funcionario;

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${f.nome}</td>
        <td>${f.cpf}</td>
        <td>${f.rg}</td>
        <td>${f.nascimento}</td>
        <td>${f.genero}</td>
        <td>${f.endereco}</td>
        <td>${f.telefone}</td>
        <td>${f.email}</td>
        <td>${f.estado}</td>
        <td>${f.pis_pasep}</td>
        <td>${f.carteira}</td>
        <td>
          ${f.foto ? `<img src="uploads/${f.foto}" alt="Foto" style="width:40px; height:40px; object-fit:cover; border-radius: 50%;">` : ''}
        </td>
        <td style="text-align:center;">
          <img src="img/editar.png" alt="Editar" class="editar" style="width:20px; cursor:pointer; margin-right:8px;">
          <img src="img/lixeira.png" alt="Remover" class="remover" style="width:20px; cursor:pointer;">
        </td>
      `;

      tabela.appendChild(tr);
      atualizarContadores();

      formFuncionario.reset();
      modal.style.display = 'none';
    } else {
      alert('Erro: ' + data.error);
    }
  })
  .catch(error => {
    console.error('Erro na requisição:', error);
  });
});

// --- Atualização de funcionário ---
const modalAtualizar = document.getElementById('modalAtualizar');
const btnFecharAtualizar = document.getElementById('fecharAtualizar');
const btnCancelarAtualizar = document.getElementById('cancelarAtualizar');
const formAtualizarFuncionario = document.getElementById('formAtualizarFuncionario');
const btnCancelarCadastro = document.getElementById('cancelar');

btnCancelarCadastro.addEventListener('click', () => {
  modal.style.display = 'none';
});


let linhaEditando = null;

tabela.addEventListener('click', (event) => {
  if (event.target.classList.contains('editar')) {
    linhaEditando = event.target.closest('tr');
    const celulas = linhaEditando.querySelectorAll('td');

    formAtualizarFuncionario.nome.value = celulas[0].textContent.trim();
    formAtualizarFuncionario.cpf.value = celulas[1].textContent.trim();
    formAtualizarFuncionario.rg.value = celulas[2].textContent.trim();
    formAtualizarFuncionario.nascimento.value = celulas[3].textContent.trim();
    formAtualizarFuncionario.genero.value = celulas[4].textContent.trim();
    formAtualizarFuncionario.endereco.value = celulas[5].textContent.trim();
    formAtualizarFuncionario.telefone.value = celulas[6].textContent.trim();
    formAtualizarFuncionario.email.value = celulas[7].textContent.trim();
    formAtualizarFuncionario.estado.value = celulas[8].textContent.trim();
    formAtualizarFuncionario.pis_pasep.value = celulas[9].textContent.trim();
    formAtualizarFuncionario.carteira.value = celulas[10].textContent.trim();

    const imgTd = celulas[11];
    const imgElem = imgTd.querySelector('img');
    document.getElementById('previewImagemAtualizar').src = imgElem ? imgElem.src : './img/add.png';

    modalAtualizar.style.display = 'block';
  }
});

btnFecharAtualizar.addEventListener('click', () => {
  modalAtualizar.style.display = 'none';
});
btnCancelarAtualizar.addEventListener('click', () => {
  modalAtualizar.style.display = 'none';
});
window.addEventListener('click', (event) => {
  if (event.target === modalAtualizar) {
    modalAtualizar.style.display = 'none';
  }
});

formAtualizarFuncionario.addEventListener('submit', function(event) {
  event.preventDefault();

  if (!linhaEditando) {
    alert('Erro: linha para editar não encontrada.');
    return;
  }

  const formData = new FormData(formAtualizarFuncionario);

  fetch('atualizarFuncionario.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const f = data.funcionario;

      linhaEditando.cells[0].textContent = f.nome;
      linhaEditando.cells[1].textContent = f.cpf;
      linhaEditando.cells[2].textContent = f.rg;
      linhaEditando.cells[3].textContent = f.nascimento;
      linhaEditando.cells[4].textContent = f.genero;
      linhaEditando.cells[5].textContent = f.endereco;
      linhaEditando.cells[6].textContent = f.telefone;
      linhaEditando.cells[7].textContent = f.email;
      linhaEditando.cells[8].textContent = f.estado;
      linhaEditando.cells[9].textContent = f.pis_pasep;
      linhaEditando.cells[10].textContent = f.carteira;
      linhaEditando.cells[11].innerHTML = f.foto ? `<img src="uploads/${f.foto}" alt="Foto" style="width:40px; height:40px; object-fit:cover; border-radius: 50%;">` : '';

      modalAtualizar.style.display = 'none';
      formAtualizarFuncionario.reset();
      linhaEditando = null;

      atualizarContadores();
    } else {
      alert('Erro ao atualizar: ' + data.error);
    }
  })
  .catch(error => {
    console.error('Erro na requisição:', error);
  });
});

// --- Remoção de funcionário ---
tabela.addEventListener('click', (event) => {
  if (event.target.classList.contains('remover')) {
    const linha = event.target.closest('tr');
    const cpf = linha.cells[1].textContent.trim();

    if (confirm(`Confirma exclusão do funcionário com CPF ${cpf}?`)) {
      fetch('deletarFuncionario.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `cpf=${encodeURIComponent(cpf)}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          linha.remove();
          atualizarContadores();
          alert('Funcionário removido com sucesso!');
        } else {
          alert('Erro ao remover: ' + data.error);
        }
      })
      .catch(err => {
        console.error('Erro na requisição:', err);
        alert('Erro ao remover o funcionário.');
      });
    }
  }
});

// --- Filtro de pesquisa ---
const inputPesquisar = document.getElementById('inputPesquisar');

inputPesquisar.addEventListener('input', () => {
  const filtro = inputPesquisar.value.toLowerCase();
  const linhas = tabela.querySelectorAll('tr');

  linhas.forEach(linha => {
    const textoLinha = linha.textContent.toLowerCase();
    linha.style.display = textoLinha.includes(filtro) ? '' : 'none';
  });


});

// --- Atualiza os contadores ao carregar a página ---
function carregarFuncionarios() {
  fetch('listarFuncionarios.php')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const tabela = document.getElementById('tabelaFuncionarios').querySelector('tbody');
        tabela.innerHTML = ''; // Limpa tabela antes de preencher
        data.funcionarios.forEach(f => {
          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td>${f.nome}</td>
            <td>${f.cpf}</td>
            <td>${f.rg}</td>
            <td>${f.nascimento}</td>
            <td>${f.genero}</td>
            <td>${f.endereco}</td>
            <td>${f.telefone}</td>
            <td>${f.email}</td>
            <td>${f.estado}</td>
            <td>${f.pis_pasep}</td>
            <td>${f.carteira}</td>
            <td>
              ${f.foto ? `<img src="uploads/${f.foto}" alt="Foto" style="width:40px; height:40px; object-fit:cover; border-radius: 50%;">` : ''}
            </td>
            <td style="text-align:center;">
              <img src="img/editar.png" alt="Editar" class="editar" style="width:20px; cursor:pointer; margin-right:8px;">
              <img src="img/lixeira.png" alt="Remover" class="remover" style="width:20px; cursor:pointer;">
            </td>
          `;
          tabela.appendChild(tr);
        });

        atualizarContadores();
      } else {
        console.error('Erro ao carregar funcionários');
      }
    })
    .catch(err => console.error('Erro na requisição listarFuncionarios:', err));
}

window.addEventListener('load', () => {
  carregarFuncionarios();
  atualizarContadores();  
  // Pode deixar só o carregarFuncionarios chamar essa função após carregar dados
});

