// Aguarda o carregamento completo da página
document.addEventListener('DOMContentLoaded', function() {
    // Seleção dos elementos dos botões
    const funcionarioBtn = document.getElementById('funcionarioBtn');
    const rhBtn = document.getElementById('rhBtn');
    
    // Função para lidar com clique no botão Funcionário
    function handleFuncionarioClick() {
        console.log('Botão Funcionário clicado');
        
        funcionarioBtn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            funcionarioBtn.style.transform = '';
        }, 150);

        // Redireciona para a página de login do funcionário
        window.location.href = '/augebit/login/index.php';
    }
    
    // Função para lidar com clique no botão RH
    function handleRHClick() {
        console.log('Botão RH clicado');
        
        rhBtn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            rhBtn.style.transform = '';
        }, 150);

        // Redireciona para a página inicial do RH
        window.location.href = '/augebit/inicial/index.php';
    }
    
    // Adiciona os event listeners
    funcionarioBtn.addEventListener('click', handleFuncionarioClick);
    rhBtn.addEventListener('click', handleRHClick);
    
    // Efeitos de hover
    const buttons = [funcionarioBtn, rhBtn];
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
        });
        button.addEventListener('mouseleave', function() {
            this.style.transition = 'all 0.3s ease';
        });
    });
    
    // Animações de entrada
    function addPageAnimations() {
        const title = document.querySelector('.title');
        const subtitle = document.querySelector('.subtitle');
        const profileSelection = document.querySelector('.profile-selection');
        const illustration = document.querySelector('.illustration-container');
        
        setTimeout(() => {
            title.style.opacity = '1';
            title.style.transform = 'translateY(0)';
        }, 100);
        setTimeout(() => {
            subtitle.style.opacity = '1';
            subtitle.style.transform = 'translateY(0)';
        }, 300);
        setTimeout(() => {
            profileSelection.style.opacity = '1';
            profileSelection.style.transform = 'translateY(0)';
        }, 500);
        setTimeout(() => {
            illustration.style.opacity = '1';
            illustration.style.transform = 'translateX(0)';
        }, 700);
    }

    addPageAnimations();

    // Log para debugging/analytics
    funcionarioBtn.addEventListener('click', () => logUserSelection('Funcionário'));
    rhBtn.addEventListener('click', () => logUserSelection('RH'));

    function logUserSelection(selection) {
        console.log(`Usuário selecionou: ${selection}`);
        console.log(`Timestamp: ${new Date().toISOString()}`);
    }
});
