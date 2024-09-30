<?php
// add.php
session_start();

// Menangani form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskName = trim($_POST['task_name']);
    $priority = trim($_POST['priority']);
    $deadline = trim($_POST['deadline']);

    // Validasi input
    if ($taskName !== '' && $priority !== '' && $deadline !== '') {
        // Validasi format tanggal
        $deadlineTimestamp = strtotime($deadline);
        if ($deadlineTimestamp === false) {
            $error = 'Invalid deadline format.';
        } else {
            // Menambahkan tugas ke session
            $_SESSION['tasks'][] = [
                'name' => $taskName,
                'priority' => $priority,
                'deadline' => date('Y-m-d H:i:s', $deadlineTimestamp),
                'completed' => false
            ];

            // Mengatur pesan alert dan redirect ke index
            $_SESSION['alert'] = 'Task successfully added!';
            header('Location: index.php');
            exit();
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Task</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/styles.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Tambah Task</h1>

    <!-- Menampilkan Error jika ada -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- Form Tambah Task -->
    <form method="POST" action="add.php">
        <div class="mb-3">
            <label for="task_name" class="form-label">Name Task</label>
            <input type="text" class="form-control" id="task_name" name="task_name" required>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select class="form-select" id="priority" name="priority" required>
                <option value="">-- Select Priority --</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
        </div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>
<footer>
    <p>&copy; <?= date('Y') ?> Task Management by SITI NURHALIZA. All rights reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/scripts.js"></script>

</body>
</html>
