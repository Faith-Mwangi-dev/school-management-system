<?php
include "../includes/db.php";
include "includes/auth.php";

if (
    $_SESSION['role'] != 'admin' &&
    $_SESSION['role'] != 'principal'
) {
    die("Access Denied");
}


$fname = $_POST['fname'];
$lname = $_POST['lname'];
$student_id = $_POST['student_id'];
$gender = $_POST['gender'];

$sql = "INSERT INTO students (fname, lname, student_id, gender) VALUES('$fname', '$lname', '$student_id', '$gender')";

if ($conn->query($sql)){
    header("Location: ../index.php");
} else {
    echo "Error: " . $conn->error;
}
?>