<?php

session_start();
date_default_timezone_set("Africa/Nairobi");
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    header("Location: login.php");
    exit();
}
include "includes/db.php";

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare(
    "SELECT *
     FROM users
     WHERE username = ?"
);

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if (
    $user &&
    password_verify(
        $password,
        $user['password']
    )
)
{
    // Check if 2FA is enabled
    if ($user['two_factor_enabled'] == 1)
    {
        // Generate OTP
        $otp = random_int(100000, 999999);

        // Set expiry time
        $expires = date(
            "Y-m-d H:i:s",
            strtotime("+5 minutes")
        );

        // Save OTP in database
        $otpStmt = $conn->prepare(
            "INSERT INTO otp_codes
            (user_id, otp_code, expires_at)
            VALUES (?, ?, ?)"
        );

        $otpStmt->bind_param(
            "iss",
            $user['id'],
            $otp,
            $expires
        );

        if ($otpStmt->execute())
        {
            $_SESSION['temp_user_id'] = $user['id'];

        header("Location: verify_otp.php");
        exit();
}
else
{
    die("Database Error: " . $otpStmt->error);
}
       
    }
    else
{
    session_regenerate_id(true);

    // Generate session token
    $token = bin2hex(random_bytes(32));

    $expires = date(
        "Y-m-d H:i:s",
        strtotime("+1 day")
    );

    // Save token in database
    $sessionStmt = $conn->prepare(
        "INSERT INTO user_sessions
        (user_id, token, expires_at, is_active)
        VALUES (?, ?, ?, 1)"
    );

    $sessionStmt->bind_param(
        "iss",
        $user['id'],
        $token,
        $expires
    );

    $sessionStmt->execute();

    // Create session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['session_token'] = $token;

    header("Location: index.php");
    exit();
}
}
else
{
    echo "Invalid credentials";
}