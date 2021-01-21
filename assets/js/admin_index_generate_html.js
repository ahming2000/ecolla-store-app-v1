//This javascript file is solely for generating html string
//As we all know, code are just strings
//If we based our concept in this direction, we'll be able to achieve more functions easily


//The three functions generate the html for displaying total items sold, total sales and date
function generate_report_info_desktop(date, price, sold){
    return `
        <div class="row text-center h5" id="in_form_">
            <div class="col-4">Date: <input type="date" name="report_date" id="date_" max="${date}" /></div>
            <div class="col-4">Total Sales Revenue: RM ${price}</div>
            <div class="col-4">Total number of items sold: ${sold}</div>
        </div>
    `;
}

function generate_report_info_ipad(date, price, sold){
    return `
        <div class="row text-center" id="in_form_">
            <div class="report_info_txt" style="width: 32%;">
                <strong>Date: <input type="date" name="report_date" id="date_" max="${date}" /></strong>
            </div>

            <div class="report_info_txt" style="width: 32%;">
                <strong>Total Sales Revenue: RM ${price}</strong>
            </div>

            <div class="report_info_txt" style="width: 36%;">
                <strong>Total number of items sold: ${sold}</strong>
            </div>
        </div>
    `;
}

function generate_report_info_phone(date, price, sold){
    return `
        <div class="row" id="in_form_">
            <div class="col">
                <div><strong>Date: </strong><input type="date" name="report_date" id="date_" max="${date}" /></div>
                <div><strong>Total Sales Revenue: RM ${price}</strong></div>
                <div><strong>Total number of items sold: ${sold}</strong></div>
            </div>
        </div>
    `;
}

//Generate Weekly Sales Report Title
function generate_week_title_phone(){
    return `<div class="bg-primary h2 text-center" id="weekly_"  style="color: white;">周期销售报告</div>`;
}

function generate_week_title_default(){
    return `<div class="bg-primary h1 text-center" id="weekly_"  style="color: white;">周期销售报告</div>`;
}
