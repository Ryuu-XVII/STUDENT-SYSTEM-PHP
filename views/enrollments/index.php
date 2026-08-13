<?php require __DIR__ . "/../layout/header.php"; ?>

<div class="page-header">
    <div>
        <h1>Enrollments</h1>
        <p>Link students to the courses they're taking.</p>
    </div>
    <div class="header-actions">
        <a class="button" href="create.php">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Add Enrollment
        </a>
    </div>
</div>

<div class="surface">
    <?php if ($result->num_rows === 0): ?>
        <div class="empty-state">
            <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" /></svg>
            <h3>No enrollments yet</h3>
            <p>Link a student to a course to get started.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Enrolled</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($enrollment = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <div class="cell-primary">
                                <span class="avatar-sm"><?= htmlspecialchars(strtoupper(substr($enrollment["full_name"], 0, 1))) ?></span>
                                <?= htmlspecialchars($enrollment["full_name"]) ?>
                            </div>
                        </td>
                        <td><span class="badge"><?= htmlspecialchars($enrollment["course_name"]) ?></span></td>
                        <td class="cell-sub"><?= htmlspecialchars($enrollment["enrolled_at"]) ?></td>
                        <td>
                            <div class="actions">
                                <a class="link-danger" href="delete.php?id=<?= (int) $enrollment["id"] ?>">Remove</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . "/../layout/footer.php"; ?>
