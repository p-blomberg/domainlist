<?php
return [
	'debug' => true,
	'ErrorHandler.fail_severity' => null,
	'Logger' => DI\object('\Monolog\Logger')->constructor('log'),
	'default_controller_name' => 'start',
	'path_views' => __DIR__.'/views/',
	'app_name' => 'Domainlist',
];
