<?php

namespace Controller\Pages;

class Page implements \toHtml
{
    public $pagesClass;
    public $pageData = [];

    public function __construct($routerRes)
    {
        $this->pagesClass = new \Model\Pages();

        $this->getPageDataAction($routerRes);
    }

    public function getPageDataAction($routerRes): void
    {
        $pageUrlKey = $routerRes['params']['url_key'];
        $this->pageData = $this->pagesClass->getPageData($pageUrlKey);
    }

    public function toHtml(): void
    {
        $pageData = $this->pageData;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        if (!empty($pageData)) {
            include('View/Pages/v_page.php');
        } else {
            include ('View/Errors/v_404.php');
        }
        include('View/Base/v_footer.php');
    }
}