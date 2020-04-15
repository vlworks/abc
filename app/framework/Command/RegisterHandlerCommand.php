<?php


namespace Framework\Command;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class RegisterHandlerCommand implements CommandInterface
{
    private $command;

    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
    }

    public function execute(): void
    {
        try {
            $fileLocator = new FileLocator(__DIR__ . DIRECTORY_SEPARATOR . 'config');
            $loader = new PhpFileLoader($this->command, $fileLocator);
            $loader->load('parameters.php');
        } catch (\Throwable $e) {
            die('Cannot read the config file. File: ' . __FILE__ . '. Line: ' . __LINE__);
        }
    }

}