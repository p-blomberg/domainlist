<?php
namespace App\Controller;

class Controller {
	protected $title, $body, $scripts, $container;

	protected function view(string $view, array $data=[]): string {
		extract($data);
		ob_start();
		require($this->container->get('path_views').$view);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public function route(array $path) {
		$func = 'index';
		if(count($path) > 0) {
			$func = array_shift($path);
			if($func == '') {
				$func = 'index';
			}
		}

		$rr = array($this, 'route_replace');
		if(is_callable($rr)) {
			$func = call_user_func_array($rr, array($func));
		}

		$func = array($this, $func);
		if(!is_callable($func)) {
			throw new \App\Helper\HttpError404();
		}

		return call_user_func_array($func, $path);
	}

	public function __construct(array $path = [], \DI\Container $container) {
		$this->container = $container;
		return $this->route($path);
	}

	public function title(): string {
		return $this->title;
	}
	public function body(): string {
		return $this->body;
	}
	public function scripts(): string {
		return $this->scripts;
	}

	protected function output_json($data) {
		echo json_encode($data);
		exit;
	}
}
