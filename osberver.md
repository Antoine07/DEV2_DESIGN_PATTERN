# Exercice Observer

à chaque fois que l'on crée un utilisateur on notifiera l'id de cette utilisateur dans deux observeurs :

1. LogArray , feature : set l'id dans un array 
1. LogEcho , feature : affiche l'id de l'utilisateur ajouté
   
```php
// implémente une interface SplSubject
class User implements \SplSubject{

    private $id;
    /**
     * attache un observateur
     *
     * @param SplObserver $observer
     */
    public function attach(\SplObserver $observer) {
        $this->observers[] = $observer;
    }

    /**
     * Détache un observateur
     *
     * @param SplObserver $observer
     */
    public function detach(\SplObserver $observer) {

        $key = array_search($observer,$this->observers, true);
        if($key){
            unset( $this->observers[$key]);
        }
    }

    /**
     * @param string $name
     * @param string $email
     */
    public function create(string $name, string $email):void {

        // method to insert data

        $this->id = uniqid(true);

        $this->notify();
    }

    /**
     * Notifier une action
     */
    public function notify() {

        foreach ($this->observers as $value) {

            $value->update($this);
        }
    }

    public function last_id(){
        return $this->id;
    }
}

// création des observers 

class LogArray implements \SplObserver{

    public function update($o){

    }
}
```

