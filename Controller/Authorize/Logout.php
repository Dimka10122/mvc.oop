<?php

namespace Controller\Authorize;

use Model\Includes\Restrict;
use ToHtmlInterface;

class Logout implements ToHtmlInterface
{
    public $title;
    private $restrict;

    public function __construct()
    {
        $this->restrict = new Restrict;
        $this->restrict->restrictUnLoggedUser();
        $this->title = __('Log Out');

        $this->setCookieAboutUser();        
    }

    public function setCookieAboutUser(): void
    {
        if ( $_POST['logout'] ) {
            setcookie('user_info', null, -2147483647);
            header('Location: ' . HOST . BASE_URL);
            exit;
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Authorize/v_logout.php');
        include('View/Base/v_footer.php');
    }
}