
  function atualizarProgressoVisual(container, valor, cor) {
    valor = Math.max(0, Math.min(100, valor));
    container.style.background = `conic-gradient(${cor} ${valor}%, #eee ${valor}%)`;
  }

  // 1. Para o .circle-bg principal (curso concluído)
  const circleInput = document.querySelector('.percentage-input');
  const circle = document.querySelector('.circle-bg');
  if (circle && circleInput) {
    atualizarProgressoVisual(circle, circleInput.value, '#6366f1');
    circleInput.addEventListener('input', () => {
      atualizarProgressoVisual(circle, circleInput.value, '#6366f1');
    });
  }

  // 2. Para todos os .course-progress (cursos atuais)
  const progressInputs = document.querySelectorAll('.progress-input');
  const progressCircles = document.querySelectorAll('.course-progress');

  progressInputs.forEach((input, index) => {
    const circle = progressCircles[index];
    atualizarProgressoVisual(circle, input.value, '#6366f1');
    input.addEventListener('input', () => {
      atualizarProgressoVisual(circle, input.value, '#6366f1');
    });

    
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