<?php

class Customer {

    private $name;
    private $phoneMMC;
    private $phone;
    private $address;

    public function __construct($name, $phoneMMC, $phone, $address){
        $this->name = $name;
        $this->phoneMMC = $phoneMMC;
        $this->phone = $phone;
        $this->address = $address;
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
}
?>
