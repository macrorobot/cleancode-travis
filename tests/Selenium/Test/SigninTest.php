<?php

namespace Selenium\Test;

class SigninTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    const BASE_URL = 'http://192.168.8.43/cleancode';
    public function setUp()
    {
        $this->setHost('127.0.0.1');
        $this->setPort(4444);
        $this->setBrowserUrl(self::BASE_URL);
        $this->setBrowser('chrome');
    }

    public function testFormAction()
    {
        $this->url('signin.php');
        $form = $this->byTag('form');
        $this->assertEquals(self::BASE_URL.'/signin.php', $form->attribute('action'));
    }

    public function testFormMethod()
    {
        $this->url('signin.php');
        $form = $this->byTag('form');
        $this->assertEquals('post', $form->attribute('method'));
    }

    public function testSigninShowForm()
    {
        $this->url('signin.php');

        $username = $this->byName('username');
        $password = $this->byName('password');

        $this->assertEquals('', $username->value());
        $this->assertEquals('', $password->value());
    }

    public function testNoValidForm()
    {
        $this->url('signin.php');
        $form = $this->byTag('form');

        $username = $this->byName('username')->value('toto');
        $password = $this->byName('password')->value('0000');

        $form->submit();

        $this->assertEquals('Signin', $this->title());
    }

    public function testValidForm()
    {
        $this->url('signin.php');
        $form = $this->byTag('form');

        $username = $this->byName('username')->value('toto');
        $password = $this->byName('password')->value('1234');

        $form->submit();

        $this->assertEquals('HomePage', $this->title());
    }
}