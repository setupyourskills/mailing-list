<?php
declare(strict_types=1);

class Validator
{
    public static function validateName(string $name): string
    {
        $name = trim($name);

        if (empty($name) || strlen($name) < 2 || strlen($name) > 100) {
            throw new Exception(Messages::INVALID_NAME);
        }

        return $name;
    }

    public static function validateEmail(string $email): string
    {
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

        if (!$email) {
            throw new Exception(Messages::INVALID_EMAIL);
        }

        return $email;
    }
}
