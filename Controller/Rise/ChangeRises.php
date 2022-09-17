<?php

namespace Controller\Rise;

use Model\Includes\Restrict;

class ChangeRises implements \toHtml
{
    public $title;
    private $rise;
    private $restrict;
    public $requests = [];

    public function __construct()
    {
        $this->rise = new \Model\Rise();
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('rise_users');
        $this->title = __('Upgrade User Roles');

        $this->serveRequestAction();
        $this->serveRequestMultipleAction();
        $this->getAllRequestsAction();
        $this->adminChangeRiseAction();
    }

    public function getAllRequestsAction(): void
    {
        $this->requests = $this->rise->getAllRequests();
    }

    public function serveRequestAction(): void
    {
        if( isset($_POST["request-action"]) ) {
            $requestUserId = (int)htmlspecialchars($_POST["request_user_id"]);
            $requestAction = $_POST["request-action"] == "access" ? 1 : 2;
            $this->rise->serveRequest($requestUserId, $requestAction);
        }
    }

    public function serveRequestMultipleAction(): void
    {
        if (isset($_POST["request_action_multiple"])) {
            $requestAction = $_POST["change_rise_controller"] == "access" ? 1 : 2;
            $this->rise->serveRequestMultiple($requestAction);
        }
    }

    public function convertRoleAction(int $roleId): void
    {
        $roleNameArr = $this->rise->convertRole($roleId);
        echo $roleNameArr["role_name"];
    }

    public function convertStatusAction(int $status): void
    {
        switch ($status) {
            case 0:
                echo 'In Process';
                break;
            case 1:
                echo 'Accepted';
                break;
            case 2:
                echo 'Rejected';
                break;
        }
    }

    public function adminChangeRiseAction(): void
    {

    }

    public function toHtml(): void
    {
        $title = $this->title;
        $requests = $this->requests;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Rise/v_change_rises.php');
        include('View/Base/v_footer.php');
    }

}