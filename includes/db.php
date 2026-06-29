<?php
date_default_timezone_set("Africa/Nairobi");
$conn = new mysqli ('localhost', 'root', '', 'school_system');
if ($conn-> connect_error){
    die('connection failed: ' . $conn->connect_error);
}


?>