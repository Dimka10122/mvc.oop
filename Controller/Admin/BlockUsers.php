<?php

namespace Controller\Admin;

class BlockUsers implements \toHtml, \checkSessionLogs
{
    public $title;
    private $restrict;
    private $admin;
    public $fields;
    public $validateErrors;
    public $isUserBlocked;

    public function __construct()
    {
        $this->restrict = new \Model\Includes\Restrict();
        $this->restrict->restrictByRole('block_users');
        $this->admin = new \Model\Admin();
        $this->title = __('Block users');

        $this->blockUserAction();
        $this->checkSessionLogs();
    }

    public function blockUserAction(): void
    {
        $neededFieldsArray = ['email', 'block_date'];

        /** extract */
        $this->fields = extractFields($_POST, $neededFieldsArray);

        /** validate */
        $this->validateErrors = $_POST ? $this->admin->blockUserValidate($this->fields) : [];

        if ( $_POST['block_user'] && empty($this->roleValidate) ) {
            $result = $this->admin->blockUserActionChain($this->fields);
            $this->validateErrors = $result;
            if ( count($result) <= 0 ) {
                $_SESSION['is_user_blocked'] = true;
            }
        }
    }

    public function checkSessionLogs(): void
    {
        $this->isUserBlocked = false;
        if (isset($_SESSION['is_user_blocked']) && $_SESSION['is_user_blocked']) {
            $this->isUserBlocked = true;
            unset($_SESSION['is_user_blocked']);
        }
    }

    public function toHtml(): void
    {
        $title = $this->title;
        $validateErrors = $this->validateErrors;
        $fields = $this->fields;
        $isUserBlocked = $this->isUserBlocked;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Admin/v_block.php');
        include('View/Base/v_footer.php');
    }
}

// SELECT * FROM block_users LEFT JOIN users ON users.id = block_users.user_id WHERE email = 'a@gmail.com';