<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 31/10/2018
 * Time: 08:38
 */

namespace Rabbit\Http\Router\Routes\Path;

use Rabbit\DependencyInjector\DependencyContainer;
use Rabbit\Http\Router\Routes\Injections\FunctionExceptionsInjection;
use Rabbit\Http\Router\Routes\RouteInterface;

final class FunctionPath implements RouteInterface
{

    use PathTrait;

    private $_function;

    private $_reflectionFunction;

    private $_routerParameter;

    /**
     * ClassPath constructor.
     * @param string $path
     * @param $function
     * @throws \ReflectionException
     */
    public function __construct(string $path, $function)
    {
        $this->_function = $function;
        $this->_reflectionFunction = new \ReflectionFunction($function);
        $this->_routerParameter = DependencyContainer::getInstance()->get(FunctionExceptionsInjection::class)->getInstance(['reflectionMethod' => $this->_reflectionFunction]);
        $this->setPath($path);
    }

    /**
     *
     */
    public function call() {
        $this->_matches[] = &$this->_routerParameter;
        call_user_func_array($this->_function, $this->_matches);
        $this->_routerParameter->parseExceptions($this->_matches);
    }

}