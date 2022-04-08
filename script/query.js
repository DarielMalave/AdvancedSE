const container = document.getElementById('query_container');
const type = document.getElementById('type');
const manufacturer = document.getElementById('manufacturer');
const serial_number = document.getElementById('serial_number');
const page_display = document.getElementById('current_page_display');
const pagination_bar = document.getElementById('pagination_bar');
const current_page = document.getElementById('current_page_counter');
const rows_per_page = 100;

$.ajax({
    type: "POST",
    url: "process.php",
    data: {
        device_type: type.value,
        manufacturer: manufacturer.value,
        serial_number: serial_number.value,
        cardCountUpdated: 0,
        rowsPerPage: rows_per_page
    },
    success: function(response) {
        console.log("Default response received");
        let updated_data_source = JSON.parse(decodeURIComponent(response));
        display_query(container, updated_data_source, rows_per_page);
    }
});

let submit_button = document.getElementById('submit_query');
submit_button.addEventListener("click", function(){
    current_page.value = 1;
    page_display.innerText = "Page 1";
   $.ajax({
        type: "POST",
        url: "process.php",
        data: {
            device_type: type.value,
            manufacturer: manufacturer.value,
            serial_number: serial_number.value,
            cardCountUpdated: 0,
            rowsPerPage: rows_per_page
        },
        success: function(response) {
            console.log("Response received");
            let updated_data_source = JSON.parse(decodeURIComponent(response));
            display_query(container, updated_data_source, rows_per_page);
        }
    });
});

// When user clicks next button, trigger AJAX event that will have client
// send a POST request to receive card information of the next page in
// search query
$("#next_button").click(function(e) {
    e.preventDefault();
    current_page.value++;
    page_display.innerText = "Page " + current_page.value;

    let current_page_count = parseInt(document.getElementById('current_page_counter').value);
    let cardCount = (current_page_count - 1) * rows_per_page;

    $.ajax({
        type: "POST",
        url: "process.php",
        data: {
            device_type: type.value,
            manufacturer: manufacturer.value,
            serial_number: serial_number.value,
            cardCountUpdated: cardCount,
            rowsPerPage: rows_per_page
        },
        success: function(response) {
            let updated_data_source = JSON.parse(decodeURIComponent(response));
            console.log(updated_data_source.length);
            if (updated_data_source.length === 0) {
                current_page.value--;
                page_display.innerText = current_page.value;
                cardCount -= rows_per_page;
                return;
            }

            display_query(container, updated_data_source, rows_per_page);
        }
    });
});

$("#previous_button").click(function(e) {
    e.preventDefault();
    if ((current_page.value - 1) < 1) {
        return;
    }

    current_page.value--;
    page_display.innerText = "Page " + current_page.value;

    let current_page_count = parseInt(document.getElementById('current_page_counter').value);
    let cardCount = (current_page_count - 1) * rows_per_page;

    $.ajax({
        type: "POST",
        url: "process.php",
        data: {
            device_type: type.value,
            manufacturer: manufacturer.value,
            serial_number: serial_number.value,
            cardCountUpdated: cardCount,
            rowsPerPage: rows_per_page
        },
        success: function(response) {
            let updated_data_source = JSON.parse(decodeURIComponent(response));
            display_query(container, updated_data_source, rows_per_page);
        }
    });

});


function display_query(container, data_source) {
    container.innerHTML = "";

    if (data_source.length === 0) {
        let error_element = document.createElement('li');
        error_element.innerText = "No results returned. Please try again.";
        container.appendChild(error_element);
        return;
    }

    if (typeof(data_source) !== 'object') {
        let error_element = document.createElement('li');
        error_element.innerText = "No results returned. Please check if query is valid.";
        container.appendChild(error_element);
        return;
    }

    for (let i = 0; i < data_source.length; i++) {
        let active_state = (data_source[i]['active'] == 0) ? "Active" : "Not Active";

        let query_row = "" + data_source[i]['auto_id'] + ", " + data_source[i]['type'] + ", " + data_source[i]['manufacturer'] + ", SN-" + data_source[i]['serial_number'] + ", " + active_state;
        let list_item = document.createElement('li');

        list_item.innerText = query_row;

        container.appendChild(list_item);
    }
}