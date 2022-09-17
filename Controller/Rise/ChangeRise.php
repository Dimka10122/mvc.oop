<?php

namespace Controller\Rise;

class ChangeRise
{
    public $title;
    private $rise;
    private $restrict;

    public function __construct()
    {
        $this->rise = new \Model\Rise();
        $this->restrict = new \Model\Includes\Restrict();
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