const container = document.getElementById('query_container');
const type = document.getElementById('type');
const manufacturer = document.getElementById('manufacturer');
const serial_number = document.getElementById('serial_number');

let submit_button = document.getElementById('submit_query');
submit_button.addEventListener("click", function(){
//    console.log(type.value);
//    console.log(manufacturer.value);
//    console.log(serial_number.value);
   $.ajax({
        type: "POST",
        url: "process.php",
        data: {
            device_type: type.value,
            manufacturer: manufacturer.value,
            serial_number: serial_number.value
        },
        success: function(response) {
            //console.log(response);
            let updated_data_source = JSON.parse(decodeURIComponent(response));
            display_query(container, updated_data_source);
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

    for (let i = 0; i < 100; i++) {
        let query_row = "" + data_source[i]['type'] + ", " + data_source[i]['manufacturer'] + ", " + data_source[i]['serial_number'];
        let list_item = document.createElement('li');

        list_item.innerText = query_row;

        container.appendChild(list_item);
    }
}