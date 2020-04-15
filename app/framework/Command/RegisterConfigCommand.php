<?php


namespace Framework\Command;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class RegisterConfigCommand
{
    private $fileLocator;
    private $loader;
    protected $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    public function getContainerBuilder(){
        return $this->containerBuilder;
    }


}