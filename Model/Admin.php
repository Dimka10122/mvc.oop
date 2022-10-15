<?php

declare(strict_types=1);

namespace Model;

use Core\DB;
use Core\PermsForRole;
use Model\Includes\UserInfo;
use PDO;

class Admin
{
    private $db;
    private $connect;
    private $userInfoClass;
    private $currentUserRole;
    private $permsForRoleClass;
    private $rolePerms;

    public function __construct()
    {
        $this->db = new DB;
        $this->connect = $this->db->connect;
        $this->userInfoClass = new UserInfo();
        $this->currentUserRole = $this->userInfoClass->userRoleValue[0];
        $this->permsForRoleClass = new PermsForRole();
        $this->rolePerms = $this->permsForRoleClass::permsForRoleArr;
    }

    public function getUsers(string $currentUser): array
    {
        $sql = "SELECT users.id, email, login, role, role_name FROM users LEFT JOIN roles ON roles.id = users.role WHERE login != :login";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':login', $currentUser);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function editUser(int $role, int $userId): bool
    {
        $sql = "UPDATE users SET role = :role WHERE id = :user_id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role', $role, PDO::PARAM_INT);
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();

        return (bool)$query->rowCount();
    }

    public function deleteUser(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return (bool)$query->fetch(PDO::FETCH_ASSOC);
    }

    public function changeRole(int $userId, int $role): void
    {
        $sql = "UPDATE users SET role = :role WHERE id = :user_id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role', $role, PDO::PARAM_INT);
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();
    }

    public function validateEditRole(int $chosenRole, $userRole, array $allRoles): array
    {
        $errors = [];

        if ($chosenRole > (int)end($allRoles)["id"] || $chosenRole < 1) {
            $errors[] = 'Invalid role. Check Roles table';
        }
        if ($userRole == 1) {
            $errors[] = 'You cannot change Admin role';
            return $errors;
        }
        if ($chosenRole == 1 && (int)$this->currentUserRole !== 1) {
            $errors[] = 'You cannot rise role to the Admin';
            return $errors;
        }
        if ($this->currentUserRole == $userRole) {
            $errors[] = 'You cannot change the role equal to you';
        }

        return $errors;
    }

    public function blockUserValidate(array $fields): array
    {
        $errors = [];
        $emailLen = mb_strlen($fields['email'], 'UTF-8');
        $dateLen = mb_strlen($fields['block_date'], 'UTF-8');

        if ($emailLen < 5 || $emailLen > 40) {
            $errors[] = 'Enter correct email';
        }
        if ($dateLen < 5 || $dateLen > 40) {
            $errors[] = 'Choose real date';
        }

        return $errors;
    }

    public function blockUserActionChain(array $fields): array
    {
        $errors = [];

        $sql = "SELECT id, email, login, role FROM users WHERE email = :email";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':email', $fields['email']);
        $query->execute();
        $existUserData = $query->fetchAll(PDO::FETCH_ASSOC) ?? [];
        $this->checkUserExistByEmail($existUserData, $errors);

        if ($existUserData['role'] == 1) {
            $errors[] = 'You cannot ban Admin';
            return $errors;
        }
        if ($existUserData['role'] == $this->currentUserRole) {
            $errors[] = 'You cannot ban user which has role like yours';
            return $errors;
        }

        $this->blockUser($existUserData, $fields);

