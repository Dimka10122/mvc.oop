<?php

namespace Controller\Rise;

use ToHtmlInterface;

use Model\Includes\Restrict;
use Model\Rise;

class ChangeRises implements ToHtmlInterface
{
    public $title;
    private $rise;
    private $restrict;
    public $requestsJson;

    public function __construct()
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('rise_users');
        $this->rise = new Rise();

        $this->title = __('Upgrade User Roles');

        $this->serveRequestAction();
        $this->serveRequestMultipleAction();
        $this->getAllRequestsAction();
    }

    public function getAllRequestsAction(): void
    {
        $requests = $this->rise->getAllRequests();
        $this->requestsJson = json_encode($requests);
    }

    public function serveRequestAction(): void
    {
        if (isset($_POST["request-action"])) {
            $requestUserId = (int)htmlspecialchars($_POST["request_user_id"]);
            $requestAction = $_POST["request-action"] == "access" ? 1 : 2;
            $this->rise->serveRequest($requestUserId, $requestAction);
        }
    }

    public function serveRequestMultipleAction(): void
    {
        if (isset($_POST["select-action"])) {
            $requestAction = $_POST["change_user_controller"] == "accept" ? 1 : 2;
            $selectedUsers = $_POST["user-info-select"];

            $this->rise->serveRequestMultiple($requestAction, $selectedUsers);
        }
    }

    public function convertRoleAction(int $roleId): string
    {
        $roleNameArr = $this->rise->convertRole($roleId);
        return (string)$roleNameArr["role_name"];
    }

    public function convertStatusAction(int $status): string
    {
        switch ($status) {
            case 0:
                return 'In Process';
            case 1:
                return 'Accepted';
            case 2:
                return 'Rejected';
            default:
                return 'Your request in processing';
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $requestsJson = $this->requestsJson;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Rise/v_change_rises.php');
        include('View/Base/v_footer.php');
    }

}