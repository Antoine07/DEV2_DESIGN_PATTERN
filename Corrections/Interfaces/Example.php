<?php

// une signature qui définit un comportement que les classes qui implémentent cette interface devront définir
// comme vous définissez des comportements pour vos classes les méthodes doivent être en public
interface UserInterface {
    public function get():string ;
    public function toUpperName(string $name) : string ;
}

class User implements UserInterface {

    private string $name ;
    public function get():string{
        return $this->name ;
    }
    public function toUpperName(string $name) : string{

        return strtoupper($this->name) ;
    }

    public function set(string $name) :void {
        $this->name = $name ;
    }
}

$user = new User;