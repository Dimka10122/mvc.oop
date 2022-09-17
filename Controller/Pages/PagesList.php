<?php

namespace Controller\Pages;

class PagesList
{
    public $title;
    private $pagesClass;
    public $allPages;

    public function __construct()
    {
        $this->pagesClass = new \Model\Pages();
        $this->title = __('Pages');

        $this->deletePagesAction();
        $this->getAllPagesAction();
    }

    public function getAllPagesAction(): void
    {
        $this->allPages = $this->pagesClass->getAllPages();
    }

    public function deletePagesAction(): void
    {
        $controllerField = htmlspecialchars($_POST['change_pages_controller']);
        $selectedPages = $_POST['page-info-select'] ?? [];
        if (isset($_POST["apply_select_action"]) && !empty($selectedPages)) {
            switch ($controllerField) {
                case 'delete':
                    foreach ( $selectedPages as $page ) {
                        $this->admin->deleteUser($page);
                    }
                    break;
            }
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $allPages = $this->allPages;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Pages/v_pages_list.php');
        include('View/Base/v_footer.php');
    }
}