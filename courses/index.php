<?php
require "../includes/auth.php";
require "../config/database.php";

$result = $conn->query(
    "SELECT id, course_name, description, duration_weeks
     FROM courses
     ORDER BY course_name"
);

require "../includes/header.php";
?>

<h1>Courses</h1>
<a class="button" href="create.php">Add Course</a>

<table>
    <thead>
        <tr>
            <th>Course</th>
            <th>Description</th>
            <th>Duration (weeks)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($course = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($course["course_name"]) ?></td>
                <td><?= htmlspecialchars($course["description"] ?? "") ?></td>
                <td><?= (int) $course["duration_weeks"] ?></td>
                <td class="actions">
                    <a href="edit.php?id=<?= (int) $course["id"] ?>">Edit</a>
                    <a href="delete.php?id=<?= (int) $course["id"] ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require "../includes/footer.php"; ?>
