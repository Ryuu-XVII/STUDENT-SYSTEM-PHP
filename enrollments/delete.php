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
require "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1>Remove Enrollment</h1>
        <p>This action cannot be undone.</p>
    </div>
</div>

<div class="form-card">
    <div class="alert alert-error" style="margin-bottom:24px;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
        <span>Remove <strong><?= htmlspecialchars($enrollment["full_name"]) ?></strong> from <strong><?= htmlspecialchars($enrollment["course_name"]) ?></strong>?</span>
    </div>
    <form method="post">
        <div class="form-actions">
            <button type="submit" class="button danger">Yes, Remove</button>
            <a class="button secondary" href="index.php">Cancel</a>
        </div>
    </form>
</div>

<?php require "../includes/footer.php"; ?>
