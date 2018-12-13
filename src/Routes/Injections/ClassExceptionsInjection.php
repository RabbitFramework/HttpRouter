<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 31/10/2018
 * Time: 08:42
 */

namespace Rabbit\Http\Router\Routes\Injections;

use Rabbit\DependencyInjector\DependencyContainer;

final class ClassExceptionsInjection implements ExceptionsInjectionInterface
{

    private $_reflectedClass;
    private $_exceptionsParser;
    private $_exceptions = [
        'date' => [],
        'int' => [],
        'float' => [],
        'boolean' => [],
        'string' => [],
    ];

    public function __construct(\ReflectionClass $reflectionClass) {
        $this->_reflectedClass = $reflectionClass;
        $this->_exceptionsParser = DependencyContainer::getInstance()->get(ExceptionsParser::class)->getInstance();
    }

    public function exceptDate(string $variableName) {
        $callerMethod = $this->getCallerMethod();
        if($callerMethod) {
            $parameters = $this->_reflectedClass->getMethod($callerMethod)->getParameters();
            foreach ($parameters as $parameter) {
                if($variableName === $parameter->name) {
                    $this->_exceptions['date'][$variableName] = array_search($parameter, $parameters);
                    return;
                }
            }
            throw new ParserExceptions('[Xirion/Http/Router/Injections/ClassExceptionsInjection => exceptDate] The given variable '.$variableName.' does not exists in the method parameters');
        }
    }

    public function exceptInt(string $variableName) {
        $callerMethod = $this->getCallerMethod();
        if($callerMethod) {
            $parameters = $this->_reflectedClass->getMethod($callerMethod)->getParameters();
            foreach ($parameters as $parameter) {
                if($variableName === $parameter->name) {
                    $this->_exceptions['int'][$variableName] = array_search($parameter, $parameters);
                    return;
                }
            }
            throw new ParserExceptions('[Xirion/Http/Router/Injections/ClassExceptionsInjection => exceptInt] The given variable '.$variableName.' does not exists in the method parameters');
        }
    }

    public function exceptFloat(string $variableName) {
        $callerMethod = $this->getCallerMethod();
        if($callerMethod) {
            $parameters = $this->_reflectedClass->getMethod($callerMethod)->getParameters();
            foreach ($parameters as $parameter) {
                if($variableName === $parameter->name) {
                    $this->_exceptions['float'][$variableName] = array_search($parameter, $parameters);
                    return;
                }
            }
            throw new ParserExceptions('[Xirion/Http/Router/Injections/ClassExceptionsInjection => exceptFloat] The given variable '.$variableName.' does not exists in the method parameters');
        }
    }

    public function exceptBoolean(string $variableName) {
        $callerMethod = $this->getCallerMethod();
        if($callerMethod) {
            $parameters = $this->_reflectedClass->getMethod($callerMethod)->getParameters();
            foreach ($parameters as $parameter) {
                if($variableName === $parameter->name) {
                    $this->_exceptions['boolean'][$variableName] = array_search($parameter, $parameters);
                    return;
                }
            }
            throw new ParserExceptions('[Xirion/Http/Router/Injections/ClassExceptionsInjection => exceptBoolean] The given variable '.$variableName.' does not exists in the method parameters');
        }
    }

    public function exceptString(string $variableName) {
        $callerMethod = $this->getCallerMethod();
        if($callerMethod) {
            $parameters = $this->_reflectedClass->getMethod($callerMethod)->getParameters();
            foreach ($parameters as $parameter) {
                if($variableName === $parameter->name) {
                    $this->_exceptions['string'][$variableName] = array_search($parameter, $parameters);
                    return;
                }
            }
            throw new ParserExceptions('[Xirion/Http/Router/Injections/ClassExceptionsInjection => exceptString] The given variable '.$variableName.' does not exists in the method parameters');
        }
    }

    public function parseExceptions(array $matches) {
        $this->_exceptionsParser->parseAll($matches, $this->_exceptions);
    }

    private function getCallerMethod() {
        return debug_backtrace()[2]['function'] ?? '';
    }

}