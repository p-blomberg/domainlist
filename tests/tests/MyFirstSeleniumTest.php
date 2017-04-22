<?php
class MyFirstSeleniumTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost/');
    }

    public function testTitle()
    {
        $this->url('http://localhost/');
        $this->assertEquals('Domain Overview', $this->title());
    }

}
