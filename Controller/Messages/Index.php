<?php

namespace Controller\Messages;

use ToHtmlInterface;
use CheckSessionLogsInterface;

use Model\Includes\UserInfo;
use Model\Messages;

class Index implements ToHtmlInterface, CheckSessionLogsInterface
{
    public $title;
    private $messagesClass;
    private $userInfoClass;
    private $userInfoData;
    private $userRoleValue;
    public $messages;
    public $successText;
    public $successDeleted;
    public $successEdited;
    public $messagesJson;

    public function __construct()
    {
        $this->messagesClass = new Messages();
        $this->userInfoClass = new UserInfo();

        $this->title = __('Chat List');

        $this->executeOptionActionEvent();
        $this->getUserData();
        $this->getAllMessagesAction();
        $this->checkSessionLogs();
        $this->correctMessages();
    }

    public function getUserData(): void
    {
        $this->userInfoData = $this->userInfoClass->userInfoData;
        $this->userRoleValue = $this->userInfoClass->userRoleValue;
    }

    public function getAllMessagesAction(): void
    {
        $this->messages = $this->messagesClass->getAllMessages();
    }

    public function executeOptionActionEvent(): void
    {
        $postAction = $_POST["change_user_controller"];
        if (isset($postAction)) {
            $action = htmlspecialchars(trim($postAction));
            $selectedItems = $_POST['message-info-select'];
            $this->messagesClass->executeOptionAction($action, $selectedItems);
        }
    }

    public function correctMessages()
    {
        $messagesStringify = json_encode($this->messages);
        $this->messagesJson = str_replace('"', '\'', $messagesStringify);
    }

    public function checkSessionLogs(): void
    {
        $this->successText = false;
        if (isset($_SESSION['is_message_added']) && $_SESSION['is_message_added']) {
            $this->successText = true;
            unset($_SESSION['is_message_added']);
        }

        $this->successDeleted = null;
        if (isset($_SESSION['is_message_deleted']) && $_SESSION['is_message_deleted']) {
            $this->successDeleted = $_SESSION['is_message_deleted'];
            unset($_SESSION['is_message_deleted']);
        }

        $this->successEdited = false;
        if (isset($_SESSION['is_message_edited']) && $_SESSION['is_message_edited']) {
            $this->successEdited = true;
            unset($_SESSION['is_message_edited']);
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $messages = $this->messages;
        $messagesJson = $this->messagesJson;
        $userInfoData = $this->userInfoData;
        $userRoleValue = $this->userRoleValue;
        $successEdited =  $this->successEdited;
        $successDeleted =  $this->successDeleted;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Messages/v_index.php');
        include('View/Base/v_footer.php');
    }
}