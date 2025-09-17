<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerService
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->configure();
    }

    private function configure(): void
    {
        // Configurações do Servidor SMTP
        $this->mailer->isSMTP();
        $this->mailer->Host       = $_ENV['MAIL_HOST'];
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $_ENV['MAIL_USERNAME'];
        $this->mailer->Password   = $_ENV['MAIL_PASSWORD'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = $_ENV['MAIL_PORT'];
        $this->mailer->CharSet    = 'UTF-8';
    }

    /**
     * @throws Exception
     */
    public function sendSubmissionEmail(array $data): void
    {
        // Remetente e Destinatário
        $this->mailer->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
        $this->mailer->addAddress($_ENV['MAIL_TO_ADDRESS']);

        // Conteúdo do E-mail
        $this->mailer->isHTML(true);
        $this->mailer->Subject = 'Novo currículo recebido: ' . $data['name']; // Correção: de 'nome' para 'name'
        $this->mailer->Body    = $this->buildEmailBody($data);
        $this->mailer->AltBody = $this->buildEmailAltBody($data);
        
        // O currículo não é anexado para evitar problemas de entrega e tamanho.
        // O e-mail informa que o arquivo está disponível no sistema.

        $this->mailer->send();
    }
    
    private function buildEmailBody(array $data): string
    {
        $body = "<h1>Novo Currículo Recebido</h1>";
        $body .= "<p>Um novo candidato enviou um currículo através do site.</p>";
        $body .= "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse;'>";
        $body .= "<tr><td style='background-color: #f2f2f2;'><strong>Nome:</strong></td><td>" . htmlspecialchars($data['name']) . "</td></tr>";
        $body .= "<tr><td style='background-color: #f2f2f2;'><strong>Email:</strong></td><td>" . htmlspecialchars($data['email']) . "</td></tr>";
        $body .= "<tr><td style='background-color: #f2f2f2;'><strong>Telefone:</strong></td><td>" . htmlspecialchars($data['phone']) . "</td></tr>";
        $body .= "<tr><td style='background-color: #f2f2f2;'><strong>Cargo Desejado:</strong></td><td>" . htmlspecialchars($data['desired_position']) . "</td></tr>";
        $body .= "<tr><td style='background-color: #f2f2f2;'><strong>Escolaridade:</strong></td><td>" . htmlspecialchars($data['education_level']) . "</td></tr>";
        $body .= "<tr><td style='background-color: #f2f2f2;'><strong>Observações:</strong></td><td>" . nl2br(htmlspecialchars($data['observations'])) . "</td></tr>";
        $body .= "<tr><td style='background-color: #f2f2f2;'><strong>Data de Envio:</strong></td><td>" . htmlspecialchars($data['submitted_at']) . "</td></tr>";
        $body .= "<tr><td style='background-color: #f2f2f2;'><strong>IP:</strong></td><td>" . htmlspecialchars($data['ip_address']) . "</td></tr>";
        $body .= "</table>";
        $body .= "<p>O arquivo do currículo foi salvo no sistema e pode ser acessado internamente.</p>";

        return $body;
    }

    private function buildEmailAltBody(array $data): string
    {
        $altBody = "Novo Currículo Recebido\n\n";
        $altBody .= "Nome: " . $data['name'] . "\n";
        $altBody .= "Email: " . $data['email'] . "\n";
        $altBody .= "Telefone: " . $data['phone'] . "\n";
        $altBody .= "Cargo Desejado: " . $data['desired_position'] . "\n";
        $altBody .= "Escolaridade: " . $data['education_level'] . "\n";
        $altBody .= "Observações: " . $data['observations'] . "\n";
        $altBody .= "Data de Envio: " . $data['submitted_at'] . "\n";
        $altBody .= "IP: " . $data['ip_address'] . "\n\n";
        $altBody .= "O arquivo do currículo foi salvo no sistema.";
        
        return $altBody;
    }
}

