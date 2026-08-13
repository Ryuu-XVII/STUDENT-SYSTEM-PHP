<?php
require "../includes/auth.php";
require "../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");

    if ($fullName === "" || $email === "") {
        $error = "Name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Enter a valid email address.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO students (full_name, email, phone)
             VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $fullName, $email, $phone);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        }

        $error = ($conn->errno === 1062)
            ? "A student with that email already exists."
            : "Could not save the student.";
    }
}

require "../includes/header.php";
?>

<h1>Add Student</h1>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <label>Full Name</label>
    <input name="full_name" value="<?= htmlspecialchars($_POST["full_name"] ?? "") ?>" required>

    <label>Email</label>
    <input name="email" type="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>

    <label>Phone</label>
    <input name="phone" value="<?= htmlspecialchars($_POST["phone"] ?? "") ?>">

    <button type="submit">Save Student</button>
</form>

<?php require "../includes/footer.php"; ?>
