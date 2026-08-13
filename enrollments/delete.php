<?php
require "../includes/auth.php";
require "../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid enrollment.");
}

$stmt = $conn->prepare(
    "SELECT s.full_name, c.course_name
     FROM enrollments e
     JOIN students s ON s.id = e.student_id
     JOIN courses c ON c.id = e.course_id
     WHERE e.id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$enrollment = $stmt->get_result()->fetch_assoc();

if (!$enrollment) {
    die("Enrollment not found.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("DELETE FROM enrollments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    flash_set("success", "Removed {$enrollment["full_name"]} from {$enrollment["course_name"]}.");
    header("Location: index.php");
    exit;
}

$activeSection = "enrollments";
require "../views/enrollments/delete.php";
