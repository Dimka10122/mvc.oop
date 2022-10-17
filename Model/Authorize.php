<?php

declare(strict_types=1);

namespace Model;

use Core\DB;
use PDO;

class Authorize
{
    private $db;
    private $connect; 

    public function __construct()
    {
        $this->db = new DB;
        $this->connect = $this->db->connect;
    }

    public function registerValidate(array &$fields): array
    {
        $errors = [];
        $usernameLen = mb_strlen($fields['username'], 'UTF-8');
        $emailLen = mb_strlen($fields['email'], 'UTF-8');
        $passwordLen = mb_strlen($fields['password'], 'UTF-8');

        if ($usernameLen < 3 || $usernameLen > 30) {
            $errors[] = __('Username be from 3 to 30 chars!');
        }
        if ($emailLen < 5 || $emailLen > 40) {
            $errors[] = __('Enter correct email!');
        }
        if ($passwordLen < 5 || $passwordLen > 30) {
            $errors[] = __('Password be from 5 to 30 chars!');
        }
        if ($fields['password'] !== $fields['repeat_pass']) {
            $errors[] = __('Passwords do not match!');
        }

        $fields['username'] = htmlspecialchars(trim($fields['username']));
        $fields['email'] = htmlspecialchars(trim($fields['email']));
        $fields['password'] = htmlspecialchars(trim($fields['password']));
        $fields['repeat_pass'] = htmlspecialchars(trim($fields['repeat_pass']));

        return $errors;
    }

    public function existUserErrors($userData, $fields): array
    {
        $errors = [];
        if ($userData['login'] == $fields['username']) {
            $errors[] = __('User with this username already exists');
        }
        if ($userData['email'] == $fields['email']) {
            $errors[] = __('User with this email already exists');
        }

        return $errors;
    }

    public function fetchUserData(string $username, string $email = '') {
        $sql = "SELECT * FROM users WHERE login = :login OR email = :email";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':login', $username);
        $query->bindParam(':email', $email);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function registerUser(array $fields): array
    {
        $errors = [];
        $username = htmlspecialchars($fields['username']);
        $email = htmlspecialchars($fields['email']);
        $password = htmlspecialchars($fields['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userData = $this->fetchUserData($username, $email);

        if ($userData) {
            return $this->existUserErrors($userData, $fields);
        }

        $sql = "INSERT INTO users (email, login, password, role) VALUES (:email, :login, :password, 2)";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':email', $email);
        $query->bindParam(':login', $username);
        $query->bindParam(':password', $hashedPassword);
        $query->execute();

        return $errors;
    }

    public function bindLoggedUser(array $userInfo, array $fields): void
    {
        $rememberTime = $fields['remember_user'] == 'on' ? strtotime('+10 days'): 0;
        setcookie('user_info', json_encode($userInfo), $rememberTime);
    }

    public function loginUser(array $fields): array
    {
        $errors = [];
        $username = htmlspecialchars($fields['username']);
        $password = htmlspecialchars($fields['password']);
        $userData = $this->fetchUserData($username);

        if (!$userData) {
            $errors[] = __('User with this username does not exist');
        } else {
            $verifyPass = password_verify($password, $userData['password']);
            if (!$verifyPass) {
                $errors[] = __('Wrong Password');
                $sql = "INSERT INTO pass_errors (error_time) VALUES (NOW())";
                $query = $this->connect->prepare($sql);
                $query->execute();
            }
        }

        $loggedUserData = [
            'username' => $userData['login'],
            'email' => $userData['email'],
            'role' => $userData['role'],
        ];

        if (empty($errors)) {
            $this->bindLoggedUser($loggedUserData, $fields);
        }

        return $errors;
    }

    public function generateRebootCode(): string
    {
        $rebootCode = "";
        for ($i = 1; $i <= 6; $i++) {
            try {
                $rebootCode .= random_int(0, 9);
            } catch (\Exception $e) {
                echo $e;
            }
        }

        return $rebootCode;
    }

    public function rebootUserCheckExist(array $fields): array
    {
        $errors = [];
        $username = htmlspecialchars($fields["username"]);
        $email = htmlspecialchars($fields["email"]);
        $userData = $this->fetchUserData($username, $email);

        if (!$userData) {
            $errors[] = __('User with this username does not exist');
        } else {
            if($fields['email'] !== $userData['email']) {
                $errors[] = __('Wrong email');
            }
        }

        return $errors ?? [];
    }

    public function sendRebootCode(array $fields, string $rebootCode): void
    {
        $mail = $fields['email'];
        $title = "Hello, " . $fields['username'] . ", here is the password recovery code";
        $message = "The code itself: $rebootCode";
        $rebootCodeTime = strtotime('+10 minutes');

        mail($mail, $title, $message);
        setcookie('reboot_code', password_hash($rebootCode, PASSWORD_DEFAULT), $rebootCodeTime);
    }

    public function updatePasswordValidate(array &$fields): array
    {
        $errors = [];
        $passwordLen = mb_strlen($fields['new_password'], 'UTF-8');
        
        if($passwordLen < 5 || $passwordLen > 30) {
            $errors[] = __('Password be from 5 to 30 chars!');
        }
        if ($fields['new_password'] !== $fields['new_password_repeat']) {
            $errors[] = __('Passwords do not match!');
        }
        $fields['password'] = htmlspecialchars(trim($fields['new_password']));
        $fields['repeat_pass'] = htmlspecialchars(trim($fields['new_password_repeat']));

        return $errors;
    }

    public function updatePassword(string $newPassword): void
    {
        $username = $_SESSION['username_change_pass'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $username = htmlspecialchars(trim($username));

        $sql = "UPDATE users SET password = :password WHERE login = :login";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':password', $hashedPassword);
        $query->bindParam(':login', $username);
        $query->execute();

        $_SESSION['success_change_pass'] = true;
    }

    public function checkUserIsBlocked($userData): bool
    {
        $sql = "SELECT * FROM block_users LEFT JOIN users ON users.id = block_users.user_id WHERE login = :login";
        $query = $this->connect->prepare($sql);
        $query->bindParam(':login', $userData['username']);
        $query->execute();

        return (bool)$query->fetchAll(PDO::FETCH_ASSOC);
    }
}