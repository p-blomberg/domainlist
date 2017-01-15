<?php
namespace App\Controller;
use \App\Model\Domain;
use \App\Helper\AppException;

class domainController extends Controller {
	public function add() {
		if(!isset($_POST['name'])) {
			throw new HttpError401("Bad Request; Field missing in POST request: name");
		}
		try {
			$name = $_POST['name'];
			Domain::add($name, $this->container->get('Redis'));
			$this->json_data = ["result" => "ok"];
		} catch(AppException $e) {
			$this->json_data = ["result" => "fail", "error" => $e->getMessage()];
		}
	}

	public function list_tbody() {
		$this->use_layout = false;
		$redis = $this->container->get('Redis');
		$this->body = $this->view("domain/list_tbody.php", [
			'domains' => \App\Model\Domain::fetch_all($redis),
		]);
	}
}
