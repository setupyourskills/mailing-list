<?php

declare(strict_types=1);

/**
 * Provides static methods for validating user input.
 *
 * Includes validation for user names and email addresses.
 */
class Validator
{
    /**
     * Validate a user name.
     *
     * @param string $name The name to validate.
     * @return string The validated and trimmed name.
     * @throws Exception If the name is invalid.
     */
    public static function validateName(string $name): string
    {
        // Remove leading and trailing whitespace
        $name = trim($name);

        // Check if the name is valid
        if (empty($name) || strlen($name) < 2 || strlen($name) > 100) {
            throw new Exception(Messages::INVALID_NAME);
        }

        return $name;
    }

    /**
     * Validate an email address.
     *
     * @param string $email The email address to validate.
     * @return string The validated and trimmed email address.
     * @throws Exception If the email address is invalid.
     */
    public static function validateEmail(string $email): string
    {
        // Use filter_var() to validate the email which was trimmed
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

        // Check if the email is valid
        if (!$email) {
            throw new Exception(Messages::INVALID_EMAIL);
        }

        return $email;
    }
}
