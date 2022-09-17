<?php

function getControllerName(string $path) : string {
    $carr = str_replace("/", DIRECTORY_SEPARATOR, $path);
    $result = explode('.', $carr);
    return $result[0];
}
