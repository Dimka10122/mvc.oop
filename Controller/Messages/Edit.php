<?php

namespace Controller\Messages;

use ToHtmlInterface;

use Model\Includes\Restrict;
use Model\Messages;

class Edit implements ToHtmlInterface
{
    public $title;
    private $restrict;
    private $messagesClass;
    public $messageData = [];
    public $id;
    public $validateErrors = [];
    public $successEdit;

    public function __construct($routerRes)
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('edit_messages');
        $this->messagesClass = new Messages();

        $this->title = __('Edit message');

        $this->getMessageDataAction($routerRes);
        $this->editMessageAction();
    }

    public function getMessageDataAction($routerRes): void
    {
        $this->id = $routerRes['params']['id'];

        $this->messageData = $this->messagesClass->getMessage($this->id)[0];

        if (empty($this->messageData)) {
            header('Location: ' . HOST . BASE_URL . 'error404');
            exit();
        }
    }

    public function editMessageAction(): void
    {
        if ($_POST['edit_message']) {
            $neededFieldsArray = ['title', 'edit_role_name'];

            /** extract */
            $extractFields = extractFields($_POST, $neededFieldsArray);
            $this->messageData = array_merge($this->messageData, $extractFields);

            /**  validate */
            $this->validateErrors = $_POST ? $this->messagesClass->messagesValidate($this->messageData) : [];

            if (empty($this->validateErrors)) {
                $this->messagesClass->editMessage($this->messageData, $this->id);
                $_SESSION['is_message_edited'] = true;
                header('Location: ' . HOST . BASE_URL);
                exit();
            }
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $messageData = $this->messageData;
        $validateErrors = $this->validateErrors;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Messages/v_edit.php');
        include('View/Base/v_footer.php');
    }
}