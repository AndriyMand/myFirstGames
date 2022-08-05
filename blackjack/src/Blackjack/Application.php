<?php

namespace Blackjack;

class Application
{
    public static function run($config)
    {
        $route      = self::route($config['url']['base']);
        $controller = new $route['controller'];
        return $controller->dispatch($route['action'], $config);
    }
    
    private static function route($baseUrl)
    {
        $url = parse_url($_SERVER['REQUEST_URI']);
        @list($url['controller'], $url['action']) = explode('/', str_replace(str_replace($_SERVER['SERVER_NAME'], '', $baseUrl), '', $url['path']));
        $url['controller'] = __NAMESPACE__ . '\\Controller\\' . ucfirst((empty($url['controller']) ? 'Game' : $url['controller']) . 'Controller');
        $url['action']     = (empty($url['action']) ? 'index' : $url['action']);
        return $url;
    }
}