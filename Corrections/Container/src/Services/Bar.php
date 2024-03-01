<?php namespace App\Services;

class Bar {

    protected $foo;

    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }
}