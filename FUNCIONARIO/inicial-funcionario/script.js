<<<<<<< HEAD

=======
// 1. Incluir Chart.js no HTML (exemplo):
// <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

// 2. Inicializar gráfico após o DOM carregar
window.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('graficoDesempenho')?.getContext('2d');
  if (!ctx) {
    console.warn('Canvas para gráfico não encontrado: #graficoDesempenho');
    return;
  }

  const data = {
    labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio'],
    datasets: [{
      label: 'Desempenho (%)',
      data: [75, 82, 90, 70, 88],
      backgroundColor: 'rgba(54, 162, 235, 0.5)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  };

  const options = {
    scales: {
      y: {
        beginAtZero: true,
        max: 100
      }
    }
  };

  const meuGrafico = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
  });

  // Função para atualizar visual do progresso circular
>>>>>>> b26db88 (up)
  function atualizarProgressoVisual(container, valor, cor) {
    valor = Math.max(0, Math.min(100, valor));
    container.style.background = `conic-gradient(${cor} ${valor}%, #eee ${valor}%)`;
  }

<<<<<<< HEAD
  // 1. Para o .circle-bg principal (curso concluído)
=======
  // Atualiza .circle-bg principal (curso concluído)
>>>>>>> b26db88 (up)
  const circleInput = document.querySelector('.percentage-input');
  const circle = document.querySelector('.circle-bg');
  if (circle && circleInput) {
    atualizarProgressoVisual(circle, circleInput.value, '#6366f1');
    circleInput.addEventListener('input', () => {
      atualizarProgressoVisual(circle, circleInput.value, '#6366f1');
    });
  }

<<<<<<< HEAD
  // 2. Para todos os .course-progress (cursos atuais)
=======
  // Atualiza todos os .course-progress (cursos atuais)
>>>>>>> b26db88 (up)
  const progressInputs = document.querySelectorAll('.progress-input');
  const progressCircles = document.querySelectorAll('.course-progress');

  progressInputs.forEach((input, index) => {
    const circle = progressCircles[index];
<<<<<<< HEAD
=======
    if (!circle) return;
>>>>>>> b26db88 (up)
    atualizarProgressoVisual(circle, input.value, '#6366f1');
    input.addEventListener('input', () => {
      atualizarProgressoVisual(circle, input.value, '#6366f1');
    });
<<<<<<< HEAD

    
  });
  
document.getElementById("adicionarJustificativa").addEventListener("click", function() {
    const confirmar = confirm("Criar um atalho para a aba ''Justificativas''?");
    
    if (confirmar) {
        // Mostrar a caixa de justificativas
        document.getElementById("caixaJustificativa").style.display = "flex"; // ou "block", depende do seu CSS

        // Esconder o botão de "+"
         document.getElementById("caixaAdicionar").style.display = "none";
        
    }
});

  // Redireciona automaticamente para index.php após 10 segundos (ou ajuste o tempo como quise
=======
  });

  // Evento botão "adicionarJustificativa"
  const btnAdicionar = document.getElementById("adicionarJustificativa");
  if (btnAdicionar) {
    btnAdicionar.addEventListener("click", () => {
      const confirmar = confirm("Criar um atalho para a aba ''Justificativas''?");
      if (confirmar) {
        const caixaJustificativa = document.getElementById("caixaJustificativa");
        const caixaAdicionar = document.getElementById("caixaAdicionar");
        if (caixaJustificativa) caixaJustificativa.style.display = "flex"; // ou block conforme CSS
        if (caixaAdicionar) caixaAdicionar.style.display = "none";
      }
    });
  }

  // Exemplo: redirecionar após 10s (descomente se precisar)
  /*
  setTimeout(() => {
    window.location.href = 'index.php';
  }, 10000);
  */
});
>>>>>>> b26db88 (up)
