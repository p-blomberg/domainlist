<?php
namespace App\Controller;

class startController extends Controller {
	public function index() {
		$redis = $this->container->get('Redis');
		$this->title = $this->container->get('app_name');
		$this->body = $this->view('start/start.php', [
			'app_name' => $this->container->get('app_name'),
			'domains' => \App\Model\Domain::fetch_all($redis),
		]);
		$this->scripts = $this->view('start/start_scripts.php');
	}
}
