<?php
require "../includes/auth.php";
require "../config/database.php";

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
            "INSERT INTO students (full_name, email, phone)
             VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $fullName, $email, $phone);

        if ($stmt->execute()) {
            flash_set("success", "Student \"$fullName\" was added.");
            header("Location: index.php");
            exit;
        }

        $error = ($conn->errno === 1062)
            ? "A student with that email already exists."
            : "Could not save the student.";
    }
}

$activeSection = "students";
require "../views/students/create.php";
