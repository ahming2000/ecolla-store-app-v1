<tr>
    <td>
        <input class="item-check-box" name="item-check-box" onclick="itemCheckBoxClicked(this)" type="checkbox">
        <input type="text" name="name" class="infoBoxItemName" value="<?= $item->getName() ?>" hidden/>
        <input type="text" name="brand" class="infoBoxItemBrand" value="<?= $item->getBrand() ?>" hidden/>
    </td>
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

    <td><?php
    foreach($item->getVarieties() as $variety){
        echo $view->getPurchaseCount($variety->getBarcode()) . "<br>";
    }
     ?></td>

     <td>
         <form action="" method="post">
            <input type="text" name="name" value="<?= $item->getName() ?>" hidden/>
            <input type="text" name="brand" value="<?= $item->getBrand() ?>" hidden/>
            <button class="btn btn-outline-secondary p-2 m-1" type="submit" name="list"><?= $item->isListed() ? "下架" : "上架"; ?></button><br>
            <button class="btn btn-outline-secondary p-2 m-1" type="submit" name='edit'>编辑</button><br>
            <button class="btn btn-outline-secondary p-2 m-1" type="submit" name="delete">删除</button><br>
         </form>


     </td>
</tr>
