<?php

namespace Controller\Admin;

use ToHtmlInterface;

use Core\PermsForRole;
use Model\Admin;
use Model\Includes\Restrict;

class ModifyRole implements ToHtmlInterface
{
    public $title;
    private $restrict;
    private $admin;
    public $validateErrors = [];
    public $permsForRole;
    public $roleId;
    public $roleData;

    public function __construct($routerRes)
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('modify_roles');
        $this->admin = new Admin();
        $this->title = __('Modify Role');
        $this->permsForRole = new PermsForRole();

        $this->getRoleDataAction($routerRes);
        $this->updateRoleAction();
    }

    public function getRoleDataAction($routerRes): void
    {
        $this->roleId = $routerRes['params']['id'];

        $this->roleData = $this->admin->getRoleData($this->roleId)[0];

        if (empty($this->roleData)) {
            header("Location: " . HOST . BASE_URL . "error404");
        }
    }

    public function updateRoleAction(): void
    {
        if (isset($_POST['save_modify_role'])) {
            $neededFieldsArray = ['permissions', 'role_name'];
            $_POST['permissions'] = json_encode($_POST['permissions']);

            /** extract */
            $extractFields = extractFields($_POST, $neededFieldsArray);
            $this->roleData = array_merge($this->roleData, $extractFields);

            /**  validate */
            $this->validateErrors = $this->admin->validateModifyRole($this->roleId, $this->roleData);

            if (empty($this->validateErrors)) {
                $this->admin->updateRole($this->roleId, $this->roleData);
                header("Location: " . HOST . BASE_URL . "roles");
                exit();
            }
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $validateErrors = $this->validateErrors;
        $roleId = $this->roleId;
        $roleData = $this->roleData;
        $permsForRoleArr = $this->permsForRole::permsForRoleArr;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Admin/v_modify_role.php');
        include('View/Base/v_footer.php');
    }
}