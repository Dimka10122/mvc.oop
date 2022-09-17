<?php

namespace Controller\Admin;

class DeleteRole implements \toHtml
{
    public $title;
    private $admin;
    private $restrict;

    public function __construct($routerRes)
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('modify_roles');
        $this->admin = new \Model\Admin();
        $this->title = __('Delete Role');

        $this->DeleteRoleAction($routerRes);
    }

    public function DeleteRoleAction($routerRes): void
    {
        $id = $routerRes['params']['id'];
        if ( isset($_POST["delete_role_action"]) ) {
            $this->admin->DeleteRole($id);
            header('Location: ' . HOST . BASE_URL . 'roles');
            exit;
        }
    }

    public function toHtml(): void
    {
        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Admin/v_delete_role.php');
        include('View/Base/v_footer.php');
    }
}