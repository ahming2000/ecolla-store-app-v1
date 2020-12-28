/* Extra Markup */
function getExtraCatogoryHTML(catogoryCount){
    return `` +
    `<div class="row">` +
        `<div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control" name="catogory[${catogoryCount}]" aria-describedby="catogory" list="catogory-list" maxlength="20"/></div>` +
        `<div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>` +
    `</div>`;
}

function getExtraPropertyHTML(propertyCount){
    return `` +
    `<div class="row">` +
        `<div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control v-property" name="v[${propertyCount}][v_property]" aria-describedby="v-property" maxlength="100"/></div>` +
        `<div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>` +
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
            `<div class="variety-inventory-table-section">` +
                `<div class="row">` +
                    `<div class="col-6"><input type="date" class="form-control mb-1" name="v[${propertyCount}][inv][0][inv_expire_date]" aria-describedby="inv-expire-date"/></div>` +
                    `<div class="col-6"><input type="number" min="0" class="form-control mb-1" name="v[${propertyCount}][inv][0][inv_quantity]" aria-describedby="inv-quantity"/></div>` +
                `</div>` +
            `</div>` +
            `<!-- Add extra inventory button -->` +
            `<div class="text-center"><button type="button" class="btn btn-secondary mt-1 extra-inventory-button">添加更多库存</button></div>` +
        `</td>` +
    `</tr>`;
}

function getExtraInventoryHTML(currentVarietyIndex, inventoryCount){
    return `` +
    `<div class="row">` +
        `<div class="col-6"><input type="date" class="form-control mb-1" name="v[${currentVarietyIndex}][inv][${inventoryCount}][inv_expire_date]" aria-describedby="inv-expire-date"/></div>` +
        `<div class="col-6"><input type="number" min="0" class="form-control mb-1" name="v[${currentVarietyIndex}][inv][${inventoryCount}][inv_quantity]" aria-describedby="inv-quantity"/></div>` +
    `</div>`;
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
    return $("#catogory-section div.row").length;
}

function getPropertyCount(){
    return $("#property-section div.row").length;
}

function getIventoryRowCount(source){
    return $(source).parent().parent().children(".inventory-section-class tr").length;
}

function getInventoryCount(source, modification){ //With value modification function
    return $(source).parent().parent().children(".variety-inventory-table-section div.row").length;;
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
    $(".v-property-view").eq(propertyIndex + propertyCount - 1).val(value); // Inventory table  // Minus 1 of property count to index
    $(".variety-property-caption").eq(propertyIndex).html(value); // Variety Image Box Caption
});

// Catogory or property or inventory remove button
$(document).on("click", ".remove-button", function(){
    if($(this).hasClass("property-remove-button")){
        var propertyCount = getPropertyCount();
        var propertyInput = $(this).parent().parent().find(".v-property");
        var propertyIndex = $(".v-property").index(propertyInput);

        $(".v-property-view").eq(propertyIndex).parent().parent().html('');
        $(".v-property-view").eq(propertyIndex + propertyCount - 1).parent().parent().html(''); // Minus 1 of property count to index
        $(".variety-property-caption").eq(propertyIndex).parent().parent().attr("hidden", "hidden"); // Hidden the div to delete to avoid blank space
        $(".variety-property-caption").eq(propertyIndex).parent().parent().html('');
    }

    $(this).parent().parent().html("");
});

// For separate image upload
var selected;

function loadImage(e){
    selected.attr('src', e.target.result);
}

// Image file validater
// Reference: https://stackoverflow.com/questions/4234589/validation-of-file-extension-before-uploading-file
var validFileExtensions = [".jpg", ".jpeg", ".gif", ".png"];
var maxUploadSize = 5000000; // Unit in Bytes // 5MB
function validateImage(fileInput) {

    if (fileInput.type == "file") {
        var fileName = fileInput.value;
        var fileSize = fileInput.files[0].size;

        if (fileName.length > 0) {

            var extensionValid = false;
            var sizeValid = false;

            for (var j = 0; j < validFileExtensions.length; j++) {
                var cur = validFileExtensions[j];
                if (fileName.substr(fileName.length - cur.length, cur.length).toLowerCase() == cur.toLowerCase()) {
                    extensionValid = true;
                    break;
                }
            }

            if(fileSize < maxUploadSize){
                sizeValid = true;
            }

            if (!extensionValid) {
                alert("请上传格式正确的图像");
                return false;
            }

            if (!sizeValid){
                alert("请上传少于5MB的图像文件");
                return false;
            }
        }
    }

    return true;
}

$(document).on('change', ".image-file-selector", function () {

    if (!validateImage($(this)[0])){
        $(this).val(''); // Empty the file upload input if wrong extension
    } else{
        // Load preview
        if (typeof (FileReader) != "undefined") {
            selected = $(this).parent().find(".image-preview");
            var reader = new FileReader();
            reader.onload = loadImage;
            reader.readAsDataURL($(this)[0].files[0]);


            // Crop and shape the preview
            var style = getComputedStyle(selected[0]);
            var width = parseInt(style.width) || 0;
            var height = parseInt(style.height) || 0;

            if(width > height){
                padding = (width - height) / 2.0;
                selected[0].style.marginTop = padding;
                selected[0].style.marginBottom = padding;
            } else{
                padding = (height - width) / 2.0;
                selected[0].style.marginLeft = padding;
                selected[0].style.marginRight = padding;
            }

            selected[0].style.width = width;
            selected[0].style.height = height;
            selected[0].style.objectFit = 'cover';

        } else {
            alert("您使用的浏览器不支持这个功能！");
        }

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
