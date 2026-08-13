<?php
require "../includes/auth.php";
require "../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid student.");
}

$stmt = $conn->prepare(
    "SELECT id, full_name, email, phone
     FROM students
     WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    die("Student not found.");
}

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
            "UPDATE students
             SET full_name = ?, email = ?, phone = ?
             WHERE id = ?"
        );
        $stmt->bind_param("sssi", $fullName, $email, $phone, $id);

        if ($stmt->execute()) {
            flash_set("success", "Student \"$fullName\" was updated.");
            header("Location: index.php");
            exit;
        }

        $error = ($conn->errno === 1062)
            ? "A student with that email already exists."
            : "Could not update the student.";
    }

    $student = ["full_name" => $fullName, "email" => $email, "phone" => $phone];
}

$activeSection = "students";
require "../includes/header.php";
?>

<div class="page-header">
    <div>
        <h1>Edit Student</h1>
        <p>Update this student's details.</p>
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
            <input name="full_name" value="<?= htmlspecialchars($student["full_name"]) ?>" required>
        </div>
        <div class="field">
            <label>Email</label>
            <input name="email" type="email" value="<?= htmlspecialchars($student["email"]) ?>" required>
        </div>
        <div class="field">
            <label>Phone</label>
            <input name="phone" value="<?= htmlspecialchars($student["phone"] ?? "") ?>">
        </div>
        <div class="form-actions">
            <button type="submit">Update Student</button>
            <a class="button secondary" href="index.php">Cancel</a>
        </div>
    </form>
</div>

<?php require "../includes/footer.php"; ?>
