<?php

include "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST['username'];

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    $stmt = $conn->prepare(
        "INSERT INTO users
        (username,password)
        VALUES (?,?)"
    );

    $stmt->bind_param(
        "ss",
        $username,
        $password
    );

    $stmt->execute();
}
?>
<form method="POST">
    Username
    <input type="text" name="username">

    Password
    <input type="password" name="password">

    <button>Add User</button>
</form>