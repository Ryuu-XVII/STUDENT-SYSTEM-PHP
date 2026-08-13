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
            flash_set("success", "Student \"$fullName\" was added.");
            header("Location: index.php");
            exit;
        }

        $error = ($conn->errno === 1062)
            ? "A student with that email already exists."
            : "Could not save the student.";
    }
}

$activeSection = "students";
require "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1>Add Student</h1>
        <p>Create a new student record.</p>
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
            <label>Full Name</label>
            <input name="full_name" value="<?= htmlspecialchars($_POST["full_name"] ?? "") ?>" required>
        </div>
        <div class="field">
            <label>Email</label>
            <input name="email" type="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
        </div>
        <div class="field">
            <label>Phone</label>
            <input name="phone" value="<?= htmlspecialchars($_POST["phone"] ?? "") ?>">
            <p class="field-hint">Optional.</p>
        </div>
        <div class="form-actions">
            <button type="submit">Save Student</button>
            <a class="button secondary" href="index.php">Cancel</a>
        </div>
    </form>
</div>

<?php require "../includes/footer.php"; ?>
