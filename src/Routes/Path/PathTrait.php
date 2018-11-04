<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 03/11/2018
 * Time: 13:50
 */

namespace Xirion\Http\Router\Routes\Path;

trait PathTrait
{

    /**
     * @var string
     */
    public $url = '';

    /**
     * @var string
     */
    public $path = '';

    /**
     * @var array
     */
    public $associativeNames = [];

    private $_matches = [];

    /**
     * @var array
     */
    public $regexContainer = [
        'simple' => '/(?<=\/):([\w]+)/',
        'associative' => ['all' => '/(?<=\/{)([\w]+):([\w]+)(?=})/', 'replacer' => '/{([\w]+):([\w]+)}/']
    ];

    /**
     * @param string $url
     */
    public function setUrl(string $url) {
        $this->url = trim($url, '/');
    }

    /**
     * @param string $path
     */
    public function setPath(string $path) {
        $this->path = trim($path, '/');
    }

    /**
     * @return bool
     */
    public function matchAll() {

        $this->parseParameters();
        if(!preg_match("#^$this->path$#i", $this->url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->_matches = $matches;
        return true;
    }

    /**
     * @return $this
     */
    public function parseParameters() {
        $this->path = preg_replace_callback($this->regexContainer['simple'], function($match) {
            $this->matches[] = $match[1];
            return '([^/]+)';
        }, $this->path);
        return $this;
    }

    /*public function matchAssociativeParameter() {
        preg_match_all($this->regexContainer['associative']['all'], $this->_path, $parameters);
        if($parameters[1] && $parameters[2]) {
            $names = $parameters[1];
            $values = $parameters[2];
            $this->_path = preg_replace_callback($this->regexContainer['associative']['replacer'], function($match) use($names) {
                foreach ($names as $name) {
                    if(strpos($match[1], $name) === false) {
                        $this->matches[$match[1]] = $match[2];
                        return '([^/]+)';
                    }
                }
            }, $this->_path);
            print_r($this->matches);
            return $this;
        }
    }*/

}