<?php

class Wholesale{

    private $min;
    private $max;
    private $discountRate;

    public function __construct($min, $max, $discountRate){
        $this->min = $min;
        $this->max = $max;
        $this->discountRate = $discountRate;
    }

    public function getMin() {
        return $this->min;
    }

    public function setMin($min) {
        $this->min = $min;
        return $this;
    }

    public function getMax() {
        return $this->max;
    }

    public function setMax($max) {
        $this->max = $max;
        return $this;
    }

    public function getDiscountRate() {
        return $this->discountRate;
    }

    public function setDiscountRate($discountRate) {
        $this->discountRate = $discountRate;
        return $this;
    }
}



 ?>
