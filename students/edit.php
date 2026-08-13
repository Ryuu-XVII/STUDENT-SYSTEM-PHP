<?php
require "../includes/auth.php";
require "../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid student.");
}

$stmt = $conn->prepare(
    "SELECT id, full_name, email, phone
     FROM students
     WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    die("Student not found.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");

    if ($fullName === "" || $email === "") {
        $error = "Name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Enter a valid email address.";
    } else {
        $stmt = $conn->prepare(
            "UPDATE students
             SET full_name = ?, email = ?, phone = ?
             WHERE id = ?"
        );
        $stmt->bind_param("sssi", $fullName, $email, $phone, $id);

        if ($stmt->execute()) {
            flash_set("success", "Student \"$fullName\" was updated.");
            header("Location: index.php");
            exit;
        }

        $error = ($conn->errno === 1062)
            ? "A student with that email already exists."
            : "Could not update the student.";
    }

    $student = ["full_name" => $fullName, "email" => $email, "phone" => $phone];
}

$activeSection = "students";
require "../views/students/edit.php";
