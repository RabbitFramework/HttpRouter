<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 02/11/2018
 * Time: 11:32
 */

namespace Rabbit\Http\Router\Routes;


use Rabbit\DependencyInjector\Container;
use Rabbit\Http\Router\Routes\Path\ClassPath;
use Rabbit\Http\Router\Routes\Path\FunctionPath;

class Factory
{

    public static function makeClass($class, $method) {
        return Container::getInstance()->getClass(ClassPath::class, ['class' => $class, 'method' => $method]);
    }

    public static function makeFunction($function) {
        return Container::getInstance()->getClass(FunctionPath::class, ['method' => $function]);
    }

    public static function makeRule() {

    }

}