<head>
    <link rel="stylesheet" href="styles.css">
    </link>
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

<div class="title_con">
    <h2>Add Device to Database</h2>
    <div class="dropdown">
        <img src="circle-question-solid.svg" class="icon">
        <div class="dropdown-content">
            <div class="info_text">
                <ul>
                    <li>Enter the new device's type, manufacturer, and serial number.</li>
                    <br>
                    <li>Must be unique serial number - duplicate serial numbers will not be accepted. Because of this,
                        adding a device will search through all five million records and will take to some time.
                    </li>
                    <br>
                    <li>
                        Preferably do not add new device type and/or manufacturer with device - try to keep both fields
                        within the 7 pre-defined device type and 30 manufacturer names from the 5 million records.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
    if (isset($_GET['manfail'])) {
        echo "<p>Invalid manufacturer name.</p>";
    }
    if (isset($_GET['serialfail'])) {
        echo "<p>Invalid serial number.</p>";
    }
    if (isset($_GET['duplicate'])) {
        echo "<p>Duplicate serial number. Please try unique serial number.</p>";
    }
    if (isset($_GET['addsuccess'])) {
        echo "<p>Device successfully added.";
    }
?>

<form action="add_device.php" method="POST">
    <label for="type">Select device type:</label>
    <select id="new_type" name="new_type" required>
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
    <input type="text" placeholder="Enter valid name" name="new_manufacturer" id="new_manufacturer" required>

    <br>

    <label for="serial_number">Enter serial number: </label>
    <input type="text" placeholder="Enter exact serial number" name="new_serial_number" id="new_serial_number" required>

    <br>

    <button type="submit" name="new_device">Insert New Device</button>
</form>

<br>

<a href="#top">Return to top</a>

<hr>

<div class="title_con">
    <h2>Modify Device in Database</h2>
    <div class="dropdown">
        <img src="circle-question-solid.svg" class="icon">
        <div class="dropdown-content">
            <div class="info_text">
                <ul>
                    <li>Enter existing serial number then select new device type, manufacturer, and/or new serial
                        number.</li>
                    <li>You must enter a valid manufacturer and device type, but new serial number is optional.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
    if (isset($_GET['modnotfound'])) {
        echo "<p>Serial number not found.</p>";
    }

    if (isset($_GET['manfail'])) {
        echo "<p>Invalid manufacturer name.</p>";
    }

    if (isset($_GET['modsuccess'])) {
        echo "<p>Modification successful.</p>";
    }
?>

<form action="modify_device.php" method="POST">
    <label for="mod_serial_number">Enter serial number: </label>
    <input type="text" placeholder="Enter existing serial number" name="mod_serial_number" id="mod_serial_number"
        required>

    <br>

    <label for="new_mod_serial_number">Enter new serial number (optional): </label>
    <input type="text" placeholder="Enter new serial number" name="new_mod_serial_number" id="new_mod_serial_number">

    <br>

    <label for="type">Select new device type:</label>
    <select id="mod_type" name="mod_type" required>
        <option value="projector">Projector</option>
        <option value="television">Television</option>
        <option value="mobile phone">Mobile phone</option>
        <option value="vehicle">Vehicle</option>
        <option value="computer">Computer</option>
        <option value="tablet">Tablet</option>
        <option value="laptop">Laptop</option>
    </select>

    <br>

    <label for="mod_manufacturer">Enter new manufacturer name: </label>
    <input type="text" placeholder="Enter valid name" name="mod_manufacturer" id="mod_manufacturer" required>

    <br>

    <button type="submit" name="mod_device">Modify Device</button>
</form>

<br>

<a href="#top">Return to top</a>

<hr>

<div class="title_con">
    <h2>Delete Device From Database</h2>
    <div class="dropdown">
        <img src="circle-question-solid.svg" class="icon">
        <div class="dropdown-content">
            <div class="info_text">
                <ul>
                    <li>Enter an existing serial number for a device to delete it.</li>
                    <li>Deleting based on device type or manufacturer is not allowed because that could allow
                        users to delete hundreds of thousands of records in a single click.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
    if (isset($_GET['deletenotfound'])) {
        echo "<p>Serial number not found. Please insert existing serial number.</p>";
    }

    if (isset($_GET['deletesuccess'])) {
        echo "<p>Deleted serial number successfully.</p>";
    }
?>

<form action="delete_device.php" method="POST">
    <label for="delete_serial_number">Enter serial number to delete: </label>
    <input type="text" placeholder="Enter existing serial number" name="delete_serial_number" id="delete_serial_number"
        required>

    <br>

    <button type="submit" name="delete_device">Delete Device</button>
</form>

<br>

<a href="#top">Return to top</a>

<hr>

<div class="title_con">
    <h2>Upload PDF File to Device</h2>
    <div class="dropdown">
        <img src="circle-question-solid.svg" class="icon">
        <div class="dropdown-content">
            <div class="info_text">
                <ul>
                    <li>Upload a PDF file and bind it to a specific device by giving the device's exact serial number.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<form method="post" enctype="multipart/form-data" action="upload_file.php">
    <label for="file_serial_number">Enter serial number to bind: </label>
    <input type="text" placeholder="Enter existing serial number" name="file_serial_number" id="file_serial_number"
        required>
    <br>
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
    <input name="userfile" type="file" id="userfile" required>
    <br>
    <br>
    <button type="submit" name="upload_file">Upload File</button>
</form>

<br>

<a href="#top">Return to top</a>

<hr>

<div class="title_con">
    <h2>View PDF Files from Specific Devices</h2>
    <div class="dropdown">
        <img src="circle-question-solid.svg" class="icon">
        <div class="dropdown-content">
            <div class="info_text">
                <ul>
                    <li>Enter an exact serial number to view any PDF file(s) bound to that exact device.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
    if (isset($_GET['pdfnotfound'])) {
        echo "<p>Serial number not found. Please insert existing serial number.</p>";
    }
?>

<form method="post" action="">
    <label for="get_serial_number">Enter serial number to find PDF:</label>
    <input type="text" placeholder="Enter existing serial number" name="get_serial_number" id="get_serial_number"
        required>
    <br>
    <button type="submit" name="get_file">Find PDF Files</button>
</form>

<?php
    include('setup_db.php');
    $mysqli = db_iconnect("equipment");
    if (isset($_POST['get_file'])) {
        $get_serial_number = $_POST['get_serial_number'];
        $get_serial_number = trim($get_serial_number, "SN-");
        $device_id = "";
    
        $fetchDuplicate = $mysqli->query("SELECT * FROM devices WHERE serial_number = '$get_serial_number' LIMIT 1") or die($mysqli->error());
        if (mysqli_num_rows($fetchDuplicate) == 0) {
            header("location: index.php?pdfnotfound");
            exit();
        }

        $row = $fetchDuplicate->fetch_assoc();
        $device_id = $row['auto_id'];

        $query = "SELECT * FROM files WHERE device_id = '$device_id'";
        $result = $mysqli->query($query) or die($mysqli->error());
        if (mysqli_num_rows($result) == 0) {
            echo "<p>No PDF found associated with this serial number.</p>";
            exit();
        }
    
        while ($row = $result->fetch_assoc()) {
            echo "<a href='./files/" . $row['file_name'] . "' target='_blank'>" . $row['file_name'] . "</a>";
            echo "<br>";
        }
    }
?>

<br>

<a href="#top">Return to top</a>