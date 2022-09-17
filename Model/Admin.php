<?php

declare(strict_types=1);

namespace Model;

class Admin
{
    private $db;
    private $connect; 

    public function __construct()
    {
        $this->db = new \Core\DB;
        $this->connect = $this->db->connect;
    }

    public function getUsers(int $offset, int $currentPage, int &$pagesNum, string $currentUser): array
    {
//        $sql = "UPDATE users SET password = :password WHERE login = :login";
//        $query = $this->connect->prepare($sql);
//        $query->bindParam(':password', $hashedPassword);
//        $query->bindParam(':login', $username);
//        $query->execute();

        $sql = "SELECT users.id, email, login, role, role_name FROM users LEFT JOIN roles ON roles.id = users.role WHERE login != :login";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':login', $currentUser);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function editUser(int $role, int $id): bool
    {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role', $role, \PDO::PARAM_INT);
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
        return (bool)$query->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function deleteUser(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
        return (bool)$query->fetch(\PDO::FETCH_ASSOC);
    }

    public function changeRoles(int $userId, int $role): void
    {
        $sql = "UPDATE users SET role = :role WHERE id = :user_id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role', $role, \PDO::PARAM_INT);
        $query->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $query->execute();
    }
    
    public function validateRole(string $userRole, array $allRoles): array
    {
        $errors = [];

        if ((int)$userRole > (int)end($allRoles)["id"] || $userRole < 1) {
            $errors[] = 'Invalid role. Check Roles table';
        }
        return $errors;
    }

    public function blockUserValidate(array $fields): array
    {
        $errors = [];
        $emailLen = mb_strlen($fields['email'], 'UTF-8');
        $dateLen = mb_strlen($fields['block_date'], 'UTF-8');
        if ($emailLen < 5 || $emailLen > 40) {
            $errors[] = __('Enter correct email');
        }
        if ($dateLen < 5 || $dateLen > 40) {
            $errors[] = __('Choose real date');
        }
        return $errors;
    }

    public function blockUserActionChain(array $fields): array
    {
        $errors = [];

        $sql = "SELECT * FROM users WHERE email = :email";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':email', $fields['email']);
        $query->execute();
        $existUserData = $query->fetch(\PDO::FETCH_ASSOC);

        $this->checkUserExistByEmail($existUserData, $errors);
        $this->blockUser($existUserData, $fields);

        return $errors;
    }

    public function checkUserExistByEmail(array $existUserData, array &$errors): mixed
    {
        if ( $existUserData == null ) {
            $errors[] = 'User with this email does not exist';
            return false;
        }

        if ( $existUserData['role'] == 1 ) {
            $errors[] = 'This is the Admin. You can not block Admin';
            return false;
        }
    }

    public function checkIfUserBlockedYet(array $existUserData): bool
    {
        $userId = (int)$existUserData['id'];
        $sql = "SELECT * FROM block_users WHERE user_id = :user_id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $query->execute();
        return (bool)$query->fetch(\PDO::FETCH_ASSOC);
    }

    public function blockUser(array $existUserData, array $blockFields): void
    {
        $blockDate = $blockFields['block_date'];
        $userId = $existUserData['id'];

        $sql = $this->checkIfUserBlockedYet($existUserData) ?
            "UPDATE block_users SET block_time = :block_time WHERE user_id = :user_id" :
            "INSERT INTO block_users (user_id, block_time) VALUES (:user_id, :block_time)";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':block_time', $blockDate, \PDO::PARAM_INT);
        $query->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $query->execute();
    }

    public function setNewRole(string $roleName, array $permissions): void
    {
        $jsonPerms = json_encode($permissions);
        $sql = "INSERT INTO roles (role_name, permissions) VALUES (:role_name, :permissions)";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role_name', $roleName, \PDO::PARAM_INT);
        $query->bindParam(':permissions', $jsonPerms);
        $query->execute();
    }

    public function getAllRoles(): array
    {
        $sql = "SELECT * FROM roles";
        $query = $this->connect->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

     public function updateRole(string $roleId, string $roleName, array $rolePerms): void
     {
         $sql = "UPDATE roles SET role_name = :role_name, permissions = :perms WHERE id = :role_id";
         $query = $this->connect->prepare($sql);
         $query->bindParam(':role_name', $roleName);
         $query->bindParam(':perms', $jsonPerms);
         $query->bindParam(':role_id', $roleId, \PDO::PARAM_INT);
         $query->execute();
     }

    public function DeleteRole(int $id): void
    {
        /** delete role */
        $sqlDelete = "DELETE FROM roles WHERE id = :id";
        $queryDelete = $this->connect->prepare($sqlDelete);
        $queryDelete->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryDelete->execute();

        /** set default role for users who has deleted role */
        $sqlUpdate = "UPDATE users SET role = '2' WHERE role = :role_id";
        $queryUpdate = $this->connect->prepare($sqlUpdate);
        $queryUpdate->bindParam(':role_id', $id, \PDO::PARAM_INT);
        $queryUpdate->execute();
    }

    public function validateNewRole(array $perms, string $roleName): array
    {
        $errors = [];
        $permsLen = count($perms);
        $roleNameLen = strlen($roleName);
        if ($roleNameLen <= 3 || $roleNameLen >= 30) {
            $errors[] = "Role name must be from 3 to 30 chars!";
        }
        if ($permsLen <= 0) {
            $errors[] = "Select at least one permission";
        }
        return $errors;
    }

    public function getStatsData(string $chart, string $time): array
    {
        $timeAgo = '';
        $sql = '';

        switch ($time) {
            case 'today':
                $timeAgo = date('Y:m:d 00:00:00', strtotime('today'));
                break;
            case 'month':
                $timeAgo = date('Y:m:d 00:00:00', strtotime('-1 month'));
                break;
            case 'year':
                $timeAgo = date('Y:m:d 00:00:00', strtotime('-1 year'));
                break;
        }
        switch ($chart) {
            case 'visits':
                $sql = "SELECT COUNT(id) as 'count' FROM visits WHERE visit_time BETWEEN '$timeAgo' and NOW()";
                break;
            case 'pass_errors':
                $sql = "SELECT COUNT(id) as 'count' FROM pass_errors WHERE error_time BETWEEN '$timeAgo' and NOW()";
                break;
            case 'messages':
                $sql = "SELECT COUNT(id) as 'count' FROM messages WHERE created_at BETWEEN '$timeAgo' and NOW()";
                break;
        };
        $query = $this->connect->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}