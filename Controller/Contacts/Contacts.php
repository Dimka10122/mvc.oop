<?php

namespace Controller\Contacts;

class Contacts implements \toHtml
{
    public $title;

    public function __construct()
    {
        $this->title = __("Contacts");
    }

    public function toHtml(): void
    {
        $title = $this->title;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Contacts/v_index.php');
        include('View/Base/v_footer.php');
    }
}

?>