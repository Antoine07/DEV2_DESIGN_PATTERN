<?php namespace App\Services;
class SuperBar
{


    protected $foo;
    protected $bar;

    protected $param;

    protected $default;

    public function __construct(Foo $foo, Baz $baz,$param, $default = [])
    {
        $this->foo = $foo;
        $this->baz = $baz;
        $this->param = $param;

        $this->default = $default;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }



}