<?php

// Autoloader do Composer
require __DIR__ . '/../vendor/autoload.php';

use App\Controller\FormController;

// Inicia uma sessão para armazenar mensagens de feedback (erros, sucesso)
session_start();

// Carrega as variáveis de ambiente do arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Roteamento simples
$controller = new FormController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se a requisição for POST, processa o formulário
    $controller->process();
} else {
    // Se for GET, apenas exibe o formulário
    $controller->show();
}
