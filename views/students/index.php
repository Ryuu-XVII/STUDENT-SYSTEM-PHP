<?php require __DIR__ . "/../layout/header.php"; ?>

<div class="page-header">
    <div>
        <h1>Students</h1>
        <p>Manage the students enrolled in CourseHub.</p>
    </div>
    <div class="header-actions">
        <a class="button" href="create.php">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Add Student
        </a>
    </div>
</div>

<form method="get" class="search-form">
    <input name="q" placeholder="Search by name or email" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<div class="surface">
    <?php if ($result->num_rows === 0): ?>
        <div class="empty-state">
            <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
            <?php if ($search !== ""): ?>
                <h3>No matches found</h3>
                <p>No students match "<?= htmlspecialchars($search) ?>".</p>
            <?php else: ?>
                <h3>No students yet</h3>
                <p>Add your first student to get started.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <div class="cell-primary">
                                <span class="avatar-sm"><?= htmlspecialchars(strtoupper(substr($student["full_name"], 0, 1))) ?></span>
                                <?= htmlspecialchars($student["full_name"]) ?>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($student["email"]) ?></td>
                        <td><?= htmlspecialchars($student["phone"] ?? "—") ?></td>
                        <td>
                            <div class="actions">
                                <a href="edit.php?id=<?= (int) $student["id"] ?>">Edit</a>
                                <a class="link-danger" href="delete.php?id=<?= (int) $student["id"] ?>">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . "/../layout/footer.php"; ?>
