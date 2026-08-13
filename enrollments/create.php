<?php
require "../includes/auth.php";
require "../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentId = filter_input(INPUT_POST, "student_id", FILTER_VALIDATE_INT);
    $courseId = filter_input(INPUT_POST, "course_id", FILTER_VALIDATE_INT);

    if (!$studentId || !$courseId) {
        $error = "Select a student and a course.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO enrollments (student_id, course_id)
             VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $studentId, $courseId);

        if ($stmt->execute()) {
            flash_set("success", "Enrollment saved.");
            header("Location: index.php");
            exit;
        }

        $error = ($conn->errno === 1062)
            ? "This student is already enrolled in that course."
            : "Could not save the enrollment.";
    }
}

$students = $conn->query("SELECT id, full_name FROM students ORDER BY full_name");
$courses = $conn->query("SELECT id, course_name FROM courses ORDER BY course_name");

$activeSection = "enrollments";
require "../views/enrollments/create.php";
