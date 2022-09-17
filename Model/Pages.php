<?php

namespace Model;

class Pages
{
    private $db;
    private $connect;

    public function __construct()
    {
        $this->db = new \Core\DB();
        $this->connect = $this->db->connect;
    }

    public function getAllPages(): array
    {
        $sql = "SELECT * FROM pages";
        $query = $this->connect->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deletePage(int $id): void
    {
        $sql = "DELETE FROM pages WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
    }

    public function createPage(array $pageData): void
    {
        $title = htmlspecialchars(trim($pageData['page_title_data']));
        $content = htmlspecialchars(trim($pageData['page_content_data']));
        $urlKey = htmlspecialchars(trim($pageData['page_url_key_data']));
        $matches = [];
        $validateUrlKey = preg_match("/((\w?)*_?(\w?)*)/", "$urlKey", $matches);

        $sql = "INSERT INTO pages (title, content, url_key) VALUES (:title, :content, :url_key)";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':title', $title);
        $query->bindParam(':content', $content);
        $query->bindParam(':url_key', $urlKey);
        $query->execute();
    }

    public function editPage(array $pageData, int $id): void
    {
        $title = htmlspecialchars(trim($pageData['page_title_data']));
        $content = htmlspecialchars(trim($pageData['page_content_data']));
        $urlKey = htmlspecialchars(trim($pageData['page_url_key_data']));

        $sql = "UPDATE pages SET title = :title, content = :content, url_key = :url_key WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':title', $title);
        $query->bindParam(':content', $content);
        $query->bindParam(':url_key', $urlKey);
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
    }

    public function validateContent(array &$fields): array
    {
        $errors = [];
        $title = htmlspecialchars(trim($fields['page_title_data']));
        $urlKey = htmlspecialchars(trim($fields['page_url_key_data']));
        $content = htmlspecialchars(trim($fields['page_content_data']));

        if (strlen($title) <= 4 || strlen($title) >= 150) {
            $errors[] = "Title length must be from 4 to 150 chars!";
        }
        if (strlen($urlKey) <= 3 || strlen($urlKey) >= 50) {
            $errors[] = "Url key length must be from 3 to 50 chars!";
        }
        if (strlen($content) <= 10 || strlen($urlKey) >= 20000) {
            $errors[] = "Title length must be from 10 to 20000 chars!";
        }

        return $errors;
    }

    public function getPageData(string $urlKey): array
    {
        $sql = "SELECT * FROM pages WHERE url_key = :url_key";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':url_key', $urlKey);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

}