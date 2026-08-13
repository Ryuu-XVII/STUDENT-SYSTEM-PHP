<?php
require "../includes/auth.php";
require "../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid course.");
}

$stmt = $conn->prepare(
    "SELECT id, course_name, description, duration_weeks
     FROM courses
     WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$course = $stmt->get_result()->fetch_assoc();

if (!$course) {
    die("Course not found.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $courseName = trim($_POST["course_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $durationWeeks = filter_input(INPUT_POST, "duration_weeks", FILTER_VALIDATE_INT);

    if ($courseName === "" || !$durationWeeks || $durationWeeks < 1) {
        $error = "Course name and a valid duration are required.";
        $course = [
            "course_name" => $courseName,
            "description" => $description,
            "duration_weeks" => $durationWeeks,
        ];
    } else {
        $stmt = $conn->prepare(
            "UPDATE courses
             SET course_name = ?, description = ?, duration_weeks = ?
             WHERE id = ?"
        );
        $stmt->bind_param("ssii", $courseName, $description, $durationWeeks, $id);
        $stmt->execute();
        flash_set("success", "Course \"$courseName\" was updated.");
        header("Location: index.php");
        exit;
    }
}

$activeSection = "courses";
require "../views/courses/edit.php";
