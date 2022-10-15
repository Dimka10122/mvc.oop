<?php

namespace Controller\Admin;

use ToHtmlInterface;

use Model\Admin;
use Model\Includes\Restrict;

class EditRole implements ToHtmlInterface
{
    public $title;
    private $restrict;
    private $admin;
    public $roleValidate = [];
    public $allRoles = [];
    private $userId;
    private $userRole;

    public function __construct($routerRes)
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('edit_roles');
        $this->admin = new Admin();
        $this->title = __('Edit user role');

        $this->getUserRoleAction($routerRes);
        $this->setAllRolesAction();
        $this->EditUserRoleAction();
    }

    public function setAllRolesAction(): void
    {
        $this->allRoles = $this->admin->getAllRoles();
    }

    public function getUserRoleAction($routerRes)
    {
        $this->userId = $routerRes['params']['id'];
        $this->userRole = $this->admin->getUserRole($this->userId)[0]['role'];
    }

    public function EditUserRoleAction() : void
    {
        $role = (int)htmlspecialchars(trim($_POST['user-role-list']));

        /** validate */
        $this->roleValidate = $_POST ? $this->admin->validateEditRole($role, $this->userRole, $this->allRoles) : [];

        if ($_POST['edit_user'] && empty($this->roleValidate)) {
            $isExistRole = $this->admin->getRoleData($role);
            if ($isExistRole) {
                $result = $this->admin->editUser($role, $this->userId);
                $_SESSION['is_user_role_edited'] = $result;
            } else {
                $_SESSION['is_user_role_edited'] = false;
            }

            header('Location: ' . HOST . BASE_URL . 'roles');
            exit;
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $roleValidate = $this->roleValidate;
        $allRoles = $this->allRoles;

        include('view/base/v_header.php');
        include('view/base/v_content.php');
        include('view/admin/v_edit.php');
        include('view/base/v_footer.php');
    }
}