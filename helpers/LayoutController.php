<?php
namespace App\Helper;
// Because you might want to use the URL /layout for something

class LayoutController extends \App\Controller\Controller {
	protected $controller, $container;

	public function __construct(\App\Controller\Controller $controller, \DI\Container $container) {
		$this->controller = $controller;
		$this->container = $container;

		$this->body = $this->view("layout.php", [
			"controller" => $this->controller,
		]);
	}
}
