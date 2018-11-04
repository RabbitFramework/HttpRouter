<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30/10/2018
 * Time: 22:13
 */

namespace Xirion\Http\Router;

use Xirion\Http\Header\Response as HeaderResponse;
use Xirion\Http\Router\Routes\RouteInterface;

class Router
{

    private $_routes = [];

    public $url;

    public static $_instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if(!isset(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function setUrl($url = '') {
        $this->url = $url;
    }

    public function get(string $path, RouteInterface $route) {
        $route->setPath($path);
        return $this->add($route, 'GET');
    }

    public function post(string $path, RouteInterface $route) {
        $route->setPath($path);
        return $this->add($route, 'POST');
    }

    public function put(string $path, RouteInterface $route) {
        $route->setPath($path);
        return $this->add($route, 'PUT');
    }

    public function patch(string $path, RouteInterface $route) {
        $route->setPath($path);
        return $this->add($route, 'PATCH');
    }

    public function delete(string $path, RouteInterface $route) {
        $route->setPath($path);
        return $this->add($route, 'DELETE');
    }

    public function getRoute(string $name, string $method) {
        if($this->hasRoute($name, $method)) {
            return $this->_routes[$method][$name];
        }
    }

    public function hasRoute(string $name, string $method) {
        if($this->hasMethod($method)) {
            return isset($this->_routes[$method][$name]);
        }
        return false;
    }

    private function add(RouteInterface $route, string $requestMethod) {
        $this->_routes[$requestMethod][] = $route;
        return $route;
    }

    public function run($url = '') {
        if(isset($this->url) || isset($url)) {
            if(!isset($this->routes[HeaderResponse::getRequestMethod()])) {

            }
            foreach ($this->_routes[HeaderResponse::getRequestMethod()] as $route) {
                $route->setUrl($this->url ?? $url);
                if($route->matchAll()) {
                    $route->call();
                }
            }
        }
    }

}