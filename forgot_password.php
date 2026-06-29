<?php
include "includes/db.php";
?>

<!DOCTYPE html>

<head>
    <title>Forgot Password</title>
</head>

<h2>Forgot Password</h2>

<?php
if(isset($error)){
    echo "<p style='color:red;'>$error</p>";
}
?>

<form action="reset_password.php" method="POST">

    Username:
    <input type="text" name="username" required>

    New Password:
    <input type="password" name="password" required>

    <button type="submit">
        Reset Password
    </button>

</form>
<?php include "includes/footer.php"; ?>