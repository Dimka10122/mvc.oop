<?php

namespace Controller\Authorize;

use Model\Authorize;
use Model\Includes\Restrict;
use ToHtmlInterface;

class Register implements ToHtmlInterface
{
    public $title;
    private $restrict;
    private $authorize;
    public $fields;
    public $validateErrors = [];
    public $registeredUserErrors = [];

    public function __construct()
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictLoggedUser();
        $this->authorize = new Authorize();

        $this->title = __('Register');

        $this->actionUserData();
    }

    public function actionUserData(): void
    {
        $neededFieldsArray = ['username', 'email', 'password', 'repeat_pass'];

        /** extract */
        $this->fields = extractFields($_POST, $neededFieldsArray);

        /** validate */
        $this->validateErrors = $_POST ? $this->authorize->registerValidate($this->fields) : [];

        if (empty($this->validateErrors) && count($_POST)) {
            $this->validateErrors = $this->authorize->registerUser($this->fields);
            $isUserExists = (bool)$this->validateErrors;

            if (!$isUserExists) {
                $_SESSION['is_user_exists'] = false;
                header('Location: ' . HOST . BASE_URL . 'login');
                exit;
            }
        }
    }

    public function toHtml(): void
    {
        $validateErrors = $this->validateErrors;
        $fields = $this->fields;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Authorize/v_register.php');
        include('View/Base/v_footer.php');
    }
}