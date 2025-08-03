<?php

declare(strict_types=1);

require_once "../../secrets/db_config.php"; // Load database configuration (credentials, DSN, etc.)

require_once "classes/Messages.php"; // Load application message constants
require_once "classes/Validator.php"; // Load input validation logic
require_once "classes/Database.php"; // Load database access and user management logic
require_once "classes/ResponseHandler.php"; // Load standardized JSON response handler

header("Content-Type: application/json"); // Set response type to JSON for API clients

try {
    // Only allow POST requests
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception(Messages::METHOD_NOT_ALLOWED, 405);
    }

    // Validate input data
    $name = Validator::validateName($_POST["name"] ?? '');
    $email = Validator::validateEmail($_POST["email"] ?? '');

    // Connect to the database
    $db = new Database();

    // Check for duplicate email
    if ($db->emailExists($email)) {
        throw new Exception(Messages::EMAIL_ALREADY_EXISTS);
    }

    // Send success response
    $id = $db->insertUser($name, $email);

    ResponseHandler::success(Messages::USER_ADDED_SUCCESS, ["id" => $id]);
} catch (PDOException $e) {
    // Log database errors and send generic error response
    error_log(Messages::DATABASE_ERROR_LOG . $e->getMessage());
    ResponseHandler::error(Messages::DATABASE_ERROR, 500);
} catch (Exception $e) {
    // Send error response with appropriate HTTP code
    $code = $e->getCode() ?: 400;
    ResponseHandler::error($e->getMessage(), $code);
}
