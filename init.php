<?php
require __DIR__."/vendor/autoload.php";

// Set up DI container
$builder = new \DI\ContainerBuilder();
$builder->useAutowiring(true);
$builder->useAnnotations(false);
$builder->addDefinitions(__DIR__.'/settings.php');
$c = $builder->build();
unset($builder);

// Set up ErrorHandler
App\Helper\ErrorHandler::register($c->get('debug'), $c->get('ErrorHandler.fail_severity'), $c->get('Logger'));
