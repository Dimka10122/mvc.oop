<?php

namespace Controller\Pages;

class DeletePage implements \toHtml
{
    public $title;
    private $pagesClass;
    private $restrict;

    public function __construct($routerRes)
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('control_pages');
        $this->pagesClass = new \Model\Pages();
        $this->title = __('Delete Page');

        $this->deletePageAction($routerRes);
    }

    public function deletePageAction($routerRes): void
    {
        $id = $routerRes['params']['id'];
        if (isset($_POST["delete_page_action"])) {
            $this->pagesClass->deletePage($id);
            header('Location: ' . HOST . BASE_URL . 'pages');
            exit;
        }
    }

    public function toHtml(): void
    {
        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Pages/v_delete_page.php');
        include('View/Base/v_footer.php');
    }
}