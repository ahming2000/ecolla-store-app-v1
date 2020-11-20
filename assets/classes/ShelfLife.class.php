<?php

class ShelfLife {
        private $expireDate;
        private $inventory;

        public function __construct($expireDate, $inventory){
            $this->expireDate = $expireDate;
            $this->inventory = $inventory;
        }

        public function getExpireDate(){
            return $this->expireDate;
        }

        public function getInventory(){
            return $this->inventory;
        }

        public function setExpireDate($expireDate){
            $this->expireDate = $expireDate;
        }

        public function setInventory($inventory){
            $this->inventory = $inventory;
        }
}

 ?>
