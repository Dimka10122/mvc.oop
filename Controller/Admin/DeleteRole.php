<?php

namespace Controller\Admin;

use ToHtmlInterface;

use Model\Admin;
use Model\Includes\Restrict;

class DeleteRole implements ToHtmlInterface
{
    public $title;
    private $admin;
    private $restrict;
    public $validateErrors = [];

    public function __construct($routerRes)
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('modify_roles');
        $this->admin = new Admin();

        $this->title = __('Delete Role');

        $this->DeleteRoleAction($routerRes);
    }

    public function DeleteRoleAction($routerRes): void
    {
        $id = $routerRes['params']['id'];
        $this->validateErrors = $this->admin->validateDeleteRole($id);
        $_SESSION['delete_role_validate_error'] = $this->validateErrors[0];

        if (isset($_POST["delete_role_action"])) {
            if (empty($this->validateErrors)) {
                $result = $this->admin->DeleteRole($id);
                if (!$result) {
                    $_SESSION['delete_role_validate_error'] = 'This role does not exist';
                }
            }
            header('Location: ' . HOST . BASE_URL . 'roles');
            exit();
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $validateErrors = $this->validateErrors;
        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Admin/v_delete_role.php');
        include('View/Base/v_footer.php');
    }
}