<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04/11/2018
 * Time: 11:17
 */

namespace Xirion\Http\Router\Routes\Injections;

final class ExceptionsParser implements ExceptionsParserInterface
{
    public $matches;
    private $_exceptions;

    public function setExceptions(array $exceptions) {
        $this->_exceptions = $exceptions;
    }

    public function parseDateExceptions() {
        foreach ($this->_exceptions['date'] as $key => $exception) {
            if(isset($this->matches[$exception])) {
                if(!strtotime($this->matches[$exception])) {
                    throw new ParserExceptions('[Xirion/Http/Router/Injections/ExceptionParser => parseDateExceptions] The given variable '.$key.' is not a date');
                }
            }
        }
        return $this;
    }

    public function parseIntExceptions() {
        foreach ($this->_exceptions['int'] as $key => $exception) {
            if(isset($this->matches[$exception])) {
                if(!intval($this->matches[$exception])) {
                    throw new ParserExceptions('[Xirion/Http/Router/Injections/ExceptionParser => parseIntExceptions] The given variable '.$key.' is not a integer');
                }
            }
        }
        return $this;
    }

    public function parseFloatExceptions() {
        foreach ($this->_exceptions['float'] as $key => $exception) {
            if(isset($this->matches[$exception])) {
                if(!floatval($this->matches[$exception])) {
                    throw new ParserExceptions('[Xirion/Http/Router/Injections/ExceptionParser => parseIntExceptions] The given variable '.$key.' is not a float');
                }
            }
        }
        return $this;
    }

    public function parseBooleanExceptions() {
        foreach ($this->_exceptions['boolean'] as $key => $exception) {
            if(isset($this->matches[$exception])) {
                if(!boolval($this->matches[$exception])) {
                    throw new ParserExceptions('[Xirion/Http/Router/Injections/ExceptionParser => parseBooleanExceptions] The given variable '.$key.' is not a boolean');
                }
            }
        }
        return $this;
    }

    public function parseStringExceptions() {
        foreach ($this->_exceptions['string'] as $key => $exception) {
            if(isset($this->matches[$exception])) {
                if(!is_string($this->matches[$exception]) || intval($this->matches[$exception]) || boolval($this->matches[$exception])) {
                    throw new ParserExceptions('[Xirion/Http/Router/Injections/ExceptionParser => parseStringExceptions] The given variable '.$key.' is not a string');
                }
            }
        }
        return $this;
    }

    public function parseAll(array $matches, array $exceptions) {
        $this->matches = $matches;
        $this->_exceptions = $exceptions;
        $this->parseDateExceptions()->parseIntExceptions()->parseFloatExceptions()->parseBooleanExceptions()->parseStringExceptions();
    }
}