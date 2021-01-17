<script>

$(document).ready(function() {

    function quantityReset(){
        $("#quantity").val(1);
        $("#quantity").removeAttr("disabled");
        $(".quantity-decrease-button").attr("disabled", "disabled");
        $(".quantity-increase-button").removeAttr("disabled");
    }

    function quantityControlDisable(){
        $("#quantity").val(0);
        $("#quantity").attr("disabled", "disabled");
        $(".quantity-decrease-button").attr("disabled", "disabled");
        $(".quantity-increase-button").attr("disabled", "disabled");
    }

    function quantityToMaxInventory(inventoryQuantity){
        $("#quantity").val(inventoryQuantity);
        $("#quantity").removeAttr("disabled");
        $(".quantity-decrease-button").removeAttr("disabled");
        $(".quantity-increase-button").attr("disabled", "disabled");
    }

    function quantityUnlockControl(){
        $(".quantity-decrease-button").removeAttr("disabled");
        $(".quantity-increase-button").removeAttr("disabled");
    }



    // Selected property controller
    $(".variety-selector li").on("click", function() {

        var quantity = parseInt($("#quantity").val());
        var selectedVarietyInventory = parseInt($(this).children(".variety-inventory").val());
        var selectedVarietyBarcode = $(this).children(".variety-barcode").val();

        // List responsive
        $(".variety-selector li").removeClass("active");
        $(this).addClass("active");

        // Change the variety barcode
        $("#barcode").val(selectedVarietyBarcode);

        // Change the price viewing
        $(".price-view").attr("hidden", "hidden");
        $("#variety-" + selectedVarietyBarcode).removeAttr("hidden");

        // Change the wholesale information view
        if($("#variety-" + selectedVarietyBarcode).hasClass("discounted-price")){
            $(".wholesale-view").hide();
        } else{
            $(".wholesale-view").show();
        }

        // Change the variety total inventory quantity
        $("#inventory").val(selectedVarietyInventory);

        // Disable add to cart button if the variety total quantity is 0 (sold out)
        if(selectedVarietyInventory == 0){
            $("#add-to-cart-button").attr("disabled", "disabled");
        } else{
            $("#add-to-cart-button").removeAttr("disabled");
        }

        // Adjust quantity input to inventory maximum if quantity exceed the max inventory
        if(selectedVarietyInventory == 0){
            quantityControlDisable();
        } else{
            if(quantity == 0){ //Previously is 0
                quantityReset();
            } else{
                if(quantity != 1){
                    if(quantity >= selectedVarietyInventory){ // Previous quantity is larger than the current variety max inventory
                        quantityToMaxInventory(selectedVarietyInventory);
                    } else{
                        quantityUnlockControl();
                    }
                }
            }
        }

        // Navigate to selected variety image
        var totalGeneralImg = $(".slider-container").children(".general-img").length - 2; // Get the total number of images
        var selectedImageIndex = totalGeneralImg; // Initialize
        for (i = 0; i < $(".variety-selector li").length; i++){ // Get index of the image
            var v = $(".variety-selector li").eq(i).children(".variety-barcode").val();
            if($("#img-" + v).val() != undefined){
                selectedImageIndex++;
                if (v === selectedVarietyBarcode){
                    break;
                }
            }
        }
        if ($("#img-" + selectedVarietyBarcode).val() != undefined) slider.goTo(selectedImageIndex); // Make sure image is existed before use goto function
    });

    //Quantity input onchange detect logic with inventory
    $("#quantity").on("change", function(){
        var selectedVarietyInventory = parseInt($(".variety-selector li.active").children(".variety-inventory").val());
        var quantity = parseInt($("#quantity").val());

        if(quantity >= selectedVarietyInventory){ // Previous quantity is larger than the current variety max inventory
            quantityToMaxInventory(selectedVarietyInventory);
        } else if(quantity <= 0){
            quantityReset();
        } else{
            quantityUnlockControl();
        }

        // Update wholesale information
        var quantity = parseInt($("#quantity").val());
        // Get wholesale range index
        var currentWholesaleIndex = -1; //Default does not involve in any wholesale
        //if($(".wholesale-view").eq(0).find(".wholesale-min").val() == 1) currentWholesaleIndex = 0; // If the first wholesale min is 1, set index to 0
        for(var i = 0; i < $(".wholesale-view").length; i++){
            if (i != $(".wholesale-view").length - 1){
                if(quantity >= $(".wholesale-view").eq(i).find(".wholesale-min").val()){
                    if(quantity < $(".wholesale-view").eq(i + 1).find(".wholesale-min").val()){
                        currentWholesaleIndex = i;
                        break;
                    }
                } else{
                    break; // Current quantity didnt reach wholesale min
                }
            } else {
                currentWholesaleIndex = $(".wholesale-view").length - 1; // Last and to infinity
            }
        }

        // Update price view and information
        if(currentWholesaleIndex >= 0){
            $(".price-view-normal").attr("hidden", "hidden");

            $(".price-view-wholesale").attr("hidden", "hidden");
            min = $(".wholesale-view").eq(currentWholesaleIndex).find(".wholesale-min").val();
            $(".wholesale-" + min).removeAttr("hidden");

            $(".wholesale-view").attr("hidden", "hidden");
            $(".wholesale-view").eq(currentWholesaleIndex + 1).removeAttr("hidden");
        } else{
            $(".price-view-normal").removeAttr("hidden");

            $(".price-view-wholesale").attr("hidden", "hidden");

            $(".wholesale-view").attr("hidden", "hidden");
            $(".wholesale-view").eq(0).removeAttr("hidden");
        }
    });

    // Quantity controller
    $(".quantity-button-control button").on("click", function() {

        // Inventory quantity (max)
        let INVENTORY = $("#inventory").val();

        // Current quantity
        var quantity = $(this).parent().children('input').val();

        // Increase button clicked
        if ($(this).hasClass("quantity-increase-button")) {

            // Increase quantity
            $(this).parent().children('input').val(++quantity);

            // Disable button when reach maximum
            if ($(this).parent().children('input').val() == INVENTORY) {
                $(this).attr('disabled', 'disabled');
                $(this).parent().children('.quantity-decrease-button').removeAttr('disabled');
            } else {
                $(this).removeAttr('disabled');
                $(this).parent().children('.quantity-decrease-button').removeAttr('disabled');
            }
        }
        // Decrease button clicked
        else if ($(this).hasClass("quantity-decrease-button")) {

            // Decrease quantity
            $(this).parent().children('input').val(--quantity);

            // Disable button when reach minimum
            if ($(this).parent().children('input').val() == 1) {
                $(this).parent().children('.quantity-increase-button').removeAttr('disabled');
                $(this).attr('disabled', 'disabled');
            } else {
                $(this).parent().children('.quantity-increase-button').removeAttr('disabled');
                $(this).removeAttr('disabled');
            }
        }

        // Update wholesale information
        var quantity = parseInt($(this).parent().children('input').val());
        // Get wholesale range index
        var currentWholesaleIndex = -1; //Default does not involve in any wholesale
        //if($(".wholesale-view").eq(0).find(".wholesale-min").val() == 1) currentWholesaleIndex = 0; // If the first wholesale min is 1, set index to 0
        for(var i = 0; i < $(".wholesale-view").length; i++){
            if (i != $(".wholesale-view").length - 1){
                if(quantity >= $(".wholesale-view").eq(i).find(".wholesale-min").val()){
                    if(quantity < $(".wholesale-view").eq(i + 1).find(".wholesale-min").val()){
                        currentWholesaleIndex = i;
                        break;
                    }
                } else{
                    break; // Current quantity didnt reach wholesale min
                }
            } else {
                currentWholesaleIndex = $(".wholesale-view").length - 1; // Last and to infinity
            }
        }

        // Update price view and information
        if(currentWholesaleIndex >= 0){
            $(".price-view-normal").attr("hidden", "hidden");

            $(".price-view-wholesale").attr("hidden", "hidden");
            min = $(".wholesale-view").eq(currentWholesaleIndex).find(".wholesale-min").val();
            $(".wholesale-" + min).removeAttr("hidden");

            $(".wholesale-view").attr("hidden", "hidden");
            $(".wholesale-view").eq(currentWholesaleIndex + 1).removeAttr("hidden");
        } else{
            $(".price-view-normal").removeAttr("hidden");

            $(".price-view-wholesale").attr("hidden", "hidden");

            $(".wholesale-view").attr("hidden", "hidden");
            $(".wholesale-view").eq(0).removeAttr("hidden");
        }

    });

});
</script>
