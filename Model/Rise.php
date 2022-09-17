<?php

declare(strict_types=1);

namespace Model;

class Rise
{
    private $db;
    private $connect;

    public function __construct()
    {
        $this->db = new \Core\DB();
        $this->connect = $this->db->connect;
    }

    public function getAllRequests(): array
    {
        $sql = "SELECT login, request_role, state, users.id FROM requests LEFT JOIN users ON users.id = requests.user_id";
        $query = $this->connect->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function serveRequest(int $userId, int $action): void
    {
        $sql = "UPDATE requests SET state = :state_action WHERE user_id = :user_id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':state_action', $action, \PDO::PARAM_INT);
        $query->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $query->execute();
    }

    public function serveRequestMultiple(int $action): void
    {
        $sql = "UPDATE requests SET state = :state_action";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':state_action', $action, \PDO::PARAM_INT);
        $query->execute();
    }

    public function checkSendRequestYet(string $username): bool
    {
        $sql = "SELECT * FROM requests LEFT JOIN users ON requests.user_id = users.id WHERE users.login = :login";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':login', $username);
        $query->execute();
        return (bool)$query->fetch(\PDO::FETCH_ASSOC);
    }

    //?????
    public function sendRequestRise(string $id, string $username): void
    {
        $queryString = sprintf(
            "INSERT INTO requests (user_id, request_role, state) SELECT id, '%s', '%s' FROM users WHERE users.login = '%s'",
            $id,
            0,
            $username
        );
        $sql = "INSERT INTO requests (user_id, request_role, state) SELECT id, :role_id, :state FROM users WHERE users.login = :login";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role_id', $id);
//        $query->bindParam(':state', 0);
        $query->bindParam(':login', $username);
        $query->execute();
    }

    public function convertRole(int $roleId): array
    {
        $sql = "SELECT role_name FROM roles WHERE id = :role_id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role_id', $roleId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}