<?php
require "../includes/auth.php";
require "../config/database.php";

$result = $conn->query(
    "SELECT e.id, s.full_name, c.course_name, e.enrolled_at
     FROM enrollments e
     JOIN students s ON s.id = e.student_id
     JOIN courses c ON c.id = e.course_id
     ORDER BY e.enrolled_at DESC"
);

$activeSection = "enrollments";
require "../views/enrollments/index.php";
