<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04/11/2018
 * Time: 14:21
 */

namespace Rabbit\Http\Router\Routes\Injections;


interface ExceptionsParserInterface
{

    public function setExceptions(array $exceptions);

    public function parseDateExceptions();

    public function parseIntExceptions();

    public function parseFloatExceptions();

    public function parseBooleanExceptions();

    public function parseStringExceptions();

    public function parseAll(array $matches, array $exceptions);

}