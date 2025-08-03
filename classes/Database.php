<?php
declare(strict_types=1);

class Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::ATTR_EMULATE_PREPARES => false,
              PDO::ATTR_TIMEOUT => 5
            ]
        );
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);

        return $stmt->fetchColumn() > 0;
    }

    public function insertUser(string $name, string $email): int
    {
        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $result = $stmt->execute([$name, $email]);

            if (!$result) {
                throw new Exception(Messages::INSERT_ERROR);
            }

            $id = $this->pdo->lastInsertId();
            $this->pdo->commit();

            return $id;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
