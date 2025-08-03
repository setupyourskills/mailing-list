<?php

declare(strict_types=1);

/**
 * Handles HTTP responses for API endpoints.
 *
 * Provides standardized methods for sending JSON success and error responses.
 */
class ResponseHandler
{
    /**
     * Send a success response as JSON.
     *
     * @param string $message The success message to return.
     * @param array $data Additional data to include in the response.
     * @return void
     */
    public static function success(string $message, array $data = []): void
    {
        // Send the success response
        echo json_encode(array_merge([
            'success' => true,
            'message' => $message
        ], $data));
    }

    /**
     * Send an error response as JSON with a specific HTTP status code.
     *
     * @param string $message The error message to return.
     * @param int $code The HTTP status code (default: 400).
     * @return void
     */
    public static function error(string $message, int $code = 400): void
    {
        // Set the HTTP status code
        http_response_code($code);

        // Send the error response
        echo json_encode([
            'success' => false,
            'message' => $message
        ]);
    }
}
