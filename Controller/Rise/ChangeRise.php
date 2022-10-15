<?php

namespace Controller\Rise;

use ToHtmlInterface;

use Model\Includes\Restrict;
use Model\Rise;

class ChangeRise implements ToHtmlInterface
{
    public $title;
    private $rise;
    private $restrict;

    public function __construct()
    {
        $this->rise = new Rise();
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('rise_users');
        $this->title = __('Upgrade User Role');
    }

    public function toHtml(): void
    {
        $title = $this->title;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Rise/v_change_rise.php');
        include('View/Base/v_footer.php');
    }
}