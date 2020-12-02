$(document).ready(function(){

    // For file uploaded name to show
    bsCustomFileInput.init()

    // Extra catogory
    var catogoryCount = 1;


    $("#extraCatogory").on("click", function(){
        var extraCatogoryHTML = '<div class="col-12 mb-1"><input type="text" class="form-control" name="catogory[' + catogoryCount + ']" aria-describedby="catogory" list="catogoryList" maxlength="20"/></div>';
        $("#catogory-section").append(extraCatogoryHTML);
        catogoryCount++;
    });

    // Extra property
    var propertyCount = 1;

    $("#extraProperty").on("click", function(){
        var extraPropertyHTML = '<div class="col-12 mb-1"><input type="text" class="form-control" name="variety[' + propertyCount + '][\'property\']" aria-describedby="property" maxlength="100"/></div>';
        var newVarietyTableRow = '<tr><td><input type="text" class="form-control variety-property" name="variety[' + propertyCount + '][\'property\']" aria-describedby="variety-property" maxlength="100" disabled/></td><td><input type="text" class="form-control variety-barcode" name="variety[' + propertyCount + '][\'barcode\']" aria-describedby="variety-barcode" maxlength="20" required/></td><td><input type="number" class="form-control variety-price" name="variety[' + propertyCount + '][\'price\']" aria-describedby="variety-price" maxlength="10" required/></td><td><input type="number" class="form-control variety-weight" name="variety[' + propertyCount + '][\'weight\']" aria-describedby="variety-weight" maxlength="10" required/></td></tr>';
        var newInventoryTableRow = '<tr><td><input type="text" class="form-control variety-property" name="variety[' + propertyCount + '][\'property\']" aria-describedby="variety-property" maxlength="100" disabled/></td><td colspan="2"><div class="form-row inventory-section-class"><input type="number" value="1" id="inventory-count" hidden/><div class="col-6"><input type="date" class="form-control inventory-expire-date mb-1" name="variety[' + propertyCount + '][\'inventory\'][0][\'expireDate\']" aria-describedby="inventory-expire-date" required/></div><div class="col-6"><input type="number" class="form-control inventory-quantity mb-1" name="variety[' + propertyCount + '][\'inventory\'][0][\'quantity\']" aria-describedby="inventory-quantity" required/></div></div><!-- Add extra inventory button --><div class="text-center"><button type="button" class="btn btn-secondary mt-1 extra-inventory-class">添加更多库存</button></div></td></tr>';
        $("#property-section").append(extraPropertyHTML);
        $('#variety-section').append(newVarietyTableRow);
        $('#inventory-table-section').append(newInventoryTableRow);
        propertyCount++;
    });

    // Extra inventory



    $(".extra-inventory-class").on("click", function(){

        var inventoryCount = $(this).children("#inventory-count");

        var currentIndex = $(".extra-inventory-class").index($(this));

        var extraInventoryHTML = '<div class="col-6"><input type="date" class="form-control inventory-expire-date mb-1" name="variety[' + (currentIndex + 1) + '][\'inventory\'][' + inventoryCount + '][\'expireDate\']" aria-describedby="inventory-expire-date" required/></div><div class="col-6"><input type="number" class="form-control inventory-quantity mb-1" name="variety[' + (currentIndex + 1) + '][\'inventory\'][' + inventoryCount + '][\'quantity\']" aria-describedby="inventory-quantity" required/></div>';

        $(".inventory-section-class").eq(currentIndex).append(extraInventoryHTML);

        $(this).children("#inventory-count").val(inventoryCount++);
    });


    // Auto sync property shown below two table
    $(".variety-property").on("change", function(){
        var value = $(this).val();
        var count = $(".variety-property").length - 1;
        var currentIndex = $(".variety-property").index($(this));
        $(".variety-property").eq(currentIndex * count + 1).val(value);
        $(".variety-property").eq(currentIndex * count + 2).val(value);
    });
});
