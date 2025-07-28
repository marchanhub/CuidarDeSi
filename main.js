// Form validation
(function() {
    'use strict';
    
    // Função para validar email
    function isValidEmail(email) {
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(email);
    }
    
    // Função para validar telefone
    function isValidPhone(phone) {
        const phoneRegex = /^[0-9+\s\-\(\)]{9,15}$/;
        return phoneRegex.test(phone);
    }
    
    // Função para validar arquivo
    function isValidFile(file) {
        if (!file) return true; // Arquivo opcional
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        return allowedTypes.includes(file.type) && file.size <= maxSize;
    }
    
    // Função para mostrar loading
    function showLoading(button) {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
        button.disabled = true;
        return originalText;
    }
    
    // Função para restaurar botão
    function restoreButton(button, originalText) {
        button.innerHTML = originalText;
        button.disabled = false;
    }
    
    window.addEventListener('load', function() {
        const forms = document.getElementsByClassName('needs-validation');
        
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();
                
                // Validação personalizada
                let isValid = true;
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = showLoading(submitButton);
                
                // Validar campos específicos
                const emailInputs = form.querySelectorAll('input[type="email"]');
                emailInputs.forEach(input => {
                    if (input.value && !isValidEmail(input.value)) {
                        input.setCustomValidity('Por favor, insira um endereço de email válido.');
                        isValid = false;
                    } else {
                        input.setCustomValidity('');
                    }
                });
                
                const phoneInputs = form.querySelectorAll('input[type="tel"]');
                phoneInputs.forEach(input => {
                    if (input.value && !isValidPhone(input.value)) {
                        input.setCustomValidity('Por favor, insira um número de telefone válido.');
                        isValid = false;
                    } else {
                        input.setCustomValidity('');
                    }
                });
                
                const fileInputs = form.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    if (input.files.length > 0 && !isValidFile(input.files[0])) {
                        input.setCustomValidity('Por favor, selecione um arquivo válido (PDF, DOC, DOCX, máximo 5MB).');
                        isValid = false;
                    } else {
                        input.setCustomValidity('');
                    }
                });
                
                if (form.checkValidity() === false || !isValid) {
                    restoreButton(submitButton, originalText);
                    form.classList.add('was-validated');
                    return false;
                }
                
                // Se tudo estiver válido, enviar o formulário
                form.classList.add('was-validated');
                
                // Simular delay para mostrar loading
                setTimeout(() => {
                    form.submit();
                }, 1000);
            }, false);
        });
        
        // Validação em tempo real
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.classList.contains('was-validated')) {
                    if (this.checkValidity()) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                }
            });
        });
    }, false);
})(); 