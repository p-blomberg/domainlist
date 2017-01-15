<?php
require __DIR__.'/init.php';

// Set up pid file and make sure we remove it when we're done
if(file_exists($container->get('worker_pidfile_path'))) {
	throw new Exception('A worker is already running');
} else {
	file_put_contents($container->get('worker_pidfile_path'), getmypid(), LOCK_EX);
}
function remove_pidfile($worker_pidfile_path) {
	unlink($worker_pidfile_path);
}
$running = true;
function handle_signal($signal) {
	global $running;
	echo "Received interrupt, shutting down\n";
	$running = false;
}
declare(ticks=1);
pcntl_signal(SIGINT, 'handle_signal');
pcntl_signal(SIGTERM, 'handle_signal');
register_shutdown_function('remove_pidfile', $container->get('worker_pidfile_path'));

// Prepare some stuff
$redis = $container->get('Redis');
$logger = $container->get('Logger');
$logger->info('Worker started');
$large_update_timestamp = 0;

use \App\Model\Domain;
use \App\Helper\AppException;

function update($logger, $redis, $domain_data_expire) {
	$logger->debug('Fetching next domain');
	$name = $redis->lpop('update_domains');

	try {
		if($name !== null) {
			$logger->debug('Updating: '.$name);
			Domain::update($redis, $name, $domain_data_expire);
		}
	} catch(AppException $e) {
		$logger->error('catched exception from update: '.$e->getMessage());
		// Add it back to the queue, so we can fail again in three seconds! Yeah! =)
		$redis->lpush('update_domains', $name);
	}
}
function large_update($logger, $redis, $domain_data_expire) {
	$large_update_timestamp = time();
	$logger->debug('Checking for missing domains');
	Domain::check_missing($redis, $domain_data_expire);
	return $large_update_timestamp;
}

// The worker loop
while(true) {
	update($logger, $redis, $container->get('domain_data_expire'));

	if($large_update_timestamp + $container->get('large_update_interval') < time()) {
		large_update($logger, $redis, $container->get('domain_data_expire'));
	}

	if($running) {
		$logger->debug('Sleeping');
		usleep($container->get('worker_sleep_time')*1000);
	} else {
		break 1;
	}
}
