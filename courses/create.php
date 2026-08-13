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
        header("Location: index.php");
        exit;
    }
}

require "../includes/header.php";
?>

<h1>Add Course</h1>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <label>Course Name</label>
    <input name="course_name" value="<?= htmlspecialchars($_POST["course_name"] ?? "") ?>" required>

    <label>Description</label>
    <textarea name="description" rows="4"><?= htmlspecialchars($_POST["description"] ?? "") ?></textarea>

    <label>Duration (weeks)</label>
    <input name="duration_weeks" type="number" min="1" value="<?= htmlspecialchars($_POST["duration_weeks"] ?? "") ?>" required>

    <button type="submit">Save Course</button>
</form>

<?php require "../includes/footer.php"; ?>
