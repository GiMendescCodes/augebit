
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

function atualizarContadores() {
  fetch("contarGeneros.php")
    .then(response => response.json())
    .then(data => {
      document.getElementById("homens").textContent = data.homens.toString().padStart(2, '0');
      document.getElementById("mulheres").textContent = data.mulheres.toString().padStart(2, '0');
      document.getElementById("totalFuncionarios").textContent = data.total.toString().padStart(2, '0');
    })
    .catch(error => {
      console.error("Erro ao buscar contadores:", error);
    });
}

// Chama ao carregar a página
document.addEventListener("DOMContentLoaded", () => {
  atualizarContadores();

  // Atualiza novamente após envio do formulário (opcional)
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
      const f = data.dados_bancarios;

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${f.nome}</td>
        <td>${f.banco}</td>
        <td>${f.agencia}</td>
        <td>${f.tipo_corrente_poupanca}</td>
        <td>${f.tipo_conta}</td>
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
    formAtualizarFuncionario.banco.value = celulas[1].textContent.trim();
    formAtualizarFuncionario.agencia.value = celulas[2].textContent.trim();
    formAtualizarFuncionario.tipo_corrente_poupanca.value = celulas[3].textContent.trim();
    formAtualizarFuncionario.tipo_conta.value = celulas[4].textContent.trim();

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
    console.log("Resposta do PHP:", data);
    if (data.success) {
    const f = data.dados_bancarios; 

      linhaEditando.cells[0].textContent = f.nome;
      linhaEditando.cells[1].textContent = f.banco;
      linhaEditando.cells[2].textContent = f.agencia;
      linhaEditando.cells[3].textContent = f.tipo_corrente_poupanca;
      linhaEditando.cells[4].textContent = f.tipo_conta;

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
    // Para remover, vamos usar o nome completo como identificador, mas idealmente deveria ser um ID único.
    const nome = linha.cells[0].textContent.trim();
    console.log('Nome enviado:', nome);

    if (confirm(`Confirma exclusão do funcionário ${nome}?`)) {
      fetch('deletarFuncionario.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `nome=${encodeURIComponent(nome)}`
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
        tabela.innerHTML = ''; // Limpa tabela antes de preencher
        data.dados_bancarios.forEach(f => {
          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td>${f.nome}</td>
            <td>${f.banco}</td>
            <td>${f.agencia}</td>
            <td>${f.tipo_corrente_poupanca}</td>
            <td>${f.tipo_conta}</td>
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
  atualizarContadores();  // Pode deixar só o carregarFuncionarios chamar essa função após carregar dados
});

