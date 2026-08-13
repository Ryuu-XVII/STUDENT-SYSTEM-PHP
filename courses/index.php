<?php
require "../includes/auth.php";
require "../config/database.php";

$result = $conn->query(
    "SELECT id, course_name, description, duration_weeks
     FROM courses
     ORDER BY course_name"
);

$activeSection = "courses";
require "../views/courses/index.php";
