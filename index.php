<?php
require "config/database.php";

$studentCount = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()["total"];
$courseCount = $conn->query("SELECT COUNT(*) AS total FROM courses")->fetch_assoc()["total"];
$enrollmentCount = $conn->query("SELECT COUNT(*) AS total FROM enrollments")->fetch_assoc()["total"];

require "includes/header.php";
?>

<h1>Welcome to CourseHub</h1>
<p>Student &amp; Course Management System.</p>

<div class="cards">
    <div class="card">
        <h2><?= (int) $studentCount ?></h2>
        <p>Students</p>
        <a href="/coursehub/students/">View Students</a>
    </div>
    <div class="card">
        <h2><?= (int) $courseCount ?></h2>
        <p>Courses</p>
        <a href="/coursehub/courses/">View Courses</a>
    </div>
    <div class="card">
        <h2><?= (int) $enrollmentCount ?></h2>
        <p>Enrollments</p>
        <a href="/coursehub/enrollments/">View Enrollments</a>
    </div>
</div>

<?php require "includes/footer.php"; ?>
