<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script/query.js" defer></script>
</head>

<a id="top"></a>
<h2>Query Database: </h2>
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
<input type="text" placeholder="Enter valid serial number" name="serial_number" id="serial_number">

<br>

<button id="submit_query">Make query</button>


<ul id="query_container"></ul>
<a href="#top">Return to top</a>