<?php

namespace Controller\Authorize;

use ToHtmlInterface;

use Model\Includes\Restrict;

class ForgotPassConfirm implements ToHtmlInterface
{
    public $title;
    private $restrict;
    public $validateErrors = [];

    public function __construct()
    {
        $this->restrict = new Restrict;
        $this->restrict->restrictLoggedUser();
        $this->title = __('Forgot Password');

        $this->forgotPassAction();
    }  

    public function forgotPassAction(): void
    {
        $rebootCodeCookie = $_COOKIE['reboot_code']; 
        $rebootCodeValue = $_POST['reboot_code'];

        /** validate password */
        $validateCode = password_verify($rebootCodeValue, $rebootCodeCookie);
        $this->validateConfirm($validateCode);
    }

    public function validateConfirm($validateCode): void
    {
        if ( $_POST['confirm'] && $validateCode ) {
            header('Location: ' . HOST . BASE_URL . 'change_pass');
            exit();
        } elseif ( $_POST['confirm'] && !$validateCode ) {
            $this->validateErrors[] = 'Wrong Reboot Code';
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $validateErrors = $this->validateErrors;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Authorize/v_forgot_pass_confirm.php');
        include('View/Base/v_footer.php');
    }
}