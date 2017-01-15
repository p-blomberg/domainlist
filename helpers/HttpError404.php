<?php
namespace App\Helper;

class HttpError404 extends \App\Helper\HttpError {
	public function __construct($message = "File not found") {
		$this->code = 404;
		parent::__construct($message);
	}
}
