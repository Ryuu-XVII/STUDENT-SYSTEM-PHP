<?php
require "config/database.php";

$studentCount = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()["total"];
$courseCount = $conn->query("SELECT COUNT(*) AS total FROM courses")->fetch_assoc()["total"];
$enrollmentCount = $conn->query("SELECT COUNT(*) AS total FROM enrollments")->fetch_assoc()["total"];

$recentStudents = $conn->query(
    "SELECT full_name, email, created_at
     FROM students
     ORDER BY id DESC
     LIMIT 5"
);

$activeSection = "home";
require "includes/header.php";
?>

<div class="page-header">
    <div>
        <h1>Welcome back</h1>
        <p>Here's what's happening in CourseHub today.</p>
    </div>
</div>

<div class="stat-grid">
    <a class="stat-card" href="/coursehub/students/">
        <span class="stat-icon tone-indigo">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
        </span>
        <span class="stat-value"><?= (int) $studentCount ?></span>
        <span class="stat-label">Students</span>
    </a>
    <a class="stat-card" href="/coursehub/courses/">
        <span class="stat-icon tone-green">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
        </span>
        <span class="stat-value"><?= (int) $courseCount ?></span>
        <span class="stat-label">Courses</span>
    </a>
    <a class="stat-card" href="/coursehub/enrollments/">
        <span class="stat-icon tone-amber">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" /></svg>
        </span>
        <span class="stat-value"><?= (int) $enrollmentCount ?></span>
        <span class="stat-label">Enrollments</span>
    </a>
</div>

<div class="page-header" style="margin-top:40px;">
    <div>
        <h1 style="font-size:1.2rem;">Recently added students</h1>
    </div>
    <div class="header-actions">
        <a class="button secondary" href="/coursehub/students/">View all</a>
    </div>
</div>

<div class="surface">
    <?php if ($recentStudents->num_rows === 0): ?>
        <div class="empty-state">
            <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
            <h3>No students yet</h3>
            <p>Add your first student to get started.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Added</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $recentStudents->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <div class="cell-primary">
                                <span class="avatar-sm"><?= htmlspecialchars(strtoupper(substr($student["full_name"], 0, 1))) ?></span>
                                <?= htmlspecialchars($student["full_name"]) ?>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($student["email"]) ?></td>
                        <td class="cell-sub"><?= htmlspecialchars($student["created_at"]) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require "includes/footer.php"; ?>
