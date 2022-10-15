<?php

namespace Controller\Messages;

use ToHtmlInterface;

use Model\Includes\Restrict;
use Model\Messages;

class Delete implements ToHtmlInterface
{
    private $restrict;
    private $messagesClass;
    public $title;

    public function __construct($routerRes)
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('delete_messages');
        $this->messagesClass = new Messages();
        $this->title = __('Delete message');

        $this->deleteMessageAction($routerRes);
    }

    public function deleteMessageAction($routerRes): void
    {
        $id = $routerRes['params']['id'];

        if ($_POST['delete_message']) {
            $result = $this->messagesClass->deleteMessage($id);
            $_SESSION['is_message_deleted'] = $result;
            header('Location: ' . HOST . BASE_URL);
            exit();
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Messages/v_delete.php');
        include('View/Base/v_footer.php');
    }
}