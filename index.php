<head>
    <link rel="stylesheet" href="styles.css"></link>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script/query.js" defer></script>
</head>

<a id="top"></a>

<div class="title_con">
    <h2>Query Database </h2>
    <div class="dropdown">
        <img src="circle-question-solid.svg" class="icon">
        <div class="dropdown-content">
            <div class="info_text">
                <ul>
                    <li>By default, the page will load with the first 100 records of the database.</li>
                    <br>
                    <li>Query will display 100 records per page.</li>
                    <br>
                    <li>When searching for an exact serial number, it will take some time because the database
                        is searching through 5 million records. The pagination buttons may not behave normally
                        until query is displayed.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<label for="type">Select device type:</label>
<select id="type" name="type">
    <option value="">None</option>
    <option value="projector">Projector</option>
    <option value="television">Television</option>
    <option value="mobile phone">Mobile phone</option>
    <option value="vehicle">Vehicle</option>
    <option value="computer">Computer</option>
    <option value="tablet">Tablet</option>
    <option value="laptop">Laptop</option>
</select>

<br>

<label for="manufacturer">Enter manufacturer name: </label>
<input type="text" placeholder="Enter valid name" name="manufacturer" id="manufacturer">

<br>

<label for="serial_number">Enter serial number: </label>
<input type="text" placeholder="Enter exact serial number" name="serial_number" id="serial_number">

<br>

<button id="submit_query">Make query</button>

<ul id="query_container"></ul>

<!-- Pagination portion -->
<section id="pagination_bar">
    <button id="previous_button">Previous Page</button>
    <button id="current_page_display">Page 1</button>
    <button id="next_button">Next Page</button>
</section>

<input id="current_page_counter" type="hidden" value="1">
<!-- ====================== -->

<br>

<a href="#top">Return to top</a>

<hr>

<h2>Add Devices to Database</h2>