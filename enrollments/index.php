<?php
require "../includes/auth.php";
require "../config/database.php";

$result = $conn->query(
    "SELECT e.id, s.full_name, c.course_name, e.enrolled_at
     FROM enrollments e
     JOIN students s ON s.id = e.student_id
     JOIN courses c ON c.id = e.course_id
     ORDER BY e.enrolled_at DESC"
);

require "../includes/header.php";
?>

<h1>Enrollments</h1>
<a class="button" href="create.php">Add Enrollment</a>

<table>
    <thead>
        <tr>
            <th>Student</th>
            <th>Course</th>
            <th>Enrolled At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($enrollment = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($enrollment["full_name"]) ?></td>
                <td><?= htmlspecialchars($enrollment["course_name"]) ?></td>
                <td><?= htmlspecialchars($enrollment["enrolled_at"]) ?></td>
                <td class="actions">
                    <a href="delete.php?id=<?= (int) $enrollment["id"] ?>">Remove</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require "../includes/footer.php"; ?>
