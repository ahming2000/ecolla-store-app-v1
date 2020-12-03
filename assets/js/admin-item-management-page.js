
//Need to put special function since the button is generated by the variery-property

// Extra inventory
$(document).on("click", ".extra-inventory-class", function(){
    var inventoryCount = $(this).parent().parent().children(".inventory-section-class").children(".inventory-count").val()
    var currentIndex = $(".extra-inventory-class").index($(this));

    var extraInventoryHTML = '<div class="col-6"><input type="date" class="form-control inventory-expire-date mb-1" name="variety[' + currentIndex + '][\'inventory\'][' + inventoryCount + '][\'expireDate\']" aria-describedby="inventory-expire-date" required/></div><div class="col-6"><input type="number" class="form-control inventory-quantity mb-1" name="variety[' + currentIndex + '][\'inventory\'][' + inventoryCount + '][\'quantity\']" aria-describedby="inventory-quantity" required/></div>';

    $(".inventory-section-class").eq(currentIndex).append(extraInventoryHTML);
    $(this).parent().parent().children(".inventory-section-class").children(".inventory-count").val(++inventoryCount);
});

// Auto sync property shown below two table
$(document).on("change", ".variety-property-main", function(){
    var value = $(this).val();
    var propertyCount = $(".variety-property").length / 2;
    var propertyIndex = $(".variety-property-main").index(this);
    $(".variety-property").eq(propertyIndex).val(value);
    $(".variety-property").eq(propertyIndex + propertyCount).val(value);
});

$(document).ready(function(){

    // For file uploaded name to show
    bsCustomFileInput.init()

    $("#image").on('change', function () {

        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof (FileReader) != "undefined") {

                var image_holder = $("#image-holder");
                image_holder.empty();

                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[0]);
            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            alert("Pls select only images");
        }
    });

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
        var extraPropertyHTML = '<div class="col-12 mb-1"><input type="text" class="form-control variety-property-main" name="variety[' + propertyCount + '][\'property\']" aria-describedby="property" maxlength="100"/></div>';
        var newVarietyTableRow = '<tr><td><input type="text" class="form-control variety-property" name="variety[' + propertyCount + '][\'property\']" aria-describedby="variety-property" maxlength="100" disabled/></td><td><input type="text" class="form-control variety-barcode" name="variety[' + propertyCount + '][\'barcode\']" aria-describedby="variety-barcode" maxlength="20" required/></td><td><input type="number" class="form-control variety-price" name="variety[' + propertyCount + '][\'price\']" aria-describedby="variety-price" maxlength="10" required/></td><td><input type="number" class="form-control variety-weight" name="variety[' + propertyCount + '][\'weight\']" aria-describedby="variety-weight" maxlength="10" required/></td></tr>';
        var newInventoryTableRow = '<tr><td><input type="text" class="form-control variety-property" name="variety[' + propertyCount + '][\'property\']" aria-describedby="variety-property" maxlength="100" disabled/></td><td colspan="2"><div class="form-row inventory-section-class"><input type="number" value="1" class="inventory-count" hidden/><div class="col-6"><input type="date" class="form-control inventory-expire-date mb-1" name="variety[' + propertyCount + '][\'inventory\'][0][\'expireDate\']" aria-describedby="inventory-expire-date" required/></div><div class="col-6"><input type="number" class="form-control inventory-quantity mb-1" name="variety[' + propertyCount + '][\'inventory\'][0][\'quantity\']" aria-describedby="inventory-quantity" required/></div></div><!-- Add extra inventory button --><div class="text-center"><button type="button" class="btn btn-secondary mt-1 extra-inventory-class">添加更多库存</button></div></td></tr>';
        $("#property-section").append(extraPropertyHTML);
        $('#variety-section').append(newVarietyTableRow);
        $('#inventory-table-section').append(newInventoryTableRow);
        propertyCount++;
    });

});