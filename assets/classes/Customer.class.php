<?php

class Customer {

    private $name;
    private $phoneMMC;
    private $phone;
    private $address;
    private $postcode;
    private $city;
    private $state;

    public function __construct($name, $phoneMMC, $phone, $address, $postcode, $city, $state){
        $this->name = $name;
        $this->phoneMMC = $phoneMMC;
        $this->phone = $phone;
        $this->address = $address;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->state = $state;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getPhoneMMC() {
        return $this->phoneMMC;
    }

    public function setPhoneMMC($phoneMMC) {
        $this->phoneMMC = $phoneMMC;
        return $this;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
        return $this;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
        return $this;
    }
}
?>
