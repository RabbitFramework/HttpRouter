<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 31/10/2018
 * Time: 08:38
 */

namespace Xirion\Http\Router\Routes\Path;

use Xirion\DependencyInjector\Container as DIContainer;
use Xirion\DependencyInjector\Factory;
use Xirion\Http\Router\Routes\Injections\ClassExceptionsInjection;
use Xirion\Http\Router\Routes\RouteInterface;

final class ClassPath implements RouteInterface
{

    use PathTrait;

    /**
     * @var object
     */
    private $_class;

    /**
     * @var string
     */
    private $_classMethod;

    /**
     * @var \ReflectionClass
     */
    private $_reflectionClass;

    /**
     * ClassPath constructor.
     * @param $class
     * @param string $method
     * @throws \ReflectionException
     * @throws \Xirion\Bags\Exceptions\BagException
     * @throws \Xirion\Bags\Exceptions\BagNotFoundException
     */
    public function __construct($class, string $method)
    {
        $this->_class = DIContainer::getInstance()->getClass($class);
        $this->_classMethod = $method;
        $this->_reflectionClass = new \ReflectionClass($class);
        $this->_class->routerParameter = DIContainer::getInstance()->getClass(ClassExceptionsInjection::class, ['reflectionClass' => $this->_reflectionClass]);
    }

    /**
     *
     */
    public function call() {
        call_user_func_array([$this->_class, $this->_classMethod], $this->_matches);
        $this->_class->routerParameter->parseExceptions($this->_matches);
    }

}