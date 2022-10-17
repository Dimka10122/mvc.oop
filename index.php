<?php

session_start();

/** Init web-page */
include_once('bootstrap.php');

/** @var string $left */
$left = '';

/**
 * @var string $title
 * @var string $content
 */
$title = $content = 'Error 404';
$uri = $_SERVER['REQUEST_URI'];
$badUrl = BASE_URL . 'index.php';

if (strpos($uri, $badUrl) === 0){
    $cname = 'errors/e404';
} else {
    /** get xml data */
    $xml = simplexml_load_file('./assets/xml/routes.xml');
    $routes = $xml->children();

    $url = $_GET['mvcsystemurl'] ?? '';

    $routerRes = parseUrl($url, $routes);

    $cname = $routerRes['controller'];

    $urlLen = strlen($url);
    
    if ($urlLen > 0 && $url[$urlLen - 1] == '/'){
        $url = substr($url, 0, $urlLen - 1);
    }
}

$path = "Controller/$cname.php";
include_once($path);
$controller = getControllerName($path);

/** @var string $routerRes */
$createController = new $controller($routerRes);
$createController->toHtml();