<?php

namespace app\controllers\api;

use Exception;

class ValidationException extends Exception
{
    private array $errors;

    public function __construct(array $errors, string $message = 'validation failed', int $code = 422)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
