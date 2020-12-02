<tr>
    <td><input class="item-check-box" name="item-check-box" onclick="itemCheckBoxClicked(this)" type="checkbox"></td>
    <td><?php echo $item->getCountry(); ?></td>
    <td><?php echo $item->getBrand(); ?></td>
    <td><?php echo $item->getName(); ?></td>

    <td><?php
    foreach($item->getVarieties() as $variety){
        echo $variety->getProperty()."<br>";
    }
     ?></td>

    <td><?php
    foreach($item->getVarieties() as $variety){
        echo $variety->getBarcode()."<br>";
    }
     ?></td>

    <td><?php
    foreach($item->getVarieties() as $variety){
        echo "RM".number_format($variety->getPrice() * $variety->getDiscountRate(), 2)."<br>";
    }
    ?></td>

    <td><?php
    foreach($item->getVarieties() as $variety){
        $totalQuantity = 0;
        foreach($variety->getInventories() as $inventory){
            $totalQuantity += $inventory->getQuantity();
        }
        echo $totalQuantity."<br>";
    }
    ?></td>
</tr>
