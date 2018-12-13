<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04/11/2018
 * Time: 14:21
 */

namespace Rabbit\Http\Router\Routes\Injections;


interface ExceptionsInjectionInterface
{

    public function exceptDate(string $variableName);

    public function exceptInt(string $variableName);

    public function exceptFloat(string $variableName);

    public function exceptBoolean(string $variableName);

    public function exceptString(string $variableName);

    public function parseExceptions(array $matches);

}