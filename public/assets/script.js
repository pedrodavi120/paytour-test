// JavaScript para validações no lado do cliente e interatividade
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#resume-form');
    const fileInput = document.querySelector('#arquivo');
    const fileError = document.querySelector('#file-error-message');

    if (form) {
        form.addEventListener('submit', function (event) {
            // Desabilitar o botão de submit para evitar envios duplicados
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Enviando...';
        });
    }

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                const file = this.files[0];
                const allowedExtensions = ['pdf', 'doc', 'docx'];
                const fileExtension = file.name.split('.').pop().toLowerCase();
                const maxSizeInBytes = 1 * 1024 * 1024; // 1MB

                let errorMessage = '';

                if (!allowedExtensions.includes(fileExtension)) {
                    errorMessage = 'Tipo de arquivo inválido. Apenas .pdf, .doc e .docx são permitidos.';
                } else if (file.size > maxSizeInBytes) {
                    errorMessage = 'O arquivo é muito grande. O tamanho máximo é de 1MB.';
                }

                if (errorMessage) {
                    fileError.textContent = errorMessage;
                    fileError.classList.remove('hidden');
                    this.value = ''; // Limpa o input
                } else {
                    fileError.textContent = '';
                    fileError.classList.add('hidden');
                }
            }
        });
    }
});
