<?php
// One-time script to create the first admin user.
// Run it once (php setup/create_admin.php, or visit it in the browser),
// then delete this file so it cannot be used again.

require "../config/database.php";

$username = "admin";
$password = "ChangeMe123!";

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

if ($stmt->get_result()->fetch_assoc()) {
    die("User '$username' already exists.");
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hash);
$stmt->execute();

echo "Admin user created. Username: $username / Password: $password\n";
echo "Log in, then delete setup/create_admin.php.\n";
