<?php

class Inventory {

        private $expireDate;
        private $quantity;

        public function __construct($expireDate, $quantity){
            $this->expireDate = $expireDate;
            $this->quantity = $quantity;
        }

        public function getExpireDate(){
            return $this->expireDate;
        }

        public function getQuantity(){
            return $this->quantity;
        }

        public function setExpireDate($expireDate){
            $this->expireDate = $expireDate;
        }

        public function setQuantity($quantity){
            $this->quantity = $quantity;
        }
}

 ?>
