<?php
require "../includes/auth.php";
require "../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentId = filter_input(INPUT_POST, "student_id", FILTER_VALIDATE_INT);
    $courseId = filter_input(INPUT_POST, "course_id", FILTER_VALIDATE_INT);

    if (!$studentId || !$courseId) {
        $error = "Select a student and a course.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO enrollments (student_id, course_id)
             VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $studentId, $courseId);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        }

        $error = ($conn->errno === 1062)
            ? "This student is already enrolled in that course."
            : "Could not save the enrollment.";
    }
}

$students = $conn->query("SELECT id, full_name FROM students ORDER BY full_name");
$courses = $conn->query("SELECT id, course_name FROM courses ORDER BY course_name");

require "../includes/header.php";
?>

<h1>Add Enrollment</h1>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <label>Student</label>
    <select name="student_id" required>
        <option value="">Select a student</option>
        <?php while ($student = $students->fetch_assoc()): ?>
            <option value="<?= (int) $student["id"] ?>"><?= htmlspecialchars($student["full_name"]) ?></option>
        <?php endwhile; ?>
    </select>

    <label>Course</label>
    <select name="course_id" required>
        <option value="">Select a course</option>
        <?php while ($course = $courses->fetch_assoc()): ?>
            <option value="<?= (int) $course["id"] ?>"><?= htmlspecialchars($course["course_name"]) ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Save Enrollment</button>
</form>

<?php require "../includes/footer.php"; ?>
