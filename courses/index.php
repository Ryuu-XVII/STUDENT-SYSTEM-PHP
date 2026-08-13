<?php
require "../includes/auth.php";
require "../config/database.php";

$result = $conn->query(
    "SELECT id, course_name, description, duration_weeks
     FROM courses
     ORDER BY course_name"
);

$activeSection = "courses";
require "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1>Courses</h1>
        <p>Manage the courses offered by CourseHub.</p>
    </div>
    <div class="header-actions">
        <a class="button" href="create.php">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Add Course
        </a>
    </div>
</div>

<div class="surface">
    <?php if ($result->num_rows === 0): ?>
        <div class="empty-state">
            <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
            <h3>No courses yet</h3>
            <p>Add your first course to get started.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($course = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <div class="cell-primary">
                                <span class="avatar-sm"><?= htmlspecialchars(strtoupper(substr($course["course_name"], 0, 1))) ?></span>
                                <?= htmlspecialchars($course["course_name"]) ?>
                            </div>
                        </td>
                        <td class="cell-sub"><?= htmlspecialchars($course["description"] ?? "—") ?></td>
                        <td><span class="badge"><?= (int) $course["duration_weeks"] ?> weeks</span></td>
                        <td>
                            <div class="actions">
                                <a href="edit.php?id=<?= (int) $course["id"] ?>">Edit</a>
                                <a class="link-danger" href="delete.php?id=<?= (int) $course["id"] ?>">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require "../includes/footer.php"; ?>
