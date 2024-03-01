<?php

use App\Container;

use App\Services\Bar;
use App\Services\Baz;
use App\Services\Foo;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{

    protected $container;

    public function setUp():void
    {
        parent::setUp();
        $this->container = new Container;
    }

    public function testSetSimpleService()
    {
        $this->container->set('baz', function () {
            return new Baz;
        });

        $baz = $this->container->get('baz');

        $this->assertInstanceOf('App\Services\Baz', $baz);
    }

    public function testDependenciesHardCode()
    {
        $this->container->set('foo', function () {
            return new Foo;
        });

        $this->container->set('bar', function ($c) {
            return new Bar($c->get('foo'));
        });

        $bar = $this->container->get('bar');

        $this->assertInstanceOf('App\Services\Bar', $bar);
    }


    public function testNormalizeKeyContainer()
    {
        $reflection = new \ReflectionClass($this->container);
        $normalize = $reflection->getMethod('normalize');
        $normalize->setAccessible(true);

        $key = $normalize->invokeArgs($this->container, ['App\Services\Bar']);

        $this->assertEquals('bar', $key);
    }


}