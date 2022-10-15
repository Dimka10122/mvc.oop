<?php

namespace Controller\Errors;

use ToHtmlInterface;

class E404 implements ToHtmlInterface
{
    public $title;

    public function __construct()
    {
        $this->title = __("Error 404");
    }

    public function toHtml(): void
    {
        $title = $this->title;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Errors/v_404.php');
        include('View/Base/v_footer.php');
    }
}