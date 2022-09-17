<?php

namespace Controller\Authorize;

class ChangePass implements \toHtml
{
    public $title;
    public $validateErrors = [];
    private $authorize;
    private $restrict;
    public $fields;

    public function __construct()
    {
        $this->authorize = new \Model\Authorize;
        $this->restrict = new \Model\Includes\Restrict;
        $this->restrict->restrictLoggedUser();
        $this->title = __('Change Password');
        
        $this->changePassAction();
    }

    public function changePassAction(): void
    {
        $neededFieldsArray = ['new_password', 'new_password_repeat'];
        
        /** extract */
        $this->fields = extractFields($_POST, $neededFieldsArray);
        
        /** validate */
        $this->validateErrors = $_POST ? $this->authorize->updatePasswordValidate($this->fields) : [];
        
        /** delete code cookie */
        setcookie('reboot_code', null, -2147483647);

        if ( $_POST && empty($this->validateErrors) ) {
            $this->authorize->updatePassword($this->fields['new_password']);
            header('Location: ' . HOST . BASE_URL . 'login');
            exit;
        }
    }

    public function toHtml(): void
    {
        $fields = $this->fields;
        $validateErrors = $this->validateErrors;
        $title = $this->title;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Authorize/v_change_pass.php');
        include('View/Base/v_footer.php');
    }
}

?>