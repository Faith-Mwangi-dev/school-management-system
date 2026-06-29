<?php

session_start();
include "includes/db.php";

if (!isset($_SESSION['temp_user_id']))
{
    header("Location: login.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $otp = trim($_POST['otp']);

    // Check OTP
    $stmt = $conn->prepare(
        "SELECT *
         FROM otp_codes
         WHERE user_id = ?
         AND otp_code = ?
         AND is_used = 0
         AND expires_at > NOW()
         ORDER BY id DESC
         LIMIT 1"
    );

    $stmt->bind_param(
        "is",
        $_SESSION['temp_user_id'],
        $otp
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 1)
    {
        $otpRow = $result->fetch_assoc();

        // Mark OTP as used
        $update = $conn->prepare(
            "UPDATE otp_codes
             SET is_used = 1
             WHERE id = ?"
        );

        $update->bind_param(
            "i",
            $otpRow['id']
        );

        if (!$update->execute()) {
            die("Failed to mark OTP as used.");
        }

        // Get user details
        $userStmt = $conn->prepare(
            "SELECT id, username, role
             FROM users
             WHERE id = ?"
        );

        $userStmt->bind_param(
            "i",
            $_SESSION['temp_user_id']
        );

        $userStmt->execute();

        $user = $userStmt
                    ->get_result()
                    ->fetch_assoc();

        session_regenerate_id(true);
        $token = bin2hex(random_bytes(32));

        $expires = date(
        "Y-m-d H:i:s",
        strtotime("+1 day")
        );

        $cleanup = $conn->prepare(
            "DELETE FROM user_sessions
            WHERE expires_at < NOW()
            OR is_active = 0"
        );

        $cleanup->execute();

        $deactivate = $conn->prepare(
            "UPDATE user_sessions
            SET is_active = 0
            WHERE user_id = ?"
        );

        $deactivate->bind_param("i", $user['id']);
        $deactivate->execute();
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

        // Create login session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['session_token'] = $token;

        unset($_SESSION['temp_user_id']);

        header("Location: index.php");
        exit();
    }
    else
    {
        $error = "Invalid or expired OTP.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4"> Verify OTP </h3>
                    <?php if($error != ""): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label"> Enter OTP </label>
                            <input type="text"name="otp" class="form-control" required>
                        </div>
                        <button class="btn btn-primary w-100"> Verify OTP </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>