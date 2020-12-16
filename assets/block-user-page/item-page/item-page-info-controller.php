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
