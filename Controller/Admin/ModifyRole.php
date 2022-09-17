<?php

namespace Controller\Admin;

class ModifyRole implements \toHtml
{
    public $title;
    private $restrict;
    private $admin;
    public $validateErrors = [];
    public $roleName;
    public $rolePerms;
    public $permsForRole;
    public $roleId;
    public $permsForRoleArr;

    public function __construct()
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('modify_roles');
        $this->admin = new \Model\Admin();
        $this->title = __('Modify Role');
        $this->permsForRole = new \Core\PermsForRole();

        $this->validateRoleAction();
        $this->getRoleDataAction();
        $this->updateRoleAction();
    }

    public function getRoleDataAction(): void
    {
        if ( isset($_POST['edit_role_action']) ) {
            $this->roleName = htmlspecialchars(trim($_POST["edit_role_name"]));
            $this->roleId = htmlspecialchars(trim($_POST["edit_role_id"]));
            $rolePerms = $_POST["edit_role_perms"];
            $resultPerms = str_replace("'", '"', $rolePerms);
            $this->rolePerms = (array)json_decode($resultPerms);
        }
    }

    public function updateRoleAction(): void
    {
        if ( isset($_POST['save_edit_role']) && empty($this->validateErrors) ) {
            $this->roleName = htmlspecialchars(trim($_POST["edit_role_name"]));
            $this->roleId = htmlspecialchars(trim($_POST["edit_role_id"]));
            $rolePerms = $_POST["edit_role_perms"];
            $resultPerms = str_replace("'", '"', $rolePerms);
            $this->rolePerms = $resultPerms;
            $this->admin->updateRole($this->roleId, $this->roleName, $this->rolePerms);
            header("Location: " . HOST . BASE_URL . "roles");
            exit();
        }
    }

    public function validateRoleAction()
    {

    }

    public function toHtml(): void
    {
        $title = $this->title;
        $validateErrors = $this->validateErrors;
        $roleId = $this->roleId;
        $roleName = $this->roleName;
        $rolePerms = $this->rolePerms;
        $permsForRoleArr = $this->permsForRole::permsForRoleArr;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Admin/v_modify_role.php');
        include('View/Base/v_footer.php');
    }
}