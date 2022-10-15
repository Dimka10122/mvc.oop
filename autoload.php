<?php

spl_autoload_register(function ($className) {
    include(__DIR__ . DIRECTORY_SEPARATOR . $className . ".php");
});