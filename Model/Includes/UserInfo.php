<?php

namespace Model\Includes;

use Core\DB;
use PDO;

class UserInfo
{
    private $db;
    private $connect;
    public $userRoleValue;
    public $userInfoData;
    public $userPerms = [];

    public function __construct()
    {
        $this->db = new DB;
        $this->connect = $this->db->connect;

        $this->setUserData();
        $this->getAllUserPerms();
        $this->setUserView();
    }

    public function setUserData()
    {
        $this->userInfoData = (array)json_decode($_COOKIE['user_info']) ?? [];
        $secureUserInfoData = [];
        foreach ($this->userInfoData as $key => $value) {
            $secureUserInfoData[$key] = htmlspecialchars($value);
        }
        $this->userRoleValue = $secureUserInfoData['role'] ?? 0;
    }

    public function getAllUserPerms()
    {
        if ($this->userRoleValue) {
            $sql = "SELECT * FROM roles WHERE id = :id";
            $query = $this->connect->prepare($sql);
            $query->bindParam(':id', $this->userRoleValue, PDO::PARAM_INT);
            $query->execute();
            $userPermsJson = $query->fetch(PDO::FETCH_ASSOC)["permissions"];
            $this->userPerms = json_decode($userPermsJson) ?? [];
            return;
        }
        $this->userPerms = [];
    }

    public function setUserView(): void
    {
        if (!empty($this->userInfoData)) {
            if ($_SESSION["is_user_view"] == 'LOGGED') {
                return;
            }
            if (!$_SESSION["is_user_view"]) {
                $sql = "INSERT INTO visits (visit_time) VALUES (NOW())";
                $query = $this->connect->prepare($sql);
                $query->execute();
                $_SESSION["is_user_view"] = 'LOGGED';
            }
        }
    }

    public function canUser(string $perm, string $secondPerm = ''): bool
    {
        return !in_array($perm, $this->userPerms) ? in_array($secondPerm, $this->userPerms) : in_array($perm, $this->userPerms);
    }
}