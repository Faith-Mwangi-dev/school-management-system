<?php

include "includes/db.php";

echo "PHP Time: " . date("Y-m-d H:i:s");

echo "<br><br>";

$result = $conn->query("SELECT NOW() AS mysql_time");

$row = $result->fetch_assoc();

echo "MySQL Time: " . $row['mysql_time'];