<?php
require "../includes/auth.php";
require "../config/database.php";

$search = trim($_GET["q"] ?? "");

if ($search !== "") {
    $stmt = $conn->prepare(
        "SELECT id, full_name, email, phone, created_at
         FROM students
         WHERE full_name LIKE ? OR email LIKE ?
         ORDER BY id DESC"
    );
    $term = "%" . $search . "%";
    $stmt->bind_param("ss", $term, $term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query(
        "SELECT id, full_name, email, phone, created_at
         FROM students
         ORDER BY id DESC"
    );
}

$activeSection = "students";
require "../views/students/index.php";
