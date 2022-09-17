<?php

namespace Controller\Authorize;

class Login implements \toHtml, \checkSessionLogs
{
    public $title;
    private $restrict;
    private $authorize;
    public $fields;
    public $loggedErrors = [];
    public $successChangePass;
    public $isExistsUser;

    public function __construct()
    {
        $this->restrict = new \Model\Includes\Restrict;
        $this->restrict->restrictLoggedUser();
        $this->authorize = new \Model\Authorize;
        $this->title = __('Login');

        $this->checkSessionLogs();
        $this->loginUserAction();
    }

    public function checkSessionLogs(): void
    {
        $this->isExistsUser = false;
        if ( isset($_SESSION['is_user_exists']) && !$_SESSION['is_user_exists'] ) {
            $this->isExistsUser = true;
            unset($_SESSION['is_user_exists']);
        }

        $this->successChangePass = false;
        if ( isset($_SESSION['success_change_pass']) && $_SESSION['success_change_pass'] ) {
            $this->successChangePass = true;
            unset($_SESSION['success_change_pass']);
        }
    }

    public function loginUserAction(): void
    {
        /** extract */
        $neededFieldsArray = ['username', 'password', 'remember_user'];

        /** extract */
        $this->fields = extractFields($_POST, $neededFieldsArray);
        $isUserBlocked = $_POST ? $this->authorize->checkUserIsBlocked($this->fields) : false;

        if (
            isset($_POST['login']) &&
            $isUserBlocked !== true
        ) {
            $this->loggedErrors = $this->authorize->loginUser($this->fields);
            if (empty($this->loggedErrors)) {
                header('Location: ' . HOST . BASE_URL);
                exit;
            }
        } elseif (
            isset($_POST['login']) &&
            $isUserBlocked
        ) {
           $this->loggedErrors[] = 'The account you are trying to log in is blocked';
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $loggedErrors = $this->loggedErrors;
        $fields = $this->fields;
        $successChangePass = $this->successChangePass;;
        $isExistsUser = $this->isExistsUser;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Authorize/v_login.php');
        include('View/Base/v_footer.php');
    }
}

?>