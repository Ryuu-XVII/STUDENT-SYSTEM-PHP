<?php require __DIR__ . "/../layout/header.php"; ?>

<div class="page-header">
    <div>
        <h1>Add Course</h1>
        <p>Create a new course offering.</p>
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
            <input name="course_name" value="<?= htmlspecialchars($_POST["course_name"] ?? "") ?>" required>
        </div>
        <div class="field">
            <label>Description</label>
            <textarea name="description" rows="4"><?= htmlspecialchars($_POST["description"] ?? "") ?></textarea>
        </div>
        <div class="field">
            <label>Duration (weeks)</label>
            <input name="duration_weeks" type="number" min="1" value="<?= htmlspecialchars($_POST["duration_weeks"] ?? "") ?>" required>
        </div>
        <div class="form-actions">
            <button type="submit">Save Course</button>
            <a class="button secondary" href="index.php">Cancel</a>
        </div>
    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php"; ?>
