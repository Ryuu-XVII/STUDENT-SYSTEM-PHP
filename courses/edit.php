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
require "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1>Edit Course</h1>
        <p>Update this course's details.</p>
    </div>
    <div class="header-actions">
        <a class="button secondary" href="index.php">Cancel</a>
    </div>
</div>

<?php if ($error): ?>
    <div class="alert alert-error">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="post">
        <div class="field">
            <label>Course Name</label>
            <input name="course_name" value="<?= htmlspecialchars($course["course_name"]) ?>" required>
        </div>
        <div class="field">
            <label>Description</label>
            <textarea name="description" rows="4"><?= htmlspecialchars($course["description"] ?? "") ?></textarea>
        </div>
        <div class="field">
            <label>Duration (weeks)</label>
            <input name="duration_weeks" type="number" min="1" value="<?= htmlspecialchars((string) $course["duration_weeks"]) ?>" required>
        </div>
        <div class="form-actions">
            <button type="submit">Update Course</button>
            <a class="button secondary" href="index.php">Cancel</a>
        </div>
    </form>
</div>

<?php require "../includes/footer.php"; ?>
