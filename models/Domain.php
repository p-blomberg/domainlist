<?php
namespace App\Model;

class Domain {
	public static function get_all(\Predis\Client $redis) {
		return $redis->sort('domains',['ALPHA'=>true]);
	}
	public static function add(string $name, \Predis\Client $redis) {
		if(empty($name)) {
			throw new \App\Helper\AppException("name must not be empty");
		}
		$redis->sadd("domains",$name);
	}
}
