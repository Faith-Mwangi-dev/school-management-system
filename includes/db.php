<?php
$conn = new mysqli ('localhost', 'root', '', 'school_system');
if ($conn-> connect_error){
    die('connection failed: ' . $conn->connect_error);
}
?>