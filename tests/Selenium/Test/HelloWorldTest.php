<?php

namespace Selenium\Test;

class HelloWorldTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    public function setUp()
    {
        $this->setHost('127.0.0.1');
        $this->setPort(4444);
        $this->setBrowserUrl('http://192.168.8.43/cleancode');
        $this->setBrowser('chrome');
    }

    public function testHelloWorld()
    {
        $this->url('index.php');
        $text = $this->byTag('h1')->text();
        $this->assertEquals('Hello, World', $text);
    }
}