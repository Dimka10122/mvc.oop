<?php

namespace Controller\Admin;

use ToHtmlInterface;

use Model\Admin;
use Model\Includes\Restrict;

class Statistics implements ToHtmlInterface
{
    private $restrict;
    private $admin;
    public $title;
    public $statsData = [];
    public $statsTypes = [];
    public $statsTimes = [];
    public $validateErrors = [];
    public $fields = [];

    public function __construct()
    {
        $this->restrict = new Restrict();
        $this->restrict->restrictByRole('statistics');
        $this->admin = new Admin();
        $this->title = __("Statistics");

        $this->getStatsDataAction();
        $this->setStatsEvents();
    }

    public function setStatsEvents()
    {
        $this->statsTypes = [
            'visits' => 'Visits',
            'pass_errors' => 'Password Errors',
            'messages' => 'Messages'
        ];
        $this->statsTimes = [
            'today' => 'Today',
            'month' => 'Month',
            'year' => 'Year'
        ];
    }

    public function getStatsDataAction()
    {
        $neededFieldsArray = ['change_chart_controller', 'change_time_gap_controller'];

        /** extract */
        $this->fields = extractFields($_POST, $neededFieldsArray);

        $chartAction = htmlspecialchars($_POST["change_chart_controller"] ?? 'visits');
        $timeGap = htmlspecialchars($_POST["change_time_gap_controller"] ?? 'today') ;
        $this->statsData = $this->admin->getStatsData($chartAction, $timeGap);
    }

    public function toHtml(): void
    {
        $statsData = $this->statsData;
        $title = $this->title;
        $statsTypes = $this->statsTypes;
        $statsTimes = $this->statsTimes;
        $fields = $this->fields;

        include('View/Base/v_header.php');
        include('View/Base/v_content.php');
        include('View/Admin/v_statistics.php');
        include('View/Base/v_footer.php');
    }
}