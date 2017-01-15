<?php
namespace App\Helper;

class Route {
	public static function route(string $path_info, string $default_controller_name, \DI\Container $container) {
		$path = explode('/', trim($_SERVER['PATH_INFO'], " \/\t\n\r\0"));
		$contr = array_shift($path);
		if($contr == '') {
			$contr = $default_controller_name;
		}
		$contr = '\App\Controller\\'.$contr.'Controller';

		if(class_exists($contr)) {
			$controller = new $contr($path, $container);
		} else {
			throw new HttpError404("Controller not found: ".$contr);
		}

		return $controller;
	}
}
