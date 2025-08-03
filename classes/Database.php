<?php

declare(strict_types=1);

/**
 * Database operations for user management.
 *
 * Handles database connection and user-related operations using PDO.
 */
class Database
{
    private $pdo;

    /**
     * Initialize database connection with PDO.
     *
     * @throws PDOException If the database connection fails.
     */
    public function __construct()
    {
        // Connect to the database
        $this->pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions for errors
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch results as associative arrays
              PDO::ATTR_EMULATE_PREPARES => false, // Disable emulated prepared statements
              PDO::ATTR_TIMEOUT => 5 // Set a timeout of 5 seconds
            ]
        );
    }

    /**
     * Check if an email already exists in the users table.
     *
     * @param string $email The email to check.
     * @return bool True if the email exists, false otherwise.
     */
    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Insert a new user into the database.
     *
     * @param string $name The user's name.
     * @param string $email The user's email.
     * @return int The ID of the newly inserted user.
     * @throws Exception If the insertion fails.
     */
    public function insertUser(string $name, string $email): int
    {
        // Begin a transaction
        $this->pdo->beginTransaction();

        // Prepare and execute the SQL statement
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $result = $stmt->execute([$name, $email]);

            // Check if the insertion was successful
            if (!$result) {
                throw new Exception(Messages::INSERT_ERROR);
            }

            // Get the ID of the newly inserted user
            $id = $this->pdo->lastInsertId();
            $this->pdo->commit();

            return $id;
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
