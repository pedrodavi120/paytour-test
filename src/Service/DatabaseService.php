<?php

namespace App\Service;

use PDO;
use PDOException;

class DatabaseService
{
    private static ?PDO $instance = null;

    /**
     * Retorna uma instância Singleton da conexão PDO.
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $db = $_ENV['DB_DATABASE'];
            $user = $_ENV['DB_USERNAME'];
            $pass = $_ENV['DB_PASSWORD'];
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Em um ambiente de produção, logar o erro em vez de exibi-lo.
                error_log("Connection failed: " . $e->getMessage());
                // Lançar uma exceção mais genérica para não expor detalhes do DB.
                throw new PDOException("Não foi possível conectar ao banco de dados.", (int)$e->getCode());
            }
        }

        return self::$instance;
    }
}
