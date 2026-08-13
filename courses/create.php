<?php
require "../includes/auth.php";
require "../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $courseName = trim($_POST["course_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $durationWeeks = filter_input(INPUT_POST, "duration_weeks", FILTER_VALIDATE_INT);

    if ($courseName === "" || !$durationWeeks || $durationWeeks < 1) {
        $error = "Course name and a valid duration are required.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO courses (course_name, description, duration_weeks)
             VALUES (?, ?, ?)"
        );
        $stmt->bind_param("ssi", $courseName, $description, $durationWeeks);
        $stmt->execute();
        flash_set("success", "Course \"$courseName\" was added.");
        header("Location: index.php");
        exit;
    }
}

$activeSection = "courses";
require "../views/courses/create.php";
