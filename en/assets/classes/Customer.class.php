<?php

class Customer {

    private $name;
    private $phoneMMC;
    private $phone;
    private $address;
    private $state;
    private $area;
    private $postalCode;

    public function __construct($name, $phoneMMC, $phone, $address, $state, $area, $postalCode){
        $this->name = $name;
        $this->phoneMMC = $phoneMMC;
        $this->phone = $phone;
        $this->address = $address;
        $this->state = $state;
        $this->area = $area;
        $this->postalCode = $postalCode;
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

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    public function getArea() {
        return $this->area;
    }

    public function setArea($area) {
        $this->area = $area;
        return $this;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
        return $this;
    }
}
?>
