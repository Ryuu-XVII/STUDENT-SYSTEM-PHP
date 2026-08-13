<?php
require "../includes/auth.php";
require "../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid student.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

require "../includes/header.php";
?>

<h1>Delete Student</h1>
<p>Are you sure you want to delete this student? This will also remove their enrollments.</p>

<form method="post">
    <button type="submit">Yes, Delete</button>
    <a class="button" href="index.php">Cancel</a>
</form>

<?php require "../includes/footer.php"; ?>
