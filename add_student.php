<?php 
    include "includes/db.php" ;
    include "includes/header.php" ;
?>

<div class="container">
    <div class= "card-body">
        <form action = "actions/insert_student.php" method ="POST">
            <input type = "text" name="fname" placeholder="First Name" required><br><br>
            <input type = "text"  name="lname"  placeholder="Last Name" required><br><br>
            <input type = "text" name="student_id" placeholder="Student ID" required><br><br>
            <select name = "gender">
                <option> Female </option>
                <option> Male </option>
                <option> Other </option>
            </select><br><br>
            <button type = "submit" btn btn-success> Register </button>
        </form>
    </div>
</div>

<?php include "includes/footer.php" ; ?>