<?php namespace App;

class Container
{

    protected $p = [];
    protected $namespaces = ['\\IoC\\Services'];


    public function set($k, $v)
    {

        if (isset($this->p[$k])) {
            throw new \RuntimeException(sprintf('Cannot override frozen service "%s".', $k));
        }
        $this->p[$k] = $v;
    }

    public function get($k)
    {
        if (!isset($this->p[$k])) {
            throw new \InvalidArgumentException(sprintf('do not know the service: %s', $k));
        }
        if (is_callable($this->p[$k])) {
            return $this->p[$k]($this);
        }

        return $this->p[$k];
    }

    public function make($className)
    {

        $reflection = new \ReflectionClass($className);

        if ($reflection->isInstantiable()) {

            $constructor = $reflection->getConstructor();

            if (is_null($constructor)) return $reflection->newInstance();

            $paramaters = $constructor->getParameters();
            $dependencies = [];
            foreach ($paramaters as $parameter) {
                $dependency = $parameter->getClass();

                if (is_null($dependency)) {
                    if($parameter->isOptional())
                        $dependencies[] = $parameter->getDefaultValue();
                    else
                        $dependencies[] = $this->get($parameter->getName());
                } else {
                    $k = $this->normalize($parameter->getClass()->getName());
                    $dependencies[] = $this->get($k);
                }
            }

            return $reflection->newInstanceArgs($dependencies);

        }
    }

    private function normalize($name)
    {
       return strtolower(substr($name, strrpos($name, '\\')+1));
    }
}
