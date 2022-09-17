<?php

declare(strict_types=1);

namespace Model\Includes;

class Restrict
{
    public $userInfoClass;
    public $userRoleValue;

    public function __construct()
    {
        $this->userInfoClass = new \Model\Includes\UserInfo();
        $this->userRoleValue = $this->userInfoClass->userRoleValue;
    }

    public function goErrorPage() : void
    {
        header('Location: ' . HOST . BASE_URL . 'error404');
        exit();
    }

    public function goMainPage() : void
    {
        header('Location: ' . HOST . BASE_URL);
        exit();
    }
    
    public function restrictByRole($due, $secondDue = '') : void
    {
        $access = $this->userInfoClass->canUser($due, $secondDue);
        if (!$access) {
            $this->goErrorPage();
        }
    }

    public function restrictLoggedUser() : void
    {
        if ($this->userInfoClass->userInfoData) {
            $this->goMainPage();
        }
    }

    public function restrictUnLoggedUser() : void
    {
        if (!$this->userInfoClass->userInfoData) {
            $this->goMainPage();
        }
    }
}
