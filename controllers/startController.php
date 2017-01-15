<?php
namespace App\Controller;

class startController extends Controller {
	public function index() {
		$this->title = $this->container->get('app_name');
		$this->body = $this->view('start/start.php', [
			'app_name' => $this->container->get('app_name'),
			'domains' => \App\Model\Domain::get_all(),
		]);
	}
}
