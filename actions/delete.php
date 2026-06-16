<?php
include "../includes/db.php";
if ($_SESSION['role'] != 'admin') {
    die("Access Denied");
}
$id = $_GET['id'];
$conn->query("DELETE FROM students WHERE id=$id");
header("Location: ../index.php");
?>