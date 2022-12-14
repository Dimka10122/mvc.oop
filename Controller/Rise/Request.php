<?php

namespace Controller\Rise;

use Model\Admin;

class Request implements \toHtml
{
    public $title;
    private $rise;
    private $admin;
    private $restrict;
    public $allRoles;
    public $validateErrors = [];
    public $userInfoClass;
    public $userInfoData;

    public function __construct()
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('send_rise_request');
        $this->rise = new \Model\Rise();
        $this->admin = new \Model\Admin();
        $this->userInfoClass = new \Model\Includes\UserInfo();

        $this->userInfoData = $this->userInfoClass->userInfoData;
        $this->title = __('Rise Request');

        $this->checkSendRequestYetAction();
        $this->getAllRolesAction();
        $this->sendRequestRiseAction();
    }

    public function getAllRolesAction(): void
    {
        $this->allRoles = $this->admin->getAllRoles();
    }

    public function checkSendRequestYetAction()
    {
        if ( isset($_POST['send_request_rise']) &&
            $this->rise->checkSendRequestYet($this->userInfoData['username'])
            ) {
            $this->validateErrors[] = 'You have send request for rise yet';
            return;
        }
    }

    public function sendRequestRiseAction(): void
    {
        if (
            isset($_POST['send_request_rise']) &&
            empty($this->validateErrors)
        ) {
            $chosenRise = htmlspecialchars(trim($_POST['user-role-list']));
            $this->rise->sendRequestRise(
                $chosenRise,
                $this->userInfoData["username"]
            );
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $allRoles = $this->allRoles;
        $validateErrors = $this->validateErrors;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Rise/v_request.php');
        include('View/Base/v_footer.php');
    }

}