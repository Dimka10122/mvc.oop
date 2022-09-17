<?php

namespace Controller\Messages;

class Edit implements \toHtml
{
    public $title;
    private $restrict;
    private $messagesClass;
    
    public function __construct($routerRes)
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('edit_messages');
        $this->messagesClass = new \Model\Messages();
        $this->title = __('Edit message');

        $this->editMessageAction($routerRes);
    }

    public function editMessageAction($routerRes): void
    {
        $id = $routerRes['params']['id'];
        
        if ( $_POST['edit_message'] ) {
            $title = htmlspecialchars(trim($_POST['title']));
            $message = htmlspecialchars(trim($_POST['message']));
            $result = $this->messagesClass->editMessage($title, $message, $id);
            $_SESSION['is_message_edited'] = $result;
            header('Location: ' . HOST . BASE_URL);
            exit;
        }
    }

    public function toHtml(): void
    {
        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Messages/v_edit.php');
        include('View/Base/v_footer.php');
    }
}

?>