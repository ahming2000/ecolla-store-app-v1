<?php

class UsefulFunction{
    public static function removeArrayElementE($array, $element){
        //Get the index of the element that require to remove
        for($i = 0; $i < sizeof($array); $i++){
            if(is_null($value)){
                $index = $i;
                break;
            }
        }
        //Delete the element from array (will left a null space)
        $array = array_diff($array, $element);
        //Copy the array part after the null space to the end
        $arrayAfterElement = array_slice($array, $index + 1, length($array));
        //Replace the array element (from null space to the last element) with elements after null space
        array_splice($array, $index, length($array), $arrayAfterElement);
        return $array; //To do (Debug): if the array do not change by using array_splice(), need to address the result using return
    }

    public static function removeArrayElementI($array, $index){
        //Track back the array element
        $element = $array[$index];
        //Delete the element from array (will left a null space)
        $array = array_diff($array, $element);
        //Copy the array part after the null space to the end
        $arrayAfterElement = array_slice($array, $index + 1, length($array));
        //Replace the array element (from null space to the last element) with elements after null space
        array_splice($array, $index, length($array), $arrayAfterElement);
        return $array; //To do (Debug): if the array do not change by using array_splice(), need to address the result using return
    }

    public static function startsWith ($string, $startString) {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    public static function jsonSerializeArray($objArray){
        $array = array();
        foreach ($objArray as $obj){
            array_push($array, $obj->jsonSerialize());
        }
        return $array;
    }

    public static function restoreCartItems($cartItemsJSON){

        $cartItems = array();

        foreach($cartItemsJSON as $cartItemJSON){

            $item = new Item($cartItemJSON->item->name, $cartItemJSON->item->catogory, $cartItemJSON->item->brand, $cartItemJSON->item->country, $cartItemJSON->item->isListed);
            $item->setID($cartItemJSON->item->id);

            foreach($cartItemJSON->item->varieties as $varietyJSON){
                $variety = new Variety($varietyJSON->barcode, $varietyJSON->property, $varietyJSON->propertyType, $varietyJSON->price, $varietyJSON->weight, $varietyJSON->weightUnit, $varietyJSON->inventory);
                $variety->setDiscountRate($varietyJSON->discountRate);
                $item->addVariety($variety);
            }

            foreach($cartItemJSON->item->imgPaths as $imgPath){
                $item->addImgPath($imgPath);
            }

            $cartItem = new CartItem($item, $cartItemJSON->quantity, $cartItemJSON->item->varieties[$cartItemJSON->varietyIndex]->barcode, $cartItemJSON->note);
            array_push($cartItems, $cartItem);
        }

        return $cartItems;
    }


}

?>
