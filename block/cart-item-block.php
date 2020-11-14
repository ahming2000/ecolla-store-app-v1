<div class="col-12">
    <div class="card">
        <div class="card-body">
            <?php
                echo "Item name: ".$cartItem->getItem()->getName().'<br>';
                echo "Quantity: ".$cartItem->getQuantity().'<br>';
                $index = $cartItem->getVarietyIndex();
                $v = $cartItem->getItem()->getVarieties()[$index]->getProperty();
                echo "Selected Variety: ".$v.'<br>';
             ?>
        </div>
    </div>
</div>

<?php
// "<div class=\"row mb-4\">" +
//
//                 "<div class=\"col-xs-12 col-sm-5 col-md-5 col-lg-5 col-xl-5\">" +
//                 "<div class=\"view zoom overlay z-depth-1 rounded mb-3 mb-md-0\">" +
//                 "<a href=\"" + cartList[i].itemPageDirectory + "\"><img class=\"w-100\" height=\"250\" src=\"" + cartList[i].imgDirectory + "\"></a>" +
//                 "</div></div>" +
//
//                 "<div class=\"item-detail col-xs-12 col-sm-7 col-md-7 col-lg-7 col-xl-7\">" +
//
//                 "<div class=\"item-info\">" +
//                 "<input class=\"item-id\" type=\"text\" value=\"" + cartList[i].productID + "\" hidden>" +
//                 "<input class=\"cart-index\" type=\"number\" value=\"" + String(cartIndex++) + "\" hidden>" +
//                 "<input class=\"itemDeliveryType\" value=\"" + cartList[i].itemDeliveryType + "\" hidden>" +
//                 "<div class=\"item-title h4 font-weight-bold\">" + cartList[i].itemName + "</div>" +
//                 "<div class=\"item-properties h6 grey-text\">" + cartList[i].itemProperties + "</div>" +
//                 "<div class=\"item-extra h6 grey-text\">" + cartList[i].extraNote + "</div>" +
//                 "<div class=\"item-delivery-type h6 grey-text\" style=\"color: red;\">**" + cartList[i].itemDeliveryType + "</div>" +
//
//
//                 "</div>" +
//
//                 "<div class=\"row d-flex justify-content-between align-items-center\">" +
//                 "<div class=\"col-xs-12 col-sm-12 col-md-3\"><div class=\"h6\">Quantity: </div></div>" +
//                 "<div class=\"col-xs-12 col-sm-12 col-md-9 quantity-button-control data-update-enable\">" +
//                 "<button type=\"button\" class=\"btn btn-primary dropButton btn-sm mx-3 my-3\">-</button>" +
//                 "<input type=\"number\" class=\"mx-3 my-3 quantity-number\" value=\"" + cartList[i].quantity + "\" style=\"width: 45px;\"disabled>" +
//                 "<button type=\"button\" class=\"btn btn-primary addButton btn-sm mx-3 my-3\">+</button>" +
//                 "</div></div>" +
//
//                 "<div class=\"item-action-price d-flex justify-content-between align-items-center\">" +
//                 "<div><a type=\"button\" class=\"remove-item-button card-link-secondary small text-uppercase mr-3\"><i class=\"fas fa-trash-alt mr-1\"></i>Remove item</a></div>" +
//                 "<input type=\"number\" class=\"item-single-price\" value=\"" + cartList[i].singleItemPrice + "\" hidden></input>" +
//                 "<span class=\"item-price\">RM" + cartList[i].total + "</span>" +
//                 "</div></div>" +
//
//
//                 "</div>"
?>
