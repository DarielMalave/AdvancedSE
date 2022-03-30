const container = document.getElementById('query_container');

$.ajax({
        type: "POST",
        url: "process.php",
        data: {
            
        },
        success: function(response) {
            let updated_data_source = JSON.parse(decodeURIComponent(response));
            display_query(container, updated_data_source);
        }
    });

function display_query(container, data_source) {
    for (let i = 0; i < 100; i++) {
        let query_row = "" + data_source[i]['type'] + ", " + data_source[i]['manufacturer'] + ", " + data_source[i]['serial_number'];
        let list_item = document.createElement('li');

        list_item.innerText = query_row;

        container.appendChild(list_item);
    }
}