<?php

namespace App\Controllers;

class ContactController extends Controller
{
    /**
     * Exibe o formulário de contato
     */
    public function index(): string
    {
        $data = [
            'title' => 'Contato',
            'description' => 'Entre em contato comigo',
            'contact' => [
                'email' => 'dorianc.vieira@gmail.com',
                'phone' => '(48) 99186-9704',
                'location' => 'Brasil',
            ]
        ];

        return $this->render('contact.twig', $data);
    }

    /**
     * Processa o envio do formulário de contato
     */
    public function send(array $vars): string
    {
        // Validar dados
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';

        $errors = [];

        if (empty($name)) {
            $errors[] = 'O nome é obrigatório';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email inválido';
        }

        if (empty($subject)) {
            $errors[] = 'O assunto é obrigatório';
        }

        if (empty($message)) {
            $errors[] = 'A mensagem é obrigatória';
        }

        if (!empty($errors)) {
            return $this->render('contact.twig', [
                'title' => 'Contato',
                'errors' => $errors,
                'old' => $_POST
            ]);
        }

        // Enviar email (implementação básica)
        $success = $this->sendEmail($name, $email, $subject, $message);

        if ($success) {
            return $this->render('contact.twig', [
                'title' => 'Contato',
                'success' => 'Mensagem enviada com sucesso! Entrarei em contato em breve.'
            ]);
        } else {
            return $this->render('contact.twig', [
                'title' => 'Contato',
                'errors' => ['Erro ao enviar mensagem. Tente novamente mais tarde.'],
                'old' => $_POST
            ]);
        }
    }

    /**
     * Envia email (implementação simples)
     * Em produção, considere usar bibliotecas como PHPMailer ou SwiftMailer
     */
    private function sendEmail(string $name, string $email, string $subject, string $message): bool
    {
        $to = $this->env['MAIL_TO'] ?? 'dorianc.vieira@gmail.com';
        $from = "From: {$name} <{$email}>";
        $emailSubject = "Portfolio: {$subject}";
        $emailBody = "Nome: {$name}\n";
        $emailBody .= "Email: {$email}\n\n";
        $emailBody .= "Mensagem:\n{$message}";

        // Em desenvolvimento, apenas simule o envio
        if ($this->env['APP_ENV'] === 'development') {
            // Salvar em arquivo de log para teste
            $logDir = __DIR__ . '/../../storage/logs';
            if (!is_dir($logDir)) {
                mkdir($logDir, 0755, true);
            }
            file_put_contents(
                $logDir . '/emails.log',
                "[" . date('Y-m-d H:i:s') . "]\n{$emailBody}\n\n",
                FILE_APPEND
            );
            return true;
        }

        // Em produção, usar mail() ou biblioteca externa
        return mail($to, $emailSubject, $emailBody, $from);
    }
}
