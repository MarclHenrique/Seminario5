        function closeForm() {
            // Seleciona o contêiner do formulário
            var formContainer = document.querySelector('.container');
            
            // Oculta o contêiner do formulário
            formContainer.style.display = 'none';
            
            // Exibe uma mensagem de alerta
            alert("Formulário fechado.");
        }


    function closeForm() {
        // Exibe uma mensagem de alerta
        alert("Formulário fechado.");
        
        // Tenta fechar a janela atual
        if (window.self!== window.top) {
            window.top.close();
        } else {
            // Se não for possível fechar a janela, oculta o formulário
            var formContainer = document.querySelector('.container');
            formContainer.style.display = 'none';
        }
    }
