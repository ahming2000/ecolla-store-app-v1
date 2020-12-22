<script>

$(document).ready(function() {

    // Selected property controller
    $(".variety-selector li").on("click", function() {

        // List responsive
        $(".variety-selector li").removeClass("active");
        $(this).addClass("active");

        // Change the variety barcode
        var selectedVarietyBarcode = $(this).children(".variety-barcode").val();
        $("#barcode").val(selectedVarietyBarcode);

        // Change the price viewing
        $(".price-view").attr("hidden", "hidden");
        $("#variety-" + selectedVarietyBarcode).removeAttr("hidden");

        // Change the variety total inventory quantity
        var selectedVarietyInventory = $(this).children(".variety-inventory").val();
        $("#inventory").val(selectedVarietyInventory);

        // Disable add to cart button if the variety total quantity is 0 (sold out)
        if(selectedVarietyInventory == 0){
            $("#add-to-cart-button").attr("disabled", "disabled");
        } else{
            $("#add-to-cart-button").removeAttr("disabled");
        }

        // Adjust quantity input to inventory maximum if quantity exceed the max inventory
        if($("#quantity").val() > selectedVarietyInventory){
            $("#quantity").val(selectedVarietyInventory);
            $(".quantity-increase").attr("disabled", "disabled");
            if(selectedVarietyInventory == 0){
                $(".quantity-decrease").attr("disabled", "disabled");
            }
        } else{
            $(".quantity-increase").removeAttr("disabled");
            if($("#quantity").val() == 0) $("#quantity").val(1);
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

    // Quantity controller
    $(".quantity-button-control button").on("click", function() {

        // Inventory quantity (max)
        let INVENTORY = $("#inventory").val();

        // Current quantity
        var quantity = $(this).parent().children('input').val();

        // Increase button clicked
        if ($(this).hasClass("quantity-increase")) {

            // Increase quantity
            $(this).parent().children('input').val(++quantity);

            // Disable button when reach maximum
            if ($(this).parent().children('input').val() == INVENTORY) {
                $(this).attr('disabled', 'disabled');
                $(this).parent().children('.quantity-decrease').removeAttr('disabled');
            } else {
                $(this).removeAttr('disabled');
                $(this).parent().children('.quantity-decrease').removeAttr('disabled');
            }
        }
        // Decrease button clicked
        else if ($(this).hasClass("quantity-decrease")) {

            // Decrease quantity
            $(this).parent().children('input').val(--quantity);

            // Disable button when reach minimum
            if ($(this).parent().children('input').val() == 1) {
                $(this).parent().children('.quantity-increase').removeAttr('disabled');
                $(this).attr('disabled', 'disabled');
            } else {
                $(this).parent().children('.quantity-increase').removeAttr('disabled');
                $(this).removeAttr('disabled');
            }
        }

    });

});
</script>
