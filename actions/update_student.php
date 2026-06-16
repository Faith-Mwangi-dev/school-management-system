<?php include "../includes/db.php"; ?>
<?php include "includes/authenticate.php"; ?>

<?php

if (
    $_SESSION['role'] != 'admin' &&
    $_SESSION['role'] != 'principal'
) {
    die("Access Denied");
}
?>

<?php
//collectinf data from the form
$id = $_POST['id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$student_id = $_POST['student_id'];
$gender = $_POST['gender'];


$conn->query("UPDATE students SET 
    fname='$fname',
    lname='$lname',
    student_id='$student_id',
    gender='$gender'
    WHERE id=$id
");
//After updating, goes back to tasklist. Prevents resubmission
header("Location: ../index.php");
?>