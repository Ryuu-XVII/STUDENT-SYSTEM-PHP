<?php
session_start();
require "config/database.php";

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare(
        "SELECT id, username, password_hash
         FROM users
         WHERE username = ?"
    );
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user["password_hash"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: index.php");
        exit;
    }

    $error = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — CourseHub</title>
    <link rel="stylesheet" href="/coursehub/css/style.css">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="brand">
            <span class="brand-mark">CH</span>
            CourseHub
        </div>
        <h1>Welcome back</h1>
        <p class="subtitle">Sign in to manage students and courses.</p>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="field">
                <label>Username</label>
                <input name="username" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>" required autofocus>
            </div>
            <div class="field">
                <label>Password</label>
                <input name="password" type="password" required>
            </div>
            <button type="submit">Sign in</button>
        </form>

        <p class="auth-hint">Default admin: admin / ChangeMe123!</p>
    </div>
</div>
</body>
</html>
