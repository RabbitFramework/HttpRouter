<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 31/10/2018
 * Time: 08:38
 */

namespace Xirion\Http\Router\Routes\Path;

use Xirion\DependencyInjector\Container;
use Xirion\Http\Router\Routes\Injections\FunctionExceptionsInjection;
use Xirion\Http\Router\Routes\RouteInterface;

final class FunctionPath implements RouteInterface
{

    use PathTrait;

    private $_method;

    private $_reflectionMethod;

    private $routerParameter;

    /**
     * ClassPath constructor.
     * @param $class
     * @param string $method
     * @throws \ReflectionException
     * @throws \Xirion\Bags\Exceptions\BagException
     * @throws \Xirion\Bags\Exceptions\BagNotFoundException
     */
    public function __construct($method)
    {
        $this->_method = $method;
        $this->_reflectionMethod = new \ReflectionFunction($method);
        $this->routerParameter = Container::getInstance()->getClass(FunctionExceptionsInjection::class, ['reflectionMethod' => $this->_reflectionMethod]);
    }

    /**
     *
     */
    public function call() {
        $this->_matches[] = &$this->routerParameter;
        call_user_func_array($this->_method, $this->_matches);
        $this->routerParameter->parseExceptions($this->_matches);
    }

}