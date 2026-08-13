<?php
require "../includes/auth.php";
require "../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid enrollment.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("DELETE FROM enrollments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

require "../includes/header.php";
?>

<h1>Remove Enrollment</h1>
<p>Are you sure you want to remove this enrollment?</p>

<form method="post">
    <button type="submit">Yes, Remove</button>
    <a class="button" href="index.php">Cancel</a>
</form>

<?php require "../includes/footer.php"; ?>
