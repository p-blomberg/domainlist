<?php
namespace App\Helper;

class ErrorHandler {
	private $debug, $fail_severity;

	public function __construct($debug = false, $fail_severity) {
		$this->debug = $debug;
		$this->fail_severity = $fail_severity;
	}

	public static function register($debug = false, $fail_severity = null) {
		if($fail_severity === null) {
			$fail_severity = E_ALL & ~E_STRICT & ~E_NOTICE & ~E_USER_NOTICE;
		}
		$handler = new static($debug, $fail_severity);
		set_error_handler([$handler, 'handle_error']);
		set_exception_handler([$handler, 'handle_exception']);
		register_shutdown_function([$handler, 'handle_shutdown']);
	}
	public function handle_exception(\Throwable $e) {
		// TODO: logging
		$this->errorpage($e->getMessage());
	}
	public function handle_error($severity, $message, $file, $line) {
		// TODO: logging
		if($severity & $this->fail_severity) {
			$this->errorpage($message);
		}
	}
	public function handle_shutdown() {
		$error = error_get_last();
		if($error === null) {
			return;
		}
		$this->handle_error($error['type'], $error['message'], $error['file'], $error['line']);
	}
	public function errorpage($message) {
		while(ob_get_level() > 0) {
			ob_end_clean();
		}
		header("HTTP/1.0 500 Internal Server Error");
		if($this->debug) {
			echo "Something went wrong: ".$message.PHP_EOL;
		} else {
			echo "An error occurred and the page could not be loaded. Sorry!".PHP_EOL;
		}
		exit;
	}
}
