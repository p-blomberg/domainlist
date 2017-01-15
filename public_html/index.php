<?php
require dirname(__DIR__)."/init.php";

if(!isset($_SERVER['PATH_INFO'])) {
	throw new Exception("PATH_INFO is not set");
}

try {
	$controller = \App\Helper\Route::route($_SERVER['PATH_INFO'], $container->get('default_controller_name'), $container);

	$layout = new \App\Helper\LayoutController($controller, $container);
	echo $layout->body();

} catch(\App\Helper\HttpError $e) {
	header('HTTP/1.0 '.$e->getCode());
	die($e->getMessage());
	// *FIXME*: nice 404/error page
}
