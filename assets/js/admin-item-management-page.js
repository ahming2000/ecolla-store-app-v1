/* Extra Markup */
function getExtraCategoryHTML(categoryCount){
    return `` +
    `<div class="row">` +
        `<div class="col-11 mb-1 mr-0 pr-0"><input type="text" class="form-control" name="category[${categoryCount}]" aria-describedby="category" list="category-list" maxlength="20"/></div>` +
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
        `<td><input type="number" step="0.01" min="0" class="form-control v-price" name="v[${propertyCount}][v_price]" aria-describedby="v-price"/></td>` +
        `<td><input type="number" step="0.001" min="0" class="form-control" name="v[${propertyCount}][v_weight]" aria-describedby="v-weight"/></td>` +
        `<td><input type="number" step="0.01" min="0" class="form-control v-discounted-price" name="v[${propertyCount}][v_discount_price]" aria-describedby="v-discounted-price"/></td>` +
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
                    `<div class="col-5"><input type="number" min="0" class="form-control mb-1" name="v[${propertyCount}][inv][0][inv_quantity]" aria-describedby="inv-quantity"/></div>` +
                    `<div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>` +
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
        `<div class="col-5"><input type="number" min="0" class="form-control mb-1" name="v[${currentVarietyIndex}][inv][${inventoryCount}][inv_quantity]" aria-describedby="inv-quantity"/></div>` +
        `<div class="col-1 mb-1 ml-0 pl-0"><button type="button" class="btn default-color white-text btn-sm remove-button px-3 py-1">X</button></div>` +
    `</div>`;
}

function getExtraVarietyImageBoxHTML(propertyCount){
    return `` +
    `<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">` +
        `<input type="file" name="variety-image[${propertyCount}]" class="image-file-selector" style="display:none;"/>` +
        `<figure class="figure">` +
            `<div class="img-upload-container">` +
                `<img class="img-fluid image-preview" src="../assets/images/alt/image-upload-alt.png"/>` +
                `<div class="img-upload-overlay">` +
                    `<div class="img-upload-overlay-icon edit-img-button" title="Upload Image" onclick="uploadImage(this)">` +
                        `<i class="icofont-edit"></i>` +
                    `</div>` +
                    `<div class="img-upload-overlay-icon remove-img-button" title="Remove Image" onclick="removeImage(this)">` +
                        `<i class="icofont-ui-delete"></i>` +
                    `</div>` +
                `</div>` +
            `</div>` +
            `<figcaption class="figure-caption text-center variety-property-caption"></figcaption>` +
        `</figure>` +
    `</div>`;
}

function getExtraWholesaleTableRowHTML(wholesaleCount, max, price){
    var d = $("#wholesale-table-section tr").has("td").length == 0 ? "" : "disabled";
    return `` +
    `<tr>` +
        `<td><input type="number" class="form-control mb-1 w-min" min="1" name="w[${wholesaleCount}][w_min]" aria-describedby="w-min" value="${max}" ${d}/></td>` +
        `<td><input type="number" class="form-control mb-1 w-max" min="${max}" name="w[${wholesaleCount}][w_max]" aria-describedby="w-max" disabled/></td>` +
        `<td><input type="number" class="form-control mb-1 w-price" step="0.01" min="0.01" max="${price}" name="w[${wholesaleCount}][w_price]" aria-describedby="w-price"/></td>` +
        `<td><button type="button" class="btn default-color white-text btn-sm remove-button wholesale-remove-button px-3 py-1">X</button></td>` +
    `</tr>`;
}

/* Get form information */
function getCategoryCount(){
    return $("#category-section div.row").length;
}

function getPropertyCount(){
    return $("#property-section div.row").length;
}

function getIventoryRowCount(source){
    return $(source).parent().parent().children(".inventory-section-class tr").length;
}

function getInventoryCount(source){
    return $(source).parent().parent().find(".variety-inventory-table-section div.row").length;
}

function getWholesaleCount(){
    return $("#wholesale-table-section tr").length;
}

// Extra inventory
$(document).on("click", ".extra-inventory-button", function(e){ // To detect and modify real time (new generated) HTML
    e.preventDefault();

    var currentVarietyIndex = $(".extra-inventory-button").index($(this)); // Get current located index in the table
    $(".variety-inventory-table-section").eq(currentVarietyIndex).append(getExtraInventoryHTML(currentVarietyIndex, getInventoryCount(this)));
});

// Auto sync property shown below two table
$(document).on("change", ".v-property", function(e){ // To detect and modify real time (new generated) HTML
    e.preventDefault();

    var value = $(this).val();
    var propertyCount = $("#property-section div.row").has("div").length;
    var propertyIndex = $(".v-property").index(this);

    $(".v-property-view").eq(propertyIndex).val(value); // Variety table
    $(".v-property-view").eq(propertyIndex + propertyCount).val(value); // Inventory table  // Minus 1 of property count to index
    $(".variety-property-caption").eq(propertyIndex).html(value); // Variety Image Box Caption
});

// Wholesale w-max column auto sync
$(document).on("change", ".w-max", function(e){
    e.preventDefault();

    var index = $(".w-max").index(this);
    var nextMin = parseInt($(this).val()) + 1;

    $(".w-min").eq(index + 1).val(nextMin); // Set w-min of next row sync value with current w-max
    $(".w-max").eq(index + 1).attr("min", nextMin); // Set min value of w-max of next row with current w-max
});

// Wholesale w-price column auto sync
$(document).on("change", ".w-price", function(e){
    e.preventDefault();

    var index =  $(".w-price").index(this);
    var nextMaxPrice = $(this).val();

    $(".w-price").eq(index + 1).attr("max", nextMaxPrice); // Set max value of w-price of next row with current w-price

});

