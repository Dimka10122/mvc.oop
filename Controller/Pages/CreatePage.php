<?php

namespace Controller\Pages;

use ToHtmlInterface;

use Model\Includes\Restrict;
use Model\Pages;

class CreatePage implements ToHtmlInterface
{
    public $title;
    private $pagesClass;
    private $restrict;
    public $contentValidate = [];
    public $pageData = [];

    public function __construct()
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('create_page');
        $this->pagesClass = new Pages();
        $this->title = __('Create Page');

        $this->createPageAction();
    }

    public function createPageAction(): void
    {
        /** ??? */
        $neededFieldsArray = ['title', 'url_key', 'content'];

        /** extract */
        $this->pageData = extractFields($_POST, $neededFieldsArray);

        /** validate */
        $this->contentValidate = $_POST ? $this->pagesClass->validateContent($this->pageData) : [];

        if (isset($_POST['page_action']) && empty($this->contentValidate)) {
            $this->pagesClass->createPage($this->pageData);
            header('Location: ' . HOST . BASE_URL . 'pages');
            exit;
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $contentValidate = $this->contentValidate;
        $pageData = $this->pageData;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Pages/v_page_action.php');
        include('View/Base/v_footer.php');
    }
}