<?php

namespace App\Service;

use App\Repository\SubmissionRepository;
use Rakit\Validation\Validator;
use Exception;

class SubmissionService
{
    private SubmissionRepository $repository;
    private MailerService $mailer;

    public function __construct()
    {
        $this->repository = new SubmissionRepository();
        $this->mailer = new MailerService();
    }

    public function handleSubmission(array $data, ?array $file): array
    {
        // 1. Validação dos dados
        [$errors, $validatedData] = $this->validate($data, $file);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        // 2. Upload do arquivo
        $filePath = $this->uploadFile($file);
        if (!$filePath) {
            return ['success' => false, 'errors' => ['arquivo' => 'Ocorreu um erro ao fazer o upload do arquivo.']];
        }

        // 3. Preparar dados para o banco (Mapeando nomes do formulário para nomes do banco)
        $submissionData = [
            'name' => $validatedData['nome'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['telefone'],
            'desired_position' => $validatedData['cargo_desejado'],
            'education_level' => $validatedData['escolaridade'],
            'observations' => $validatedData['observacoes'],
            'file_path' => $filePath,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN',
            'submitted_at' => date('Y-m-d H:i:s')
        ];

        // 4. Salvar no banco de dados
        try {
            $this->repository->save($submissionData);
        } catch (Exception $e) {
            // Em caso de falha, remove o arquivo que foi salvo
            unlink($filePath);
            error_log('DB Error: ' . $e->getMessage());
            return ['success' => false, 'errors' => ['geral' => 'Não foi possível salvar os dados. Tente novamente.']];
        }
        
        // 5. Enviar e-mail
        try {
            $this->mailer->sendSubmissionEmail($submissionData);
        } catch (Exception $e) {
            // Opcional: decidir o que fazer se o e-mail falhar. 
            // Por enquanto, apenas logamos o erro, pois o currículo já foi salvo.
            error_log('Mail Error: ' . $e->getMessage());
        }

        return ['success' => true];
    }

    private function validate(array $data, ?array $file): array
    {
        $validator = new Validator;

        // Adiciona as regras de validação para o arquivo
        $data['arquivo'] = $file;
        
        $validation = $validator->make($data, [
            'nome'             => 'required|alpha_spaces',
            'email'            => 'required|email',
            'telefone'         => 'required',
            'cargo_desejado'   => 'required',
            'escolaridade'     => 'required|in:Ensino Médio,Técnico,Graduação Incompleta,Graduação Completa,Pós-graduação',
            'observacoes'      => 'present', // 'present' garante que a chave existe, mesmo que vazia
            'arquivo'          => 'required|uploaded_file:0,1M,doc,docx,pdf',
        ]);
        
        $validation->setMessages([
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O e-mail informado não é válido.',
            'in' => 'O valor selecionado para :attribute é inválido.',
            'uploaded_file' => 'Arquivo inválido. Verifique o tamanho (máx 1MB) e o formato (.doc, .docx, .pdf).'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            return [$validation->errors()->toArray(), []];
        }

        return [[], $validation->getValidatedData()];
    }

    private function uploadFile(?array $file): ?string
    {
        if ($file === null || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeFilename = uniqid('cv_', true) . '.' . $fileExtension;
        $destination = $uploadDir . $safeFilename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $destination;
        }

        return null;
    }
}

