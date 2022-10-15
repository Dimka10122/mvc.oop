<?php

namespace Controller\Authorize;

use ToHtmlInterface;

use Model\Authorize;
use Model\Includes\Restrict;

class ForgotPass implements ToHtmlInterface
{
    public $title;
    public $fields;
    private $authorize;
    private $restrict;
    public $validateErrors = [];

    public function __construct()
    {
        $this->authorize = new Authorize();
        $this->restrict = new Restrict();
        $this->restrict->restrictLoggedUser();
        $this->title = __('Forgot Password');

        $this->rebootPassAction();
    }

    public function rebootPassAction(): void
    {
        /** extract */

        $neededFieldsArray = ['username', 'email'];
        $this->fields = extractFields($_POST, $neededFieldsArray);

        /** validate */
        $this->validateErrors = $_POST ? $this->authorize->rebootUserCheckExist($this->fields) : [];

        if ($_POST['get_code'] && empty($this->validateErrors)) {
            $_SESSION['username_change_pass'] = $this->fields['username'];
            $rebootCode = $this->authorize->generateRebootCode();
            $this->authorize->sendRebootCode($this->fields, $rebootCode);
            header('Location: ' . HOST . BASE_URL . 'forgot_pass_confirm');
            exit();
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $validateErrors = $this->validateErrors;
        $fields = $this->fields;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Authorize/v_forgot_pass.php');
        include('View/Base/v_footer.php');
    }
}