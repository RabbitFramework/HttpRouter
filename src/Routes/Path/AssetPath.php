<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 13/12/2018
 * Time: 14:53
 */

namespace Rabbit\Http\Router\Routes\Path;


use Rabbit\File\File;
use Rabbit\Http\Router\Routes\RouteInterface;

class AssetPath implements RouteInterface
{

    use PathTrait;

    private $assetPath;

    public function __construct(string $path, string $assetPath)
    {
        $this->assetPath = $assetPath;
        $this->setPath($path);
    }

    public function call() {
        if(file_exists($this->assetPath)) {
            echo File::getContent($this->assetPath);
        }
    }

}