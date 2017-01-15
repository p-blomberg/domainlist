<?php
namespace App\Model;
use \App\Helper\AppException;

class Domain {
	private $redis, $data;
	public function __construct(\Predis\Client $redis, $data) {
		$this->redis = $redis;
		$this->data = $data;
		if(empty($data)) {
			// Domain has just been added - we don't know anything
		}
	}

	public function __get($prop) {
		if(isset($this->data[$prop])) {
			return $this->data[$prop];
		} else {
			throw new AppException("No such property: ".$prop);
		}
	}

	/*
	public static function fetch($redis, $name) {
		$response = $redis->hgetall('domain:'.$name);
		var_dump($response);die();
	}
	*/
	public static function fetch_all(\Predis\Client $redis) {
		$names = $redis->sort('domains', ['ALPHA'=>true]);
		$domains = [];
		foreach($names as $name) {
			$domains[$name] = new Domain($redis, $redis->hgetall('domain:'.$name));
		}
		return $domains;
	}
	public static function add(string $name, \Predis\Client $redis) {
		if(empty($name)) {
			throw new AppException("name must not be empty");
		}
		$redis->sadd("domains",$name);
	}
}
