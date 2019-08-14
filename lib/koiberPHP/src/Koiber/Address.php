<?php

class Address {
    private $country;
    private $state;
    private $city;
    private $address;
    
    public function getCountry() {
        return $this->country;
    }

    public function getState() {
        return $this->state;
    }

    public function getCity() {
        return $this->city;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }
}
