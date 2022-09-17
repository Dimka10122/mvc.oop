<?php

namespace Controller\Messages;

class Index implements \toHtml, \checkSessionLogs
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
        $this->messagesClass = new \Model\Messages();
        $this->userInfoClass = new \Model\Includes\UserInfo();
        $this->getUserData();

        $this->title = __('Chat List');

        $this->getAllMessagesAction();
        $this->checkSessionLogs();
        $this->correctMessages();
    }

    public function getUserData() : void
    {
        $this->userInfoData = $this->userInfoClass->userInfoData;
        $this->userRoleValue = $this->userInfoClass->userRoleValue;
    }

    public function getAllMessagesAction(): void
    {
        $this->messages = $this->messagesClass->getAllMessages();
    }

    public function correctMessages()
    {
        $messagesStringify = json_encode($this->messages);
        $this->messagesJson = str_replace('"', "'", $messagesStringify);
    }


    public function checkSessionLogs(): void
    {
        $this->successText = false;
        if (isset($_SESSION['is_message_added']) && $_SESSION['is_message_added']) {
            $this->successText = true;
            unset($_SESSION['is_message_added']);
        }

        $this->successDeleted = false;
        if (isset($_SESSION['is_message_deleted']) && $_SESSION['is_message_deleted']) {
            $this->successDeleted = true;
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

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Messages/v_index.php');
        include('View/Base/v_footer.php');
    }
}