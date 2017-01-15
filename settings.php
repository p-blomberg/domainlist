<?php
return [
	'debug' => true,
	'ErrorHandler.fail_severity' => null,
	'Logger' => DI\object('\Monolog\Logger')->constructor('log'),
];
