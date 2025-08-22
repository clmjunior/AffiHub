<?php

namespace app\database;

use mysqli;
use mysqli_result;

class DBQuery
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = DBConn::getConnection();
    }

    private function query(string $sql, array $params = []): mysqli_result|bool
    {
        if (!empty($params)) {
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new \Exception("Erro ao preparar SQL: " . $this->conn->error);
            }

            // Tipos dos parâmetros: 's' para string, 'i' para int, etc.
            $types = str_repeat('s', count($params)); // Simples, ajustável depois
            $stmt->bind_param($types, ...$params);

            $stmt->execute();
            $result = $stmt->get_result();

            return $result ?: true;
        }

        return $this->conn->query($sql);
    }

    public function hasRows(string $sql, array $params = []): bool
    {
        $result = $this->query($sql, $params);
        return $result instanceof mysqli_result && $result->num_rows > 0;
    }

    public function countRows(string $sql, array $params = []): int
    {
        $result = $this->query($sql, $params);
        return $result instanceof mysqli_result ? $result->num_rows : 0;
    }

    public function select(string $sql, array $params = []): array
    {
        $result = $this->query($sql, $params);
        return $result instanceof mysqli_result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function insert(string $sql, array $params = []): int
    {
        $this->query($sql, $params);
        return $this->conn->insert_id;
    }

    public function update(string $sql, array $params = []): int
    {
        $this->query($sql, $params);
        return $this->conn->affected_rows;
    }

    public function delete(string $sql, array $params = []): int
    {
        $this->query($sql, $params);
        return $this->conn->affected_rows;
    }
}
