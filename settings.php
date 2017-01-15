<?php
return [
	'debug' => true,
	'ErrorHandler.fail_severity' => null,
	'Logger' => DI\object('\Monolog\Logger')->constructor('log'),
	'default_controller_name' => 'start',
	'path_views' => __DIR__.'/views/',
	'app_name' => 'Domainlist',
	'Redis' => DI\object('\Predis\Client')->constructor('tcp://localhost:6379'),
	'worker_pidfile_path' => '/run/lock/domainlist_worker.pid',
	'worker_sleep_time' => 3000,
	'domain_data_expire' => 12*60*60,
	'large_update_interval' => 60,
];