        return $errors;
    }

    public function checkUserExistByEmail(array $existUserData, array &$errors)
    {
        if ($existUserData == null) {
            $errors[] = 'User with this email does not exist';
            return false;
        }
        if ($existUserData['role'] == 1) {
            $errors[] = 'This is the Admin. You can not block Admin';
            return false;
        }
    }

    public function checkIfUserBlockedYet(array $existUserData): bool
    {
        $userId = (int)$existUserData['id'];
        $sql = "SELECT * FROM block_users WHERE user_id = :user_id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();

        return (bool)$query->fetch(PDO::FETCH_ASSOC);
    }

    public function blockUser(array $existUserData, array $blockFields): void
    {
        $blockDate = $blockFields['block_date'];
        $userId = $existUserData['id'];

        $sql = $this->checkIfUserBlockedYet($existUserData) ?
            "UPDATE block_users SET block_time = :block_time WHERE user_id = :user_id" :
            "INSERT INTO block_users (user_id, block_time) VALUES (:user_id, :block_time)";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':block_time', $blockDate, PDO::PARAM_INT);
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();
    }

    public function setNewRole(string $roleName, array $permissions): void
    {
        $jsonPerms = json_encode($permissions);
        $sql = "INSERT INTO roles (role_name, permissions) VALUES (:role_name, :permissions)";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role_name', $roleName);
        $query->bindParam(':permissions', $jsonPerms);
        $query->execute();
    }

    public function getAllRoles(): array
    {
        $sql = "SELECT * FROM roles";
        $query = $this->connect->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoleData(int $roleId): array
    {
        $sql = "SELECT * FROM roles WHERE id = :id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(":id", $roleId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserRole(int $userId): array
    {
        $sql = "SELECT role FROM users WHERE id = :user_id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRole(string $roleId, array $roleData): void
    {
        $roleName = htmlspecialchars(trim($roleData["role_name"]));
        $jsonPerms = $roleData['permissions'];

        $sql = "UPDATE roles SET role_name = :role_name, permissions = :perms WHERE id = :role_id";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role_name', $roleName);
        $query->bindParam(':perms', $jsonPerms);
        $query->bindParam(':role_id', $roleId, PDO::PARAM_INT);
        $query->execute();
    }
//     public function updateRole(string $roleId, string $roleName, array $rolePerms): void
//     {
//         $jsonPerms = json_encode($rolePerms);
//         $sql = "UPDATE roles SET role_name = :role_name, permissions = :perms WHERE id = :role_id";
//         $query = $this->connect->prepare($sql);
//         $query->bindParam(':role_name', $roleName);
//         $query->bindParam(':perms', $jsonPerms);
//         $query->bindParam(':role_id', $roleId, PDO::PARAM_INT);
//         $query->execute();
//     }

    public function DeleteRole(int $id): bool
    {
        /** delete role */
        $sqlDelete = "DELETE FROM roles WHERE id = :id";
        $queryDelete = $this->connect->prepare($sqlDelete);
        $queryDelete->bindParam(':id', $id, PDO::PARAM_INT);
        $queryDelete->execute();

        /** set default role for users who has deleted role */
        $sqlUpdate = "UPDATE users SET role = '2' WHERE role = :role_id";
        $queryUpdate = $this->connect->prepare($sqlUpdate);
        $queryUpdate->bindParam(':role_id', $id, PDO::PARAM_INT);
        $queryUpdate->execute();

        return (bool)$queryDelete->rowCount();
    }

    public function validateNewRole(array $perms, string $roleName): array
    {
        $errors = [];
        $permsLen = count($perms);
        $roleNameLen = strlen($roleName);


        if ($this->checkIsExistRole($roleName)) {
            $errors[] = "Role with this name already exists";
            return $errors;
        }
        if ($roleNameLen <= 3 || $roleNameLen >= 30) {
            $errors[] = "Role name must be from 3 to 30 chars!";
        }
        if ($permsLen < 1) {
            $errors[] = "Select at least one permission";
            return $errors;
        }

        foreach ($perms as $perm) {
            if (!array_key_exists($perm, $this->rolePerms)) {
                $errors[] = 'Check if you have selected the permissions correctly';
                break;
            }
        }

        return $errors;
    }

    public function checkIsExistRole(string $roleName): bool
    {
        $sql = "SELECT * FROM roles WHERE role_name = :role_name";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':role_name', $roleName);
        $query->execute();

        return (bool)$query->fetch();
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
        }

        $query = $this->connect->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validateDeleteRole(int $id): array
    {
        $errors = [];

        if ($id == $this->currentUserRole) {
            $errors[] = 'You cannot delete your current role';
        }
        if ($id == 1) {
            $errors[] = 'You cannot delete Admin role';
        }
        if ($id == 2) {
            $errors[] = 'You cannot delete User role';
        }

        return $errors;
    }

    public function validateModifyRole(int $roleId, array $roleData): array
    {
        $errors = [];

        $roleName = htmlspecialchars(trim($roleData["role_name"]));
        $rolePerms = json_decode($roleData["permissions"]);
        $roleNameLen = mb_strlen($roleName, 'UTF-8');

        if ($roleId == 1) {
            $errors[] = 'You cannot modify Admin role';
            return $errors;
        }
        if ($roleId == $this->currentUserRole) {
            $errors[] = 'You cannot modify your role';
            return $errors;
        }
        if (count($rolePerms) < 2) {
            $errors[] = 'Choose at least 2 permissions';
        }
        if ($roleNameLen < 4) {
            $errors[] = 'Role name length must be not less then 4 characters!';
        }

        foreach ($rolePerms as $perm) {
            if (!array_key_exists($perm, $this->rolePerms)) {
                $errors[] = 'Check if you have selected the permissions correctly';
                break;
            }
        }

        return $errors;
    }
}