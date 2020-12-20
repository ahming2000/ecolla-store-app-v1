$(function () {
    console.log("Post_code.js has been loaded successfully!");

    let name_x = "c_state", name_y = "c_area", name_z = "c_postal_code",
    id_x = "c-state", id_y = "c-area", id_z = "c-postal-code";

    let post_code_data = [],
        states = ["Perlis", "Kedah", "Penang", "Kelantan", "Terengganu", "Pahang", "Selangor", "Perak", "Kuala Lumpur", "Putrajaya", "Negeri Sembilan", "Melaka", "Johor", "Labuan", "Sabah", "Sarawak"],
        state_id = 0, state_bool = [], state_flag = 0
        state_cnt = `<div class="container" id="state_cnt" style="width: 320px; height: 250px; background-color: rgb(58, 57, 57); color: white; position: absolute; z-index: 2; overflow: auto;"></div>`,
        cities = {},
        city_id = 0, city_bool = [], city_flag = 0,
        city_cnt = `<div class="container" id="city_cnt" style="width: 320px; height: 250px; background-color: rgb(58, 57, 57); color: white; position: absolute; z-index: 2; overflow: auto;"></div>`,
        zipCode = {},
        zipCode_id = 0, zipCode_bool = [], zipCode_flag = 0,
        zipCode_cnt = `<div class="container" id="zipCode_cnt" style="width: 320px; height: 250px; background-color: rgb(58, 57, 57); color: white; position: absolute; z-index: 2; overflow: auto;"></div>`,
        max_height = 300;

    //arrange in ascending order
    states = states.sort((a, b) => (a.toLowerCase() > b.toLowerCase()) ? 1 : -1);

    $.ajax({
        url: "../assets/js/post_code.json",
        type: "get"
    }).done(data => {
        post_code_data = data;
        for (let k of states) {
            cities[k] = post_code_data.filter(e => e.State == k)
                .map(e => e.City)
                .filter((x, i, arr) => arr.indexOf(x) === i)
                .sort((a, b) => (a.toLowerCase() > b.toLowerCase()) ? 1 : -1); // Filter the cities according to states
        }

        for (let k in cities) {
            for (let l of cities[k]) {
                zipCode[l] = post_code_data.filter(e => e.State == k)
                    .filter(e => e.City == l)
                    .map(e => e.Post_Code)
                    .filter((x, i, arr) => arr.indexOf(x) === i);
            }
        }
    });

    $(`input[name='${name_x}']`).focus(e => {
        state_id = 0;
        state_bool = [];

        let cur_height = 0;

        //append the selection input box
        $(`#${id_x}`).append(state_cnt);

        for (let i in states) {
            //Initialize state boolean flag as all false; This is to prevent blur function from overriding
            state_bool.push(0);

            //add the rows of states into state_cnt
            $("#state_cnt").append(row_html(states[i], 1));

            cur_height += $(`#state${i}`).height() + 10;

            //hover function
            $(`#state${i}`).mouseenter(e => {
                $(`#state${i}`).css("background-color", "rgb(95, 93, 93)");
                state_bool[i] = 1;
            });

            $(`#state${i}`).mouseleave(e => {
                $(`#state${i}`).css("background-color", "rgb(58, 57, 57)");
                state_bool[i] = 0;
            });
        }

        if (cur_height < max_height) {
            $("#state_cnt").css("height", `${cur_height}px`);
        } else {
            $("#state_cnt").css("height", `${max_height}px`);
        }
    });

    $(`input[name='${name_x}']`).keyup(e => {
        if ($("#state_cnt").length != 0) {
            let input = $(`input[name='${name_x}']`).val() || "";

            input = input.toUpperCase();

            let cur_height = 0;

            for (let i = 0; i < states.length; i++) {
                let str = $(`#state${i}`).html();

                if (str.toUpperCase().indexOf(input) > -1) {
                    cur_height += $(`#state${i}`).height() + 10;
                    $(`#state${i}`).css("display", "");
                } else {
                    $(`#state${i}`).css("display", "None");
                }
            }

            if (cur_height < max_height) {
                $("#state_cnt").css("height", `${cur_height}px`);
            } else {
                $("#state_cnt").css("height", `${max_height}px`);
            }
        }
    });

    $(`input[name='${name_x}']`).blur(e => {
        state_flag = 0; // used to allow empty values

        for (let i in states) {
            if (state_bool[i] == 1) {
                $(`input[name='${name_x}']`).val(states[i]);
                $(`input[name='${name_y}']`).val("");
                $(`input[name='${name_z}']`).val("");
                $(`input[name='${name_y}']`).attr('disabled', 'disabled');
                $(`input[name='${name_z}']`).attr('disabled', 'disabled');
                state_flag = 1;
            }
        }

        if (state_flag == 0 && !$(`input[name='${name_x}']`).val()) {
            $(`input[name='${name_x}']`).val("");
            $(`input[name='${name_y}']`).val("");
            $(`input[name='${name_z}']`).val("");
            $(`input[name='${name_y}']`).attr('disabled', 'disabled');
            $(`input[name='${name_z}']`).attr('disabled', 'disabled');
        }

        if ($(`input[name='${name_x}']`).val()) {
            $(`input[name='${name_y}']`).removeAttr('disabled');
        }

        $("#state_cnt").remove();
    });

    $(`input[name='${name_y}']`).focus(e => {
        city_id = 0;
        city_bool = [];

        let cur_state = $(`input[name='${name_x}']`).val(), arr = cities[cur_state], cur_height = 0;

        //append the selection input box
        $(`#${id_y}`).append(city_cnt);

        for (let i in arr) {
            //Initialize city boolean flag as all false; This is to prevent blur function from overriding
            city_bool.push(0);

            //add the rows of cities into city_cnt
            $("#city_cnt").append(row_html(arr[i], 2));

            cur_height += $(`#city${i}`).height() + 10;

            //hover function
            $(`#city${i}`).mouseenter(e => {
                $(`#city${i}`).css("background-color", "rgb(95, 93, 93)");
                city_bool[i] = 1;
            });
            $(`#city${i}`).mouseleave(e => {
                $(`#city${i}`).css("background-color", "rgb(58, 57, 57)");
                city_bool[i] = 0;
            });
        }

        if (cur_height < max_height) {
            $("#city_cnt").css("height", `${cur_height}px`);
        } else {
            $("#city_cnt").css("height", `${max_height}px`);
        }
    });

    $(`input[name='${name_y}']`).keyup(e => {
        if ($("#city_cnt").length != 0) {
            let input = $(`input[name='${name_y}']`).val() || "";

            input = input.toUpperCase();

            let cur_height = 0;

            for (let i = 0; i < city_id; i++) {
                let str = $(`#city${i}`).html();

                if (str.toUpperCase().indexOf(input) > -1) {
                    cur_height += $(`#city${i}`).height() + 10;
                    $(`#city${i}`).css("display", "");
                } else {
                    $(`#city${i}`).css("display", "None");
                }
            }

            if (cur_height < max_height) {
                $("#city_cnt").css("height", `${cur_height}px`);
            } else {
                $("#city_cnt").css("height", `${max_height}px`);
            }
        }
    });

    $(`input[name='${name_y}']`).blur(e => {
        let cur_state = $(`input[name='${name_x}']`).val(), arr = cities[cur_state];

        city_flag = 0; // used to allow empty values

        for (let i in arr) {
            if (city_bool[i] == 1) {
                $(`input[name='${name_y}']`).val(arr[i]);
                $(`input[name='${name_z}']`).val("");
                $(`input[name='${name_z}']`).attr('disabled', 'disabled');
                city_flag = 1;
            }
        }

        if (city_flag == 0 && !$(`input[name='${name_y}']`).val()) {
            $(`input[name='${name_y}']`).val("");
            $(`input[name='${name_z}']`).val("");
            $(`input[name='${name_z}']`).attr('disabled', 'disabled');
        }

        if ($(`input[name='${name_y}']`).val()) {
            $(`input[name='${name_z}']`).removeAttr('disabled');
        }

        $("#city_cnt").remove();
    });

    $(`input[name='${name_z}']`).focus(e => {
        zipCode_id = 0;
        zipCode_bool = [];

        let cur_city = $(`input[name='${name_y}']`).val(), arr = zipCode[cur_city], cur_height = 0;

        //append the selection input box
        $(`#${id_z}`).append(zipCode_cnt);

        for (let i in arr) {
            //Initialize city boolean flag as all false; This is to prevent blur function from overriding
            zipCode_bool.push(0);

            //add the rows of cities into city_cnt
            $("#zipCode_cnt").append(row_html(arr[i], 3));

            cur_height += $(`#zipCode${i}`).height() + 10;

            //hover function
            $(`#zipCode${i}`).mouseenter(e => {
                $(`#zipCode${i}`).css("background-color", "rgb(95, 93, 93)");
                zipCode_bool[i] = 1;
            });
            $(`#zipCode${i}`).mouseleave(e => {
                $(`#zipCode${i}`).css("background-color", "rgb(58, 57, 57)");
                zipCode_bool[i] = 0;
            });
        }

        if (cur_height < max_height) {
            $("#zipCode_cnt").css("height", `${cur_height}px`);
        } else {
            $("#zipCode_cnt").css("height", `${max_height}px`);
        }
    });

    $(`input[name='${name_z}']`).keyup(e => {
        if ($("#zipCode_cnt").length != 0) {
            let input = $(`input[name='${name_z}']`).val() || "";

            input = input.toUpperCase();

            let cur_height = 0;

            for (let i = 0; i < zipCode_id; i++) {
                let str = $(`#zipCode${i}`).html();

                if (str.toUpperCase().indexOf(input) > -1) {
                    cur_height += $(`#zipCode${i}`).height() + 10;
                    $(`#zipCode${i}`).css("display", "");
                } else {
                    $(`#zipCode${i}`).css("display", "None");
                }
            }

            if (cur_height < max_height) {
                $("#zipCode_cnt").css("height", `${cur_height}px`);
            } else {
                $("#zipCode_cnt").css("height", `${max_height}px`);
            }
        }
    });

    $(`input[name='${name_z}']`).blur(e => {
        let cur_city = $(`input[name='${name_y}']`).val(), arr = zipCode[cur_city];

        zipCode_flag = 0; // used to allow empty values

        for (let i in arr) {
            if (zipCode_bool[i] == 1) {
                $(`input[name='${name_z}']`).val(arr[i]);
                zipCode_flag = 1;
            }
        }

        if (zipCode_flag == 0 && !$(`input[name='${name_z}']`).val()) {
            $(`input[name='${name_z}']`).val("");
        }

        $("#zipCode_cnt").remove();
    });

    function row_html(str, options) {
        // options 1 = state, 2 = city, 3 = zip Code
        let option_str = (options == 1) ? "state" : (options == 2) ? "city" : (options == 3) ? "zipCode" : "default";
        return `
            <div class="row pt-1 pb-1" id="${option_str}${(options == 1) ? state_id++ : (options == 2) ? city_id++ : zipCode_id++}">
                ${str}
            </div>
        `;
    }

    //light gray - rgb(95, 93, 93)
    //dark gray - rgb(58, 57, 57)
});