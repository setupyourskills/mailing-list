<?php
declare(strict_types=1);

require_once "../../secrets/db_config.php";

require_once "classes/Messages.php";
require_once "classes/Validator.php";
require_once "classes/Database.php";
require_once "classes/ResponseHandler.php";

header("Content-Type: application/json");

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception(Messages::METHOD_NOT_ALLOWED, 405);
    }

    $name = Validator::validateName($_POST["name"] ?? '');
    $email = Validator::validateEmail($_POST["email"] ?? '');

    $db = new Database();

    if ($db->emailExists($email)) {
        throw new Exception(Messages::EMAIL_ALREADY_EXISTS);
    }

    $id = $db->insertUser($name, $email);

    ResponseHandler::success(Messages::USER_ADDED_SUCCESS, ["id" => $id]);
} catch (PDOException $e) {
    error_log(Messages::DATABASE_ERROR_LOG . $e->getMessage());
    ResponseHandler::error(Messages::DATABASE_ERROR, 500);
} catch (Exception $e) {
    $code = $e->getCode() ?: 400;
    ResponseHandler::error($e->getMessage(), $code);
}
