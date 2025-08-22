<?php

namespace app\controllers\api;

use app\database\DBQuery;

class BaseApiController
{
    public $db;

    public function __construct()
    {
        $this->db = new DBQuery;
    }

    protected function apiResponse(
        string $status,
        $data = null,
        string $message = '',
        int $code = 200,
        array $warnings = [],
        array $errors = []
    ): array {
        $response = [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        if (!empty($warnings)) {
            $response['warnings'] = $warnings;
        }

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return $response;
    }

    protected function handleApiResponse(callable $callback)
    {
        try {
            $result = $callback();

            $response = $this->apiResponse(
                'success',
                $result['data'] ?? null,
                $result['message'] ?? 'Request processed successfully.',
                $result['code'] ?? 200,
                $result['warnings'] ?? [],
                $result['errors'] ?? []
            );

        } catch (ValidationException $ve) {
            $response = $this->apiResponse(
                'error',
                null,
                $ve->getMessage(),
                $ve->getCode(),
                [],
                $ve->getErrors()
            );

        } catch (\Throwable $th) {
            $response = $this->apiResponse(
                'error',
                null,
                $th->getMessage(),
                500
            );
        }

        http_response_code($response['code'] ?? 200);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }


}