<?php

namespace Controller\Admin;

class EditRole implements \toHtml
{
    public $title;
    private $restrict;
    private $admin;
    public $roleValidate = [];
    public $allRoles = [];

    public function __construct($routerRes)
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('edit_roles');
        $this->admin = new \Model\Admin();
        $this->title = __('Edit user role');

        $this->setAllRolesAction();
        $this->EditUserRoleAction($routerRes);
    }

    public function setAllRolesAction(): void
    {
        $this->allRoles = $this->admin->getAllRoles();
    }

    public function EditUserRoleAction($routerRes) : void
    {
        $id = $routerRes['params']['id'];
        $role = (int) htmlspecialchars(trim($_POST['user-role-list']));

        /** validate */
        $this->roleValidate = $_POST ? $this->admin->validateRole($role, $this->allRoles) : [];

        if ( $_POST['edit_user'] && empty($this->roleValidate) ) {
            $result = $this->admin->editUser($role, $id);
            $_SESSION['is_user_edited'] = $result;
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