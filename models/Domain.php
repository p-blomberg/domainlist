<?php
namespace App\Model;
use \App\Helper\AppException;

class Domain {
	private $redis, $name, $data;

	public function __construct(\Predis\Client $redis, $name, $data) {
		$this->redis = $redis;
		$this->name = $name;
		$this->data = $data;
	}

	public function __get($prop) {
		if(isset($this->data[$prop])) {
			return unserialize($this->data[$prop]);
		} else {
			throw new AppException("No such property: ".$prop);
		}
	}

	public function commit($expire) {
		$this->redis->hmset('domain:'.$this->name, $this->data);
		$this->redis->expire('domain:'.$this->name, $expire);
	}

	public static function delete(string $name, $redis) {
		$redis->srem('domains', $name);
		$redis->lrem('update_domains', 0, $name);
		$redis->del('domain:'.$name);
	}
	public static function update($redis, $name, $domain_data_expire) {
		try {
			$records = \App\Helper\Resolver::resolve('NS', $name);
		} catch(\Exception $e) {
			throw new AppException(get_class($e)." from Resolver: ".$e->getMessage());
		}
		$ns = [];
		foreach($records as $r) {
			$ns[] = $r->getData();
		}
		$data['ns'] = serialize($ns);
		$domain = new Domain($redis, $name, $data);
		$domain->commit($domain_data_expire);
	}
	public static function fetch($redis, $name) {
		return new Domain($redis, $name, $redis->hgetall('domain:'.$name));
	}
	public static function fetch_all(\Predis\Client $redis) {
		$names = $redis->sort('domains', ['ALPHA'=>true]);
		$domains = [];
		foreach($names as $name) {
			$domains[$name] = Domain::fetch($redis, $name);
		}
		return $domains;
	}
	public static function add(string $name, \Predis\Client $redis) {
		if(empty($name)) {
			throw new AppException("name must not be empty");
		}
		$redis->sadd("domains",$name);
		$redis->rpush("update_domains",$name);
	}
	public static function check_missing($redis) {
		$names = $redis->sort('domains', ['ALPHA'=>true]);
		foreach($names as $name) {
			if(!$redis->exists('domain:'.$name)) {
				// TODO: check if the domain is in the list already
				$redis->rpush("update_domains",$name);
			}
		}
	}
}
