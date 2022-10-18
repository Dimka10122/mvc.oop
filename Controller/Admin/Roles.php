<?php

namespace Controller\Admin;

use CheckSessionLogsInterface;
use ToHtmlInterface;

use Model\Admin;
use Model\Messages;
use Core\PermsForRole;
use Model\Includes\Restrict;
use Model\Includes\userInfo;

class Roles implements ToHtmlInterface, CheckSessionLogsInterface
{
    public $title;
    private $permsForRoleClass;
    private $restrict;
    private $admin;
    private $messagesClass;
    private $userInfoClass;
    public $successEditedRole;
    public $usersJson;
    public $allRoles = [];
    public $users = [];
    public $fields = [];
    public $permsForRole = [];
    public $validateErrors = [];
    public $deleteRoleError;
    public $modifyRoleError;

    public function __construct()
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('edit_roles', 'modify_roles');

        $this->userInfoClass = new userInfo();
        $this->messagesClass = new Messages();
        $this->admin = new Admin();
        $this->permsForRoleClass = new PermsForRole();
        $this->permsForRole = $this->permsForRoleClass::permsForRoleArr;

        $this->title = __('Roles page');

        $this->checkIfNotHaveToEdit();
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

        if (isset($_POST["add_role_action"])) {
            $roleName = htmlspecialchars(trim($this->fields["role_name"]));
            $rolePerms = (array)$_POST["add_new_role_perms"];
            $secureRolePerms = [];

            foreach ($rolePerms as $perm) {
                $secureRolePerms[] = htmlspecialchars($perm);
            }

            $this->validateErrors = $_POST ? $this->admin->validateNewRole($secureRolePerms, $roleName) : [];

            if (empty($this->validateErrors)) {
                $permissions = $_POST["add_new_role_perms"];
                $this->admin->setNewRole($roleName, $permissions);
                $this->fields['role_name'] = '';
            }
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
        if (isset($_POST['select-action'])) {
            $selectedUsers = $_POST["user-info-select"] ?? [];
            $selectedRole = (int)htmlspecialchars(trim($_POST["select-role-for-users"]));
            $controllerField = htmlspecialchars($_POST['change_user_controller']);

            switch ($controllerField) {
                case 'delete':
                    foreach ($selectedUsers as $selectedUser) {
                        $userData = explode('_', $selectedUser);
                        $userId = $userData[0];
                        $this->admin->deleteUser($userId);
                    }
                    break;
                case 'assign':
                    if (!$selectedRole) {
                        $this->validateErrors[] = __('Select the desired role');
                        return;
                    }

                    /** check if exist selected role */
                    if (!$this->admin->getRoleData($selectedRole)) {
                        $this->validateErrors[] = __('Role with this id does not exist!');
                        return;
                    }

                    if (empty($this->validateErrors)) {
                        foreach ($selectedUsers as $selectedUser) {
                            /** post: userId_userRole */
                            $userData = explode('_', $selectedUser);
                            $userRole = $userData[1];
                            $this->validateErrors = $this->admin->validateEditRole(
                                $selectedRole,
                                $userRole,
                                $this->allRoles
                            );
                            if (empty($this->validateErrors)) {
                                $userId = $userData[0];
                                $this->admin->changeRole($userId, $selectedRole);
                            }
                        }
                    }
                    break;
                case 'edit':
                    $editQueue = [];
                    foreach ($selectedUsers as $selectedUser) {
                        $userData = explode('_', $selectedUser);
                        $userId = $userData[0];
                        $editQueue[] = $userId;
                    }
                    $_SESSION['edit_users'] = $editQueue;
                    break;
                default:
                    $this->validateErrors[] = 'Choose action';
                    break;
            }
        }
    }

    public function checkSessionLogs(): void
    {
        $this->successEditedRole = null;
        if (isset($_SESSION['is_user_role_edited'])) {
            $this->successEditedRole = $_SESSION['is_user_role_edited'];
            unset($_SESSION['is_user_role_edited']);
        }

        $this->deleteRoleError = false;
        if (isset($_SESSION['delete_role_validate_error']) && $_SESSION['delete_role_validate_error']) {
            $this->deleteRoleError = $_SESSION['delete_role_validate_error'];
            unset($_SESSION['delete_role_validate_error']);
        }

        $this->modifyRoleError = null;
        if (isset($_SESSION['modify_error']) && $_SESSION['modify_error']) {
            $this->modifyRoleError = $_SESSION['modify_error'];
            unset($_SESSION['modify_error']);
        }
    }

    private function checkIfNotHaveToEdit()
    {
        $editQueue = $_SESSION['edit_users'];
        if (!empty($editQueue)) {
            header('Location: ' . HOST . BASE_URL . 'roles' . BASE_URL .
                'user' . BASE_URL . $editQueue[0] . BASE_URL . 'edit');
        }
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
        $deleteRoleError = $this->deleteRoleError;
        $modifyRoleError = $this->modifyRoleError;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Admin/v_roles.php');
        include('View/Base/v_footer.php');
    }

}