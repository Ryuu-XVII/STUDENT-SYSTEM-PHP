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
        header("Location: index.php");
        exit;
    }
}

require "../includes/header.php";
?>

<h1>Edit Course</h1>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <label>Course Name</label>
    <input name="course_name" value="<?= htmlspecialchars($course["course_name"]) ?>" required>

    <label>Description</label>
    <textarea name="description" rows="4"><?= htmlspecialchars($course["description"] ?? "") ?></textarea>

    <label>Duration (weeks)</label>
    <input name="duration_weeks" type="number" min="1" value="<?= htmlspecialchars((string) $course["duration_weeks"]) ?>" required>

    <button type="submit">Update Course</button>
</form>

<?php require "../includes/footer.php"; ?>
