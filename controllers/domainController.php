<?php
namespace App\Controller;

class domainController extends Controller {
	public function add() {
		if(!isset($_POST['name'])) {
			throw new HttpError401("Bad Request; Field missing in POST request: name");
		}
		try {
			$name = $_POST['name'];
			\App\Model\Domain::add($name, $this->container->get('Redis'));
			$this->output_json(["result" => "ok"]);
		} catch(\App\Helper\AppException $e) {
			$this->output_json(["result" => "fail", "error" => $e->getMessage()]);
		}
	}
}
