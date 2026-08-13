<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseHub</title>
    <link rel="stylesheet" href="/coursehub/css/style.css">
</head>
<body>
<nav>
    <a href="/coursehub/">Home</a>
    <a href="/coursehub/students/">Students</a>
    <a href="/coursehub/courses/">Courses</a>
    <a href="/coursehub/enrollments/">Enrollments</a>
    <?php if (isset($_SESSION["user_id"])): ?>
        <a href="/coursehub/logout.php">Logout (<?= htmlspecialchars($_SESSION["username"]) ?>)</a>
    <?php else: ?>
        <a href="/coursehub/login.php">Login</a>
    <?php endif; ?>
</nav>
<div class="container">
