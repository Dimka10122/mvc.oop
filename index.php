<?php

session_start();

/** Init web-page */
include_once('init.php');

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
    $routes = include('routes.php');
    $url = $_GET['mvcsystemurl'] ?? '';

    $routerRes = parseUrl($url, $routes);

    $cname = $routerRes['controller'];

    $urlLen = strlen($url);
    
    if ($urlLen > 0 && $url[$urlLen - 1] == '/'){
        $url = substr($url, 0, $urlLen - 1);
    }
}

$userInfo = new \Model\Includes\UserInfo();
$userInfo->setUserView();

$path = "Controller/$cname.php";
include_once($path);
$controller = getControllerName($path);

/** @var string $routerRes */
$createController = new $controller($routerRes);
$createController->toHtml();