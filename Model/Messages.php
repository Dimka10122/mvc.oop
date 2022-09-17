<?php

declare(strict_types=1);

namespace Model;

class Messages
{
    private $db;
    private $connect;

    public function __construct()
    {
        $this->db = new \Core\DB();
        $this->connect = $this->db->connect;
    }

    public function validatePage($page)
    {
        if( $page <= 1 ){
            $page = 1;
        }
        return $page;
    }

    public function getAllMessages(): array
    {
        $sql = "SELECT * FROM messages";
        $query = $this->connect->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getMessage(int $id): array
    {
        $sql = "SELECT * FROM messages WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function setMessage(array $fields): bool
    {
        $sql = "INSERT into messages VALUES (null, :name, :title, :message, now(), '0')";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':name', $fields['name']);
        $query->bindParam(':title', $fields['title']);
        $query->bindParam(':message', $fields['message']);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        return is_bool($result) ? $result : false;
    }

    public function deleteMessage(int $id): bool
    {
        $sql = "DELETE FROM messages WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
        return (bool)$query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function editMessage(string $title, string $message, int $id): bool
    {
        $sql = "UPDATE messages SET title = :title, message = :message WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':title', $title);
        $query->bindParam(':message', $message);
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
        return (bool)$query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function messagesValidate(array &$fields): array
    {
        $errors = [];
        $nameLen = mb_strlen($fields['name'], 'UTF-8');
        $titleLen = mb_strlen($fields['title'], 'UTF-8');

        if(mb_strlen($fields['message'], 'UTF-8') < 2){
            $errors[] = __('Message length must be not less then 2 characters!');
        }
        if($nameLen < 2 || $nameLen > 140){
            $errors[] = __('Name must be from 2 to 140 chars!');
        }
        if($titleLen < 10 || $titleLen > 140){
            $errors[] = __('Title must be from 10 to 140 chars!');
        }

        $fields['name'] = htmlspecialchars($fields['name']);
        $fields['title'] = htmlspecialchars($fields['title']);
        $fields['message'] = htmlspecialchars($fields['message']);

        return $errors;
    }
}
