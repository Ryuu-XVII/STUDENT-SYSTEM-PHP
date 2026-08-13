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
            flash_set("success", "Enrollment saved.");
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

$activeSection = "enrollments";
require "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1>Add Enrollment</h1>
        <p>Link a student to a course.</p>
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

<?php if ($students->num_rows === 0 || $courses->num_rows === 0): ?>
    <div class="surface">
        <div class="empty-state">
            <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
            <h3>Add students and courses first</h3>
            <p>You need at least one student and one course before creating an enrollment.</p>
        </div>
    </div>
<?php else: ?>
    <div class="form-card">
        <form method="post">
            <div class="field">
                <label>Student</label>
                <select name="student_id" required>
                    <option value="">Select a student</option>
                    <?php while ($student = $students->fetch_assoc()): ?>
                        <option value="<?= (int) $student["id"] ?>"><?= htmlspecialchars($student["full_name"]) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="field">
                <label>Course</label>
                <select name="course_id" required>
                    <option value="">Select a course</option>
                    <?php while ($course = $courses->fetch_assoc()): ?>
                        <option value="<?= (int) $course["id"] ?>"><?= htmlspecialchars($course["course_name"]) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit">Save Enrollment</button>
                <a class="button secondary" href="index.php">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php require "../includes/footer.php"; ?>
