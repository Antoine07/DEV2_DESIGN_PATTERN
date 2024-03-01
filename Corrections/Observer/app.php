<?php

class User implements \SplSubject{
    private array $observers = [] ;
    private $id;
    private string $name;
    private string $email;

    /**
     * attache un observateur
     *
     * @param SplObserver $observer
     */
    public function attach(\SplObserver $observer):void {
        $this->observers[] = $observer;
    }

    /**
     * Détache un observateur
     *
     * @param SplObserver $observer
     */
    public function detach(\SplObserver $observer):void {

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
        $this->setName($name);
        $this->setEmail($email);

        $this->id = uniqid(true);

        $this->notify();
    }

    /**
     * Notifier une action
     */
    public function notify():void {

        foreach ($this->observers as $observer) {

            $observer->update($this); // on appelle chaque méthode update de chaque observer en leur passant l'objet User lui-même
        }
    }

    public function last_id(){
        return $this->id;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}


class LogArray implements SplObserver{

    private array $ids = [] ;

    public function update(SplSubject $subject):void{
        $this->ids[$subject->getName()] =[ $subject->last_id(), $subject->getEmail()] ;
    }

    public function getIds():array{
        return $this->ids ;
    }
}

class LogEcho implements SplObserver{

    public function update(SplSubject $subject):void {
        echo $subject->last_id() . "\n" ;
    }
}


$user = new User ;

$logArray = new LogArray;
$logEcho = new LogEcho;
$user->attach($logArray) ;
$user->attach($logEcho) ;

$user->create(email : 'alan@alan.fr', name: 'alan') ;
$user->create(email : 'alice@alice.fr', name: 'alice') ;
$user->create(email : 'lucie@lucie.fr', name: 'lucie') ;
// $user->detach($logArray);

$ids = $logArray->getIds();

var_dump($ids) ;