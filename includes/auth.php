<?php

session_start();
include "includes/db.php";

if (!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare(
    "SELECT *
     FROM user_sessions
     WHERE user_id = ?
     AND token = ?
     AND is_active = 1
     AND expires_at > NOW()"
);

$stmt->bind_param(
    "is",
    $_SESSION['user_id'],
    $_SESSION['session_token']
);

$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 1)
{
    $update = $conn->prepare(
        "UPDATE user_sessions
         SET expires_at = DATE_ADD(NOW(), INTERVAL 1 DAY)
         WHERE token = ?"
    );

    $update->bind_param(
        "s",
        $_SESSION['session_token']
    );

    $update->execute();
}
else
{
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
}