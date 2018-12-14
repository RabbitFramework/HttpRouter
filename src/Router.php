<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30/10/2018
 * Time: 22:13
 */

namespace Rabbit\Http\Router;

use Rabbit\DependencyContainer\DependencyContainer;
use Rabbit\Http\Router\Routes\Path\ClassPath;
use Rabbit\Http\Router\Routes\RouteInterface;

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

    protected function __construct()
    {
    }

    public function setUrl($url = '') {
        $this->url = $url;
    }

    public function get(RouteInterface $route) {

        return $this->add($route, 'GET');
    }

    public function post(RouteInterface $route) {
        return $this->add($route, 'POST');
    }

    public function put(RouteInterface $route) {
        return $this->add($route, 'PUT');
    }

    public function patch(RouteInterface $route) {
        return $this->add($route, 'PATCH');
    }

    public function delete(RouteInterface $route) {
        return $this->add($route, 'DELETE');
    }

    public function ressource(string $path, string $class) {
        $methods = get_class_methods($class);
        foreach ($methods as $method) {
            $method = DependencyContainer::getInstance()->get($class)->getMethod($method)->getInformation();
            switch ($method->name) {
                case 'index':
                    $this->get(new ClassPath($path.'/', $class, $method->name));
                    break;
                case 'show':
                    foreach ($method->parameters as $parameter) {
                        $path .= '/:'.$parameter->name;
                    }
                    $this->get(new ClassPath($path, $class, $method->name));
                    break;
                case 'store':
                    $this->post(new ClassPath($path, $class, $method->name));
                    break;
                case 'update':
                    foreach ($method->parameters as $parameter) {
                        $path .= '/:'.$parameter->name;
                    }
                    $path = new ClassPath($path, $class, $method->name);
                    $this->put($path);
                    $this->patch($path);
                    break;
                case 'destroy':
                    foreach ($method->parameters as $parameter) {
                        $path .= '/:'.$parameter->name;
                    }
                    $this->delete(new ClassPath($path, $class, $method->name));
                    break;
            }
        }
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
//            if(empty($this->routes[$_SERVER['REQUEST_METHOD']])) {
//                return;
//            }
            foreach ($this->_routes[$_SERVER['REQUEST_METHOD']] as $route) {
                $route->setUrl($this->url ?? $url);
                if($route->matchAll()) {
                    $route->call();
                }
            }
        }
    }

}