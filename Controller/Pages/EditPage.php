<?php

namespace Controller\Pages;

class EditPage implements \toHtml
{
    public $title;
    private $pagesClass;
    private $restrict;
    public $contentValidate = [];
    public $pageData = [];
    public $fields = [];

    public function __construct($routerRes)
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('control_pages');
        $this->pagesClass = new \Model\Pages();
        $this->title = __('Edit Page');

        $this->setPageData();
        $this->EditPageAction($routerRes);
    }

    public function setPageData(): void
    {
        $this->pageData = $_POST;
    }

    public function EditPageAction($routerRes) : void
    {
        $id = $routerRes['params']['id'];
        $neededFieldsArray = ['page_title_data', 'page_url_key_data', 'page_content_data'];

        /** extract */
        $this->fields = extractFields($_POST, $neededFieldsArray);

        /** validate */
        $this->contentValidate = $_POST ? $this->pagesClass->validateContent($this->fields) : [];

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