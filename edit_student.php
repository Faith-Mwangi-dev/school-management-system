<?php include "includes/auth.php"; ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php
if (
    $_SESSION['role'] != 'admin' &&
    $_SESSION['role'] != 'principal'
) {
    die("Access Denied");
}


$id = $_GET['id']; // Reads from URL
$result = $conn->query("SELECT * FROM students WHERE id = $id"); //Runs an sql query on database
$row = $result->fetch_assoc(); //Fetches one row and returns it as an associative array
?>

<h2>Edit Student</h2>
<div class = "container">
    <form action="actions/update_student.php" method="POST">

        <!-- Sends id again via POST -->
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label>Name:</label><br>

        <!-- Input is pre-filled -->
        <input type="text" name="fname" value="<?php echo $row['fname']; ?>"><br><br>
        <input type="text" name="lname" value="<?php echo $row['lname']; ?>"><br><br>

        <label>Student ID:</label><br>
        <!-- Input is pre-filled -->
        <input type="text" name="student_id" value="<?php echo $row['student_id']; ?>"><br><br>
        <label>Gender:</label><br>
        <select name="gender">

            <option value="Female"
            <?php if($row['gender'] == 'Female') echo 'selected'; ?>>
            Female
            </option>

            <option value="Male"
            <?php if($row['gender'] == 'Male') echo 'selected'; ?>>
            Male
            </option>

            <option value="Other"
            <?php if($row['gender'] == 'Other') echo 'selected'; ?>>
            Other
            </option>

        </select><br><br>

        <button type="submit">Update Student</button>

    </form>
</div>

<?php include "includes/footer.php"; ?>