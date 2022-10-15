<?php

namespace Controller\Messages;

use ToHtmlInterface;

use Model\Includes\Restrict;
use Model\Includes\UserInfo;
use Model\Messages;

class Add implements ToHtmlInterface
{
    public $title;
    private $restrict;
    private $messagesClass;
    public $fields;
    private $userInfoClass;
    public $validateErrors;
    public $username;

    public function __construct()
    {
        $this->restrict = new Restrict;
        $this->restrict->restrictByRole('add_messages');
        $this->messagesClass = new Messages();
        $this->userInfoClass = new UserInfo();
        $this->title = __('Add message');

        $this->AddMessageAction();
    }

    public function AddMessageAction(): void
    {
        $this->username = htmlspecialchars($this->userInfoClass->userInfoData['username']);
        $neededFieldsArray = ['title', 'message'];

        /** extract */
        $this->fields = extractFields($_POST, $neededFieldsArray);

        /**  validate */
        $this->validateErrors = $_POST ? $this->messagesClass->messagesValidate($this->fields) : [];

        if (empty($this->validateErrors) and count($_POST)) {
            $result = $this->messagesClass->setMessage($this->fields, $this->username);
            $_SESSION['is_message_added'] = $result;
            header('Location: ' . HOST . BASE_URL);
            exit;
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $validateErrors = $this->validateErrors;
        $fields = $this->fields;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Messages/v_add.php');
        include('View/Base/v_footer.php');
    }
}