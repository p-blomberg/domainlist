<?php
namespace App\Helper;

class ErrorHandler {
	private $debug, $fail_severity, $logger;

	public function __construct(bool $debug, int $fail_severity, \Psr\Log\LoggerInterface $logger) {
		$this->debug = $debug;
		$this->fail_severity = $fail_severity;
		$this->logger = $logger;
	}

	public static function register(bool $debug = false, int $fail_severity = null, \Psr\Log\LoggerInterface $logger) {
		if($fail_severity === null) {
			$fail_severity = E_ALL & ~E_STRICT & ~E_NOTICE & ~E_USER_NOTICE;
		}
		$handler = new static($debug, $fail_severity, $logger);
		set_error_handler([$handler, 'handle_error']);
		set_exception_handler([$handler, 'handle_exception']);
		register_shutdown_function([$handler, 'handle_shutdown']);
		return $handler;
	}
	public function handle_exception(\Throwable $e) {
		$this->logger->error('Uncaught '.get_class($e).': '.$e->getMessage(), ['exception' => $e]);
		$this->errorpage($e->getMessage());
	}
	public function handle_error(int $severity, string $message, string $file, int $line) {
		$this->logger->error('Uncaught '.self::severity_name($severity).': '.$message.' from '.$file.' on line '.$line);
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
	public function errorpage(string $message) {
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

	public static function severity_name($severity) {
		// Stolen from https://php.net/manual/en/errorfunc.constants.php#109430
		switch($severity) {
			case E_ERROR: // 1 //
				return 'E_ERROR';
			case E_WARNING: // 2 //
				return 'E_WARNING';
			case E_PARSE: // 4 //
				return 'E_PARSE';
			case E_NOTICE: // 8 //
				return 'E_NOTICE';
			case E_CORE_ERROR: // 16 //
				return 'E_CORE_ERROR';
			case E_CORE_WARNING: // 32 //
				return 'E_CORE_WARNING';
			case E_COMPILE_ERROR: // 64 //
				return 'E_COMPILE_ERROR';
			case E_COMPILE_WARNING: // 128 //
				return 'E_COMPILE_WARNING';
			case E_USER_ERROR: // 256 //
				return 'E_USER_ERROR';
			case E_USER_WARNING: // 512 //
				return 'E_USER_WARNING';
			case E_USER_NOTICE: // 1024 //
				return 'E_USER_NOTICE';
			case E_STRICT: // 2048 //
				return 'E_STRICT';
			case E_RECOVERABLE_ERROR: // 4096 //
				return 'E_RECOVERABLE_ERROR';
			case E_DEPRECATED: // 8192 //
				return 'E_DEPRECATED';
			case E_USER_DEPRECATED: // 16384 //
				return 'E_USER_DEPRECATED';
		}
		return '(unknown severity)';
	}
}
