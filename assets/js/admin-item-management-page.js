/* Extra Markup */
function getExtraCatogoryHTML(catogoryCount){
    return `` +
    `<div class="col-12 mb-1">` +
        `<input type="text" class="form-control" name="catogory[${catogoryCount}]" aria-describedby="catogory" list="catogoryList" maxlength="20"/>` +
    `</div>`;
}

function getExtraPropertyHTML(propertyCount){
    return `` +
    `<div class="col-12 mb-1">` +
        `<input type="text" class="form-control v-property" name="v[${propertyCount}][v_property]" aria-describedby="v-property" maxlength="100"/>` +
    `</div>`;
}

function getExtraVarietyTableRowHTML(propertyCount){
    return `` +
    `<tr>` +
        `<td><input type="text" class="form-control v-property-view" disabled/></td>` +
        `<td><input type="text" class="form-control" name="v[${propertyCount}][v_barcode]" aria-describedby="v-barcode" maxlength="20"/></td>` +
        `<td><input type="number" step="0.01" min="0" class="form-control" name="v[${propertyCount}][v_price]" aria-describedby="v-price" maxlength="10"/></td>` +
        `<td><input type="number" step="0.001" min="0" class="form-control" name="v[${propertyCount}][v_weight]" aria-describedby="v-weight" maxlength="10"/></td>` +
    `</tr>`;
}

function getExtraInventoryTableRowHTML(propertyCount){
    return `` +
    `<tr>` +
        `<td><input type="text" class="form-control v-property-view" disabled/></td>` +
        `<td colspan="2">` +
            `<div class="form-row variety-inventory-table-section">` +
                `<input type="number" value="1" class="inventory-count" hidden/>` +
                `<div class="col-6"><input type="date" class="form-control mb-1" name="v[${propertyCount}][inv][0][inv_expire_date]" aria-describedby="inv-expire-date"/></div>` +
                `<div class="col-6"><input type="number" min="0" class="form-control mb-1" name="v[${propertyCount}][inv][0][inv_quantity]" aria-describedby="inv-quantity"/></div>` +
            `</div>` +
            `<!-- Add extra inventory button -->` +
            `<div class="text-center"><button type="button" class="btn btn-secondary mt-1 extra-inventory-button">添加更多库存</button></div>` +
        `</td>` +
    `</tr>`;
}

function getExtraInventoryHTML(currentVarietyIndex, inventoryCount){
    return `` +
    `<div class="col-6"><input type="date" class="form-control mb-1" name="v[${currentVarietyIndex}][inv][${inventoryCount}][inv_expire_date]" aria-describedby="inv-expire-date"/></div>` +
    `<div class="col-6"><input type="number" min="0" class="form-control mb-1" name="v[${currentVarietyIndex}][inv][${inventoryCount}][inv_quantity]" aria-describedby="inv-quantity"/></div>`;
}

function getExtraVarietyImageBoxHTML(propertyCount){
    return `` +
    `<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">` +
        `<label>` +
            `<input type="file" name="variety-image[${propertyCount}]" class="image-file-selector" style="display:none;"/>` +
            `<img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>` +
            `<div style="text-align: center;" class="variety-property-caption"></div>` +
        `</label>` +
    `</div>`;
}

/* Get form information */
function getCatogoryCount(){
    return $("#catogory-section div").length;
}

function getPropertyCount(){
    return $(".v-property").length;
}

function getIventoryRowCount(source){
    return $(source).parent().parent().children(".inventory-section-class").children(".inventory-count").val();
}

function getInventoryCount(source, modification){ //With value modification function
    inventoryCount = $(source).parent().parent().children(".variety-inventory-table-section").children(".inventory-count").val();
    $(this).parent().parent().children(".inventory-section-class").children(".inventory-count").val(inventoryCount + modification);
    return inventoryCount;
}

// Extra inventory
$(document).on("click", ".extra-inventory-button", function(e){ // To detect and modify real time (new generated) HTML
    e.preventDefault();

    var currentVarietyIndex = $(".extra-inventory-button").index($(this)); // Get current located index in the table
    $(".variety-inventory-table-section").eq(currentVarietyIndex).append(getExtraInventoryHTML(getInventoryCount(this, 1), currentVarietyIndex));
});

// Auto sync property shown below two table
$(document).on("change", ".v-property", function(e){ // To detect and modify real time (new generated) HTML
    e.preventDefault();

    var value = $(this).val();
    var propertyCount = getPropertyCount();
    var propertyIndex = $(".v-property").index(this);

    $(".v-property-view").eq(propertyIndex).val(value); // Variety table
    $(".v-property-view").eq(propertyIndex + propertyCount).val(value); // Inventory table
    $(".variety-property-caption").eq(propertyIndex).html(value); // Variety Image Box Caption
});

// For separate image upload
var selected;

function loadImage(e){
    selected.attr('src', e.target.result);
}

$(document).on('change', ".image-file-selector", function () {
    var imgPath = $(this)[0].value;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

    if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
        if (typeof (FileReader) != "undefined") {
            selected = $(this).parent().find(".image-preview");
            var reader = new FileReader();
            reader.onload = loadImage;
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("您使用的浏览器不支持这个功能！");
        }
    } else if(imgPath != ""){
        alert("照片必须是图片文档！");
    }

});

$(document).ready(function(){

    // Extra catogory
    $("#extra-catogory-button").on("click", function(){
        $("#catogory-section").append(getExtraCatogoryHTML(getCatogoryCount()));
    });

    // Extra property
    $("#extra-property-button").on("click", function(){
        var propertyCount = getPropertyCount();
        $("#property-section").append(getExtraPropertyHTML(propertyCount));
        $('#variety-table-section').append(getExtraVarietyTableRowHTML(propertyCount));
        $('#inventory-table-section').append(getExtraInventoryTableRowHTML(propertyCount));
        $("#variety-image-section").append(getExtraVarietyImageBoxHTML(propertyCount));
    });

    // For changing "active tag" when scrolling
    // Reference: https://www.steckinsights.com/change-active-menu-as-you-scroll-with-jquery/
    $(window).scroll(function() {
        var Scroll = $(window).scrollTop();
        StepOneOffset = $('#step-one').offset().top;
        StepTwoOffset = $('#step-two').offset().top - 100;
        StepThreeOffset = $('#step-three').offset().top - 100;

        if (Scroll < StepTwoOffset) {
            $("#step-one-link").addClass("active");
        } else {
            $("#step-one-link").removeClass("active");
        }

        if (Scroll >= StepTwoOffset) {
            $("#step-two-link").addClass("active");
            $("#step-one-link").removeClass("active");
        } else {
            $("#step-two-link").removeClass("active");
        }

        if (Scroll >= StepThreeOffset) {
            $("#step-three-link").addClass("active");
            $("#step-two-link").removeClass("active");
        } else {
            $("#step-three-link").removeClass("active");
        }
    });

});
