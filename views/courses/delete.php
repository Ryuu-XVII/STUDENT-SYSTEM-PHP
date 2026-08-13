<?php require __DIR__ . "/../layout/header.php"; ?>

<div class="page-header">
    <div>
        <h1>Delete Course</h1>
        <p>This action cannot be undone.</p>
    </div>
</div>

<div class="form-card">
    <div class="alert alert-error" style="margin-bottom:24px;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
        <span>Are you sure you want to delete <strong><?= htmlspecialchars($course["course_name"]) ?></strong>? This will also remove related enrollments.</span>
    </div>
    <form method="post">
        <div class="form-actions">
            <button type="submit" class="button danger">Yes, Delete</button>
            <a class="button secondary" href="index.php">Cancel</a>
        </div>
    </form>
</div>

<?php require __DIR__ . "/../layout/footer.php"; ?>
