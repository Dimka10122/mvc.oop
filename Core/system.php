<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

/**
 * @param string $url
 * @param object $routes xml
 * @return array
 */
function parseUrl(string $url, object $routes) : array{
    $result = [
        'controller' => 'errors/e404',
        'params' => []
    ];

    $jsonRoutes = json_encode($routes);
    $parsedRoutes = json_decode($jsonRoutes, true);

    foreach ($parsedRoutes as $route) {
        for ($i = 0; $i < count($route); $i++) {
            $allKeys = array_keys($route);
            $routeName = $allKeys[$i];

            $matches = [];

            if (preg_match($route[$routeName]['regex'], $url, $matches)) {
                $result['controller'] = $route[$routeName]['controller'];

                if (isset($route[$routeName]['params'])) {
                    foreach($route[$routeName]['params'] as $name => $num){
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
    }

    return $result;
}