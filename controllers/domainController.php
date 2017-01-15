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
			$this->output_json(["result" => "ok"]);
		} catch(AppException $e) {
			$this->output_json(["result" => "fail", "error" => $e->getMessage()]);
		}
	}
}
