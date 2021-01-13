//This js file contains a list of table functions in jQuery
//This is to hide or show table columns

function table_col_node(ind) {
    this.ind = ind;
    this.flag = true;
}

function get_table_col(startFrom = 0) {
    let table_headers = document.querySelectorAll("thead>tr th"), table_col = {};
    for (let i = startFrom; i < table_headers.length; i++) {
        let str = table_headers[i].innerHTML;
        table_col[str] = new table_col_node(i + 1);
    }
    return table_col;
}

function generate_detail_row_html(str) {
    return `&nbsp;<input type="checkbox" name="${str}" checked="checked" />&nbsp;<label for="${str}">${str}</label><br />`;
}

function generate_detail_html(obj_arr) {
    let str = "";
    for (let key of Object.keys(obj_arr)) {
        str += generate_detail_row_html(key);
    }
    str = str.slice(0, -6);
    $("#detail_board").append(str);
}

//Show columns based on table column number
function show_col(ind) {
    $(`td:nth-child(${ind}),th:nth-child(${ind})`).show();
}

function show_col_all(table_col) {
    for (let tble in table_col) {
        if (!table_col[tble].flag) {
            show_col(table_col[tble].ind);
            $(`#detail_board input[name='${tble}']`).prop("checked", true);
            table_col[tble].flag = true;
        }
    }
}

//Hide columns based on table column number
function hide_col(ind) {
    $(`td:nth-child(${ind}),th:nth-child(${ind})`).hide();
}

function hide_col_full(str, table_col){
    $(`#detail_board input[name='${str}']`).prop("checked", false);
    table_col[str].flag = false;
    hide_col(table_col[str].ind);
}
