<?php

declare(strict_types=1);

namespace Model;

use Core\DB;
use PDO;

class Messages
{
    private $db;
    private $connect;

    public function __construct()
    {
        $this->db = new DB();
        $this->connect = $this->db->connect;
    }

    public function getAllMessages(): array
    {
        $sql = "SELECT * FROM messages ORDER BY id DESC";
        $query = $this->connect->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessage(int $id): array
    {
        $sql = "SELECT * FROM messages WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setMessage(array $fields, string $username): bool
    {
        $sql = "INSERT into messages VALUES (null, :name, :title, :message, now(), '0')";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':name', $username);
        $query->bindParam(':title', $fields['title']);
        $query->bindParam(':message', $fields['message']);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return is_bool($result) ? $result : false;
    }

    public function deleteMessage(int $id): bool
    {
        $sql = "DELETE FROM messages WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return (bool)$query->rowCount();
    }

    public function editMessage(array $messageData, int $id): void
    {
        $title = htmlspecialchars(trim($messageData['title']));
        $message = htmlspecialchars(trim($messageData['message']));

        $sql = "UPDATE messages SET title = :title, message = :message WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':title', $title);
        $query->bindParam(':message', $message);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
    }

    public function messagesValidate(array &$fields): array
    {
        $errors = [];
        $titleLen = mb_strlen($fields['title'], 'UTF-8');
        $messageLen = mb_strlen($fields['message'], 'UTF-8');

        if ($messageLen < 5){
            $errors[] = 'Message length must be not less then 5 characters!';
        }
        if ($messageLen > 20000) {
            $errors[] = 'The text cannot exceed more than 20,000 characters';
        }

        if ($titleLen < 5 || $titleLen > 140){
            $errors[] = 'Title length must be from 5 to 140 chars!';
        }

        $fields['title'] = htmlspecialchars($fields['title']);
        $fields['message'] = htmlspecialchars($fields['message']);

        return $errors;
    }

    public function executeOptionAction(string $action, array $selectedItems)
    {
        switch ($action) {
            case 'delete':
                foreach ($selectedItems as $item) {
                    $this->deleteMessage((int)$item);
                }
                break;
            case 'edit':
        }
    }
}
