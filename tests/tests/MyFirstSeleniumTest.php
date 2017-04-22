<?php
class MyFirstSeleniumTest extends PHPUnit_Extensions_Selenium2TestCase {
	public static $browsers = [
		['browserName' => 'firefox'],
		['browserName' => 'chrome'],
	];

	protected function setUp() {
		$this->setBrowserUrl('http://localhost/');
	}

	public function testTitle() {
		$this->url('http://localhost/');
		$this->assertEquals('Domain Overview', $this->title());
	}
}
