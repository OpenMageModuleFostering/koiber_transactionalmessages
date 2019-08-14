<?php

class User {
    private $id;
    private $mail;
    private $phoneDDI;
    private $phoneNumber;
    private $name;
    
    /**
     *
     * @var Address
     */
    private $address;
    
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getPhoneDDI() {
        return $this->phoneDDI;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }
    
    public function getName() {
        return $this->name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setMail($mail) {
        $this->mail = $mail;
        return $this;
    }

    public function setPhoneDDI($phoneDDI) {
        $this->phoneDDI = $phoneDDI;
        return $this;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function setAddress(Address $address) {
        $this->address = $address;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
}
