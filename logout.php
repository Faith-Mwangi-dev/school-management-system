<?php
session_start();
include "includes/db.php";

$stmt = $conn->prepare(
    "UPDATE user_sessions
     SET is_active = 0
     WHERE token = ?"
);

$stmt->bind_param(
    "s",
    $_SESSION['session_token']
);

$stmt->execute();

session_destroy();

header("Location: login.php");

exit();
?>