<?php
require_once __DIR__ . "/flash.php";

$activeSection = $activeSection ?? "";
$flash = flash_get();

function nav_class($section, $active) {
    return "nav-link" . ($section === $active ? " active" : "");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseHub</title>
    <link rel="stylesheet" href="/coursehub/css/style.css">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark">CH</span>
            CourseHub
        </div>

        <nav class="sidebar-nav">
            <a class="<?= nav_class("home", $activeSection) ?>" href="/coursehub/">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" /></svg>
                <span>Home</span>
            </a>
            <a class="<?= nav_class("students", $activeSection) ?>" href="/coursehub/students/">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                <span>Students</span>
            </a>
            <a class="<?= nav_class("courses", $activeSection) ?>" href="/coursehub/courses/">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                <span>Courses</span>
            </a>
            <a class="<?= nav_class("enrollments", $activeSection) ?>" href="/coursehub/enrollments/">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" /></svg>
                <span>Enrollments</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <?php if (isset($_SESSION["user_id"])): ?>
                <div class="user-chip">
                    <span class="avatar"><?= strtoupper(substr($_SESSION["username"], 0, 1)) ?></span>
                    <div class="user-meta">
                        <div class="user-name"><?= htmlspecialchars($_SESSION["username"]) ?></div>
                        <a class="logout-link" href="/coursehub/logout.php">Log out</a>
                    </div>
                </div>
            <?php else: ?>
                <a class="nav-link" href="/coursehub/login.php">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3" /></svg>
                    <span>Login</span>
                </a>
            <?php endif; ?>
        </div>
    </aside>

    <div class="main">
        <div class="container">
            <?php if ($flash): ?>
                <div class="alert alert-<?= htmlspecialchars($flash["type"]) ?>">
                    <?php if ($flash["type"] === "success"): ?>
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <?php else: ?>
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                    <?php endif; ?>
                    <span><?= htmlspecialchars($flash["message"]) ?></span>
                </div>
            <?php endif; ?>
