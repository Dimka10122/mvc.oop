<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

/**
 * @param string $url
 * @param array $routes
 * @return array
 */
function parseUrl(string $url, array $routes) : array{
    $result = [
        'controller' => 'errors/e404',
        'params' => []
    ];

    foreach($routes as $route){
        $matches = [];
        if (preg_match($route['regex'], $url, $matches)){
            $result['controller'] = $route['controller'];

            if( isset($route['params'])){
                foreach($route['params'] as $name => $num){
                    $result['params'][$name] = $matches[$num];
                    if ($matches[$num] > 999999999) {
                        header('Location: ' . HOST . BASE_URL . 'error404');
                        exit();
                    }
                }
            }

            break;
        }
    }

    return $result;
}