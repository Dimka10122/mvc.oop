<?php

namespace Controller\CLI;

use ToHtmlInterface;

class CLI implements ToHtmlInterface
{
    public $output;

    public function __construct() {
        $this->returnCommandResult();
    }

    public function returnCommandResult()
    {
        if (isset($_POST)) {
            $query = json_decode(file_get_contents("php://input"), true);
            $command = htmlspecialchars(trim($query["command"]));
            exec($command, $this->output);
        }
    }

    public function toHtml(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->output, true);
    }
}