<?php
require __DIR__."/vendor/autoload.php";

// Set up DI container
$builder = new \DI\ContainerBuilder();
$builder->useAutowiring(true);
$builder->useAnnotations(false);
$builder->addDefinitions(__DIR__.'/settings.php');
$container = $builder->build();
unset($builder);

// Set up ErrorHandler
App\Helper\ErrorHandler::register($container->get('debug'), $container->get('ErrorHandler.fail_severity'), $container->get('Logger'));
