<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04/11/2018
 * Time: 14:20
 */

namespace Rabbit\Http\Router\Routes\Injections;


use Rabbit\DependencyInjector\DependencyContainer;

final class FunctionExceptionsInjection implements ExceptionsInjectionInterface
{
    private $_reflectedMethod;
    private $_exceptionsParser;
    private $_exceptions = [
        'date' => [],
        'int' => [],
        'float' => [],
        'boolean' => [],
        'string' => [],
    ];

    public function __construct(\ReflectionFunction $reflectionMethod) {
        $this->_reflectedMethod = $reflectionMethod;
        $this->_exceptionsParser = DependencyContainer::getInstance()->get(ExceptionsParser::class)->getInstance();
    }

    public function exceptDate(string $variableName)
    {
        $parameters = $this->_reflectedMethod->getParameters();
        foreach ($parameters as $parameter) {
            if($variableName === $parameter->name) {
                $this->_exceptions['date'][$variableName] = array_search($parameter, $parameters);
                return;
            }
        }
        throw new ParserExceptions('[Xirion/Http/Router/Injections/FunctionExceptionsInjection => exceptDate] The given variable '.$variableName.' does not exists in the method parameters');
    }

    public function exceptInt(string $variableName)
    {
        $parameters = $this->_reflectedMethod->getParameters();
        foreach ($parameters as $parameter) {
            if($variableName === $parameter->name) {
                $this->_exceptions['int'][$variableName] = array_search($parameter, $parameters);
                return;
            }
        }
        throw new ParserExceptions('[Xirion/Http/Router/Injections/FunctionExceptionsInjection => exceptDate] The given variable '.$variableName.' does not exists in the method parameters');
    }

    public function exceptFloat(string $variableName)
    {
        $parameters = $this->_reflectedMethod->getParameters();
        foreach ($parameters as $parameter) {
            if($variableName === $parameter->name) {
                $this->_exceptions['float'][$variableName] = array_search($parameter, $parameters);
                return;
            }
        }
        throw new ParserExceptions('[Xirion/Http/Router/Injections/FunctionExceptionsInjection => exceptDate] The given variable '.$variableName.' does not exists in the method parameters');
    }

    public function exceptBoolean(string $variableName)
    {
        $parameters = $this->_reflectedMethod->getParameters();
        foreach ($parameters as $parameter) {
            if($variableName === $parameter->name) {
                $this->_exceptions['boolean'][$variableName] = array_search($parameter, $parameters);
                return;
            }
        }
        throw new ParserExceptions('[Xirion/Http/Router/Injections/FunctionExceptionsInjection => exceptDate] The given variable '.$variableName.' does not exists in the method parameters');
    }

    public function exceptString(string $variableName)
    {
        $parameters = $this->_reflectedMethod->getParameters();
        foreach ($parameters as $parameter) {
            if($variableName === $parameter->name) {
                $this->_exceptions['string'][$variableName] = array_search($parameter, $parameters);
                return;
            }
        }
        throw new ParserExceptions('[Xirion/Http/Router/Injections/FunctionExceptionsInjection => exceptDate] The given variable '.$variableName.' does not exists in the method parameters');
    }

    public function parseExceptions(array $matches)
    {
        $this->_exceptionsParser->parseAll($matches, $this->_exceptions);
    }
}