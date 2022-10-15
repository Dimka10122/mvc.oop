<?php

namespace Controller\Pages;

use ToHtmlInterface;

use Model\Includes\Restrict;
use Model\Pages;

class EditPage implements ToHtmlInterface
{
    public $title;
    private $pagesClass;
    private $restrict;
    public $contentValidate = [];
    public $pageData = [];
    public $fields = [];

    public function __construct($routerRes)
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('control_pages');
        $this->pagesClass = new Pages();
        $this->title = __('Edit Page');

        $this->setPageDataAction($routerRes);
        $this->EditPageAction($routerRes);
    }

    public function setPageDataAction($routerRes): array
    {
        $pageUrlId = $routerRes['params']['id'];
        return $this->pagesClass->getPageData('', $pageUrlId)[0] ?? [];
    }

    public function EditPageAction($routerRes) : void
    {
        $id = $routerRes['params']['id'];
        $neededFieldsArray = ['title', 'url_key', 'content'];

        /** extract */
        $this->fields = extractFields($_POST, $neededFieldsArray);

        /** validate */
        $this->contentValidate = $_POST ? $this->pagesClass->validateContent($this->fields) : [];
        $this->pageData = $_POST ? $this->fields : $this->setPageDataAction($routerRes);
        if (isset($_POST['page_action']) && empty($this->contentValidate)) {
            $this->pagesClass->editPage($this->fields, $id);
            header('Location: ' . HOST . BASE_URL . 'pages');
            exit;
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $contentValidate = $this->contentValidate;
        $pageData = $this->pageData;

        include('view/base/v_header.php');
        include('view/base/v_content.php');
        include('view/pages/v_page_action.php');
        include('view/base/v_footer.php');
    }

}