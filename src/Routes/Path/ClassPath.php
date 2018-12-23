<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 31/10/2018
 * Time: 08:38
 */

namespace Rabbit\Http\Router\Routes\Path;

use Rabbit\DependencyContainer\DependencyContainer;
use Rabbit\Http\Router\Routes\Injections\ClassExceptionsInjection;
use Rabbit\Http\Router\Routes\RouteInterface;

final class ClassPath implements RouteInterface
{

    use PathTrait;

    /**
     * @var object
     */
    private $_className;

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
     */
    public function __construct(string $path, $class, string $method)
    {
        $this->_className = $class;
        $this->_classMethod = $method;
        $this->setPath($path);
    }

    /**
     *
     */
    public function call() {
        $this->_class = DependencyContainer::getInstance()->get($this->_className)->getInstance();
        $this->_class->routerParameter = DependencyContainer::getInstance()->get(ClassExceptionsInjection::class)->getInstance(['reflectionClass' => new \ReflectionClass($this->_className)]);
        call_user_func_array([$this->_class, $this->_classMethod], $this->_matches);
        $this->_class->routerParameter->parseExceptions($this->_matches);
    }

}