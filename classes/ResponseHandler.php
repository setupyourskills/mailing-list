<?php
declare(strict_types=1);

class ResponseHandler
{
    public static function success(string $message, array $data = []): void
    {
        echo json_encode(array_merge([
            'success' => true,
            'message' => $message
        ], $data));
    }

    public static function error(string $message, int $code = 400): void
    {
        http_response_code($code);

        echo json_encode([
            'success' => false,
            'message' => $message
        ]);
    }
}
