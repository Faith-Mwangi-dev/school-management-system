<?php

 include "includes/auth.php"; 
 include "includes/db.php"; 
 include "includes/header.php"; 
 ?>

<div class="container">

<?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'principal'): ?>
    <a href="add_student.php" class="btn btn-success mb-3">
        Add Student
    </a>
<?php endif; ?>

<?php
$result = $conn->query("SELECT * FROM students");

while ($row = $result->fetch_assoc()) {
?>

    <div class="card shadow-sm mb-3 border-0">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <h3 class="fw-bold mb-2">
                        <?php echo $row['fname']; ?> <?php echo $row['lname']; ?>
                    </h3>

                    <p class="mb-1"><strong>Student ID:</strong> <?php echo $row['student_id']; ?></p>
                    <p class="mb-0"><strong>Gender:</strong> <?php echo $row['gender']; ?></p>
                </div>

                <div>
                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'principal'): ?>
                        <a href="edit_student.php?id=<?php echo $row['id']; ?>"
                           class="btn btn-outline-primary btn-sm">
                            Edit
                        </a>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <a href="actions/delete_student.php?id=<?php echo $row['id']; ?>"
                           class="btn btn-outline-danger btn-sm"
                           onclick="return confirm('Delete this student?')">
                            Delete
                        </a>
                    <?php endif; ?>
                </div>

            </div>

        </div>
    </div>

<?php } ?>

</div>

<?php include "includes/footer.php"; ?>