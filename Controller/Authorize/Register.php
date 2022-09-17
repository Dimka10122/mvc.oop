<?php

namespace Controller\Authorize;

class Register implements \toHtml
{
    public $title;
    private $restrict;
    private $authorize;
    public $fields;
    public $validateErrors = [];
    public $registeredUserErrors = [];

    public function __construct()
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictLoggedUser();
        $this->authorize = new \Model\Authorize();
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

        if ( empty($this->validateErrors) && count($_POST) ) {
            $this->registeredUserErrors = $this->authorize->registerUser($this->fields);
            $isUserExists = $this->registeredUserErrors ? true : false;
            if ( !$isUserExists ) {
                $_SESSION['is_user_exists'] = $isUserExists;
                header('Location: ' . HOST . BASE_URL . 'login');
                exit;
            }
        }
    }

    public function toHtml(): void
    {
        $validateErrors = $this->validateErrors;
        $registeredUserErrors = $this->registeredUserErrors;
        $fields = $this->fields;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Authorize/v_register.php');
        include('View/Base/v_footer.php');
    }
}

?>