// Category or property or inventory remove button
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

    // Checking after delete the html
    if($(this).hasClass("wholesale-remove-button")){
        // Last romove button of wholesale table will always enable and the rest will be disabled
        $("#wholesale-table-section").find(".remove-button").attr("disabled", "disabled");
        $("#wholesale-table-section").find(".remove-button").last().removeAttr("disabled");

        // Last max column will always disabled and the rest will be enabled
        $(".w-max").removeAttr("disabled");
        $(".w-max").last().attr("disabled", "disabled");
    }
});

// Disable wholesales if all variety price is difference
$(document).on("change", ".v-price", function(){

    // Wholesale settings
    var first = $(".v-price").eq(0).val();
    var isSame = true;
    for(var i = 1; i < $(".v-price").length; i++){
        if ($(".v-price").eq(i).val() != first){
            isSame = false;
            break;
        }
    }

    if(isSame){
        $(".wholesale-section").show();
    } else{
        $(".wholesale-section").hide();
    }

    // Discount price settings
    var index = $(".v-price").index(this);
    $(".v-price").eq(index).parent().parent().find(".v-discounted-price").attr("max", $(this).val());
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

// Markup generator
$(function() {
    $("form").on("submit", e => {
        let name = $('input[name=i_name]').val() || "";
        let obj = {
            name: $('input[name=i_name]').val() || "",
            html_markup: itemPageGenerate(name)
        }

        let obj_str = JSON.stringify(obj);
        $("#markup").val(obj_str);
    });
});

// Retrieve image source to the file input for server submit testing
function getImageOriginalSource(){
    var imgs = document.getElementsByTagName("img");

    for(var i = 0; i < imgs.length; i++){
        var imgSrc = imgs[i].src;
        var fileInput = imgs[i].parentElement.parentElement.parentElement.getElementsByTagName("input")[0];
        if (fileInput == null) continue;
        const dT = new ClipboardEvent('').clipboardData || // Firefox < 62 workaround exploiting https://bugzilla.mozilla.org/show_bug.cgi?id=1422655
            new DataTransfer(); // specs compliant (as of March 2018 only Chrome)
        dT.items.add(new File(['imgSource'], imgSrc));
        fileInput.files = dT.files;
    }
}

function uploadImage(source){
    source.parentElement.parentElement.parentElement.parentElement.firstElementChild.click();
}

function removeImage(source){
    source.parentElement.parentElement.firstElementChild.src = "../assets/images/alt/image-upload-alt.png";
    source.parentElement.parentElement.parentElement.parentElement.firstElementChild.value = "";
}

$(document).ready(function(){

    // Retrieve image source to the file input for server submit testing
    getImageOriginalSource();

    // Extra category
    $("#extra-category-button").on("click", function(){
        $("#category-section").append(getExtraCategoryHTML(getCategoryCount()));
    });

    // Extra property
    $("#extra-property-button").on("click", function(){
        var propertyCount = getPropertyCount();
        $("#property-section").append(getExtraPropertyHTML(propertyCount));
        $('#variety-table-section').append(getExtraVarietyTableRowHTML(propertyCount));
        $('#inventory-table-section').append(getExtraInventoryTableRowHTML(propertyCount));
        $("#variety-image-section").append(getExtraVarietyImageBoxHTML(propertyCount));
    });

    // Extra wholesale
    $("#extra-wholesale-button").on("click", function(){
        var min = parseInt($("#wholesale-table-section tr").last().find("input.w-min").val());
        var max = parseInt($("#wholesale-table-section tr").last().find("input.w-max").val()) + 1;
        var price = $("#wholesale-table-section tr").last().find("input.w-price").val();
        if(price != "" && min != "" && max != ""){
            $("#wholesale-table-section").append(getExtraWholesaleTableRowHTML(getWholesaleCount(), max, price));

            // Last romove button of wholesale table will always enable and the rest will be disabled
            $("#wholesale-table-section").find(".remove-button").attr("disabled", "disabled");
            $("#wholesale-table-section").find(".remove-button").last().removeAttr("disabled");

            // Last max column will always disabled and the rest will be enabled
            $(".w-max").removeAttr("disabled");
            $(".w-max").last().attr("disabled", "disabled");
        } else{
            alert("请填写最后一行的所以信息！");
        }

    });

    // Wholesale first w-min column auto sync
    $(".w-min").first().change(function(){
        $(this).parent().parent().first().find("input.w-max").attr("min", $(this).val()); // Set min value for w-max in same row
        $(this).parent().parent().first().find("input.w-price").attr("max", $(".v-price").eq(0).val()); // Set value of first wholesale after w-max is modified from blank (Apply for item without wholesale at first)
    });

    // Wholesale settings
    var first = $(".v-price").eq(0).val();
    var isSame = true;
    for(var i = 1; i < $(".v-price").length; i++){
        if ($(".v-price").eq(i).val() != first){
            isSame = false;
            break;
        }
    }

    if(isSame){
        $(".wholesale-section").show();
    } else{
        $(".wholesale-section").hide();
    }

    // For changing "active tag" when scrolling
    // Reference: https://www.steckinsights.com/change-active-menu-as-you-scroll-with-jquery/
    $(window).scroll(function() {
        var Scroll = $(window).scrollTop();
        StepOneOffset = $('#step-one').offset().top;
        StepTwoOffset = $('#step-two').offset().top - 100;
        StepThreeOffset = $('#step-three').offset().top - 100;
        StepFourOffset = $('#step-four').offset().top - 100;

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

        if (Scroll >= StepFourOffset) {
            $("#step-two-link").addClass("active");
            $("#step-three-link").removeClass("active");
        } else {
            $("#step-four-link").removeClass("active");
        }
    });

});
