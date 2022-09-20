<?php

namespace Controller\Admin;

class Roles implements \toHtml
{
    public $title;
    private $restrict;
    private $admin;
    private $messagesClass;
    private $userInfoClass;
    public $users = [];
    public $usersJson;
    public $successEditedRole;
    public $allRoles = [];
    private $validateErrors = [];
    public $fields = [];
    public $permsForRole = [];
    private $permsForRoleClass;

    public function __construct()
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('edit_roles', 'modify_roles');
        if (isset($_POST['assign_role'])) {
            header('Location: ' . BASE_URL . 'edit');
        }
        $this->userInfoClass = new \Model\Includes\userInfo();
        $this->messagesClass = new \Model\Messages();
        $this->admin = new \Model\Admin();
        $this->permsForRoleClass = new \Core\PermsForRole();
        $this->permsForRole = $this->permsForRoleClass::permsForRoleArr;

        $this->title = __('Roles page');

        $this->addNewRoleAction();
        $this->getAllRolesAction();
        $this->AdminChangeUsersAction();
        $this->getAllUsersAction();

        $this->checkSessionLogs();
    }

    public function addNewRoleAction() : void
    {
        $neededFieldsArray = ['role_name'];

        /** extract */
        $this->fields = extractFields($_POST, $neededFieldsArray);

        $roleName = htmlspecialchars(trim($this->fields["role_name"]));
        $rolePerms = (array)$_POST["add_new_role_perms"];
        $secureRolePerms = [];
        foreach ($rolePerms as $perm) {
            $secureRolePerms[] = htmlspecialchars($perm);
        }
        $this->validateErrors = $_POST ? $this->admin->validateNewRole($secureRolePerms, $roleName) : [];

        if (isset($_POST["add_role_action"]) && empty($this->validateErrors)) {
            $permissions = $_POST["add_new_role_perms"];
            $this->admin->setNewRole($roleName, $permissions);
            $this->fields['role_name'] = '';
        }
    }

    public function getAllRolesAction() : void
    {
        $this->allRoles = $this->admin->getAllRoles();
    }

    public function getAllUsersAction() : void
    {
        $this->users = $this->admin->getUsers($this->userInfoClass->userInfoData['username']);
        $this->usersJson = json_encode($this->users);
    }

    public function AdminChangeUsersAction(): void
    {
        $controllerField = htmlspecialchars($_POST['change_user_controller']);
        $selectedUsers = $_POST['user-info-select'] ?? [];
        switch ($controllerField) {
            case 'delete':
                foreach ( $selectedUsers as $selectedUser ) {
                    $selectedUserId = explode('_', $selectedUser);
                    $this->admin->deleteUser($selectedUserId[1]);
                }
                break;
            case 'assign_role':
                break;
        }
    }

    public function checkSessionLogs(): void
    {
        $this->successEditedRole = false;
        if ( isset($_SESSION['is_user_role_edited']) && $_SESSION['is_user_role_edited'] ) {
            $this->successEditedRole = true;
            unset($_SESSION['is_user_role_edited']);
        }
    }

    public function correctPerm(string $perm): string
    {
            str_replace('"', "'", $perm);
            return implode("'", explode('"', $perm));
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $users = $this->users;
        $usersJson = $this->usersJson;
        $successEditedRole = $this->successEditedRole;
        $allRoles = $this->allRoles;
        $validateErrors = $this->validateErrors;
        $fields = $this->fields;
        $permsForRole = $this->permsForRole;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Admin/v_roles.php');
        include('View/Base/v_footer.php');
    }
}