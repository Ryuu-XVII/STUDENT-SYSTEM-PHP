<?php
require "../includes/auth.php";
require "../config/database.php";

$search = trim($_GET["q"] ?? "");

if ($search !== "") {
    $stmt = $conn->prepare(
        "SELECT id, full_name, email, phone, created_at
         FROM students
         WHERE full_name LIKE ? OR email LIKE ?
         ORDER BY id DESC"
    );
    $term = "%" . $search . "%";
    $stmt->bind_param("ss", $term, $term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query(
        "SELECT id, full_name, email, phone, created_at
         FROM students
         ORDER BY id DESC"
    );
}

require "../includes/header.php";
?>

<h1>Students</h1>
<a class="button" href="create.php">Add Student</a>

<form method="get" style="margin-top:20px;">
    <input name="q" placeholder="Search by name or email" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

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
                <td><?= htmlspecialchars($student["full_name"]) ?></td>
                <td><?= htmlspecialchars($student["email"]) ?></td>
                <td><?= htmlspecialchars($student["phone"] ?? "") ?></td>
                <td class="actions">
                    <a href="edit.php?id=<?= (int) $student["id"] ?>">Edit</a>
                    <a href="delete.php?id=<?= (int) $student["id"] ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require "../includes/footer.php"; ?>
