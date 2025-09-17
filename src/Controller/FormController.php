<?php

namespace App\Controller;

use App\Service\SubmissionService;

class FormController
{
    /**
     * Exibe a página do formulário.
     */
    public function show(): void
    {
        // Extrai as mensagens da sessão para exibir na view
        $errors = $_SESSION['errors'] ?? [];
        $old_data = $_SESSION['old_data'] ?? [];
        $success_message = $_SESSION['success_message'] ?? null;

        // Limpa as mensagens da sessão após exibi-las
        unset($_SESSION['errors'], $_SESSION['old_data'], $_SESSION['success_message']);

        // Inclui o template do formulário
        require __DIR__ . '/../../templates/form.php';
    }

    /**
     * Processa os dados enviados pelo formulário.
     */
    public function process(): void
    {
        $data = $_POST;
        $file = $_FILES['arquivo'] ?? null;

        $submissionService = new SubmissionService();
        $result = $submissionService->handleSubmission($data, $file);

        if ($result['success']) {
            $_SESSION['success_message'] = "Currículo enviado com sucesso! Agradecemos o seu interesse.";
        } else {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old_data'] = $data; // Guarda os dados para preencher o formulário novamente
        }

        // Redireciona de volta para a página do formulário
        header('Location: /');
        exit();
    }
}
