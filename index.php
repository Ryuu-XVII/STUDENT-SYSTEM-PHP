<?php
require "config/database.php";

$studentCount = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()["total"];
$courseCount = $conn->query("SELECT COUNT(*) AS total FROM courses")->fetch_assoc()["total"];
$enrollmentCount = $conn->query("SELECT COUNT(*) AS total FROM enrollments")->fetch_assoc()["total"];

$recentStudents = $conn->query(
    "SELECT full_name, email, created_at
     FROM students
     ORDER BY id DESC
     LIMIT 5"
);

$activeSection = "home";
require "views/home.php";
