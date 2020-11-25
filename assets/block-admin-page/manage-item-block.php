<tr>
    <td><input class="item-check-box" name="item-check-box" onclick="itemCheckBoxClicked(this)" type="checkbox"></td>
    <td><?php echo $item->getCountry(); ?></td>
    <td><?php echo $item->getBrand(); ?></td>
    <td><?php echo $item->getName(); ?></td>

    <td><?php
    foreach($item->getVarieties() as $variety){
        echo $variety->getBarcode()."<br>";
    }
     ?></td>

    <td><?php
    foreach($item->getVarieties() as $variety){
        echo $variety->getPrice()."<br>";
    }
    ?></td>

    <td><?php
    foreach($item->getVarieties() as $variety){
        $totalInventory = 0;
        foreach($variety->getShelfLifeList() as $shelfLife){
            $totalInventory += $shelfLife->getInventory();
        }
        echo $totalInventory."<br>";
    }
    ?></td>
</tr>
