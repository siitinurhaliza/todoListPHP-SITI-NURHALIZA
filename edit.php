<?php
// edit.php
session_start();

// Memastikan ada daftar tugas
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Mendapatkan ID tugas dari parameter URL
if (!isset($_GET['id']) || !isset($_SESSION['tasks'][$_GET['id']])) {
    $_SESSION['alert'] = 'Task not found.';
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];
$task = $_SESSION['tasks'][$id];

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
            // Memperbarui tugas di session
            $_SESSION['tasks'][$id] = [
                'name' => $taskName,
                'priority' => $priority,
                'deadline' => date('Y-m-d H:i:s', $deadlineTimestamp),
                'completed' => $task['completed'] // Mempertahankan status selesai
            ];

            // Mengatur pesan alert dan redirect ke index
            $_SESSION['alert'] = 'Task successfully updated!';
            header('Location: index.php');
            exit();
        }
    } else {
        $error = 'Silakan isi semua field.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Task</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/styles.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Update Task</h1>

    <!-- Menampilkan Error jika ada -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- Form Edit Task -->
    <form method="POST" action="edit.php?id=<?php echo htmlspecialchars($id); ?>">
        <div class="mb-3">
            <label for="task_name" class="form-label">Name Task</label>
            <input type="text" class="form-control" id="task_name" name="task_name" value="<?php echo htmlspecialchars($task['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select class="form-select" id="priority" name="priority" required>
                <option value="">-- Select Priority --</option>
                <option value="High" <?php if ($task['priority'] === 'High') echo 'selected'; ?>>High</option>
                <option value="Medium" <?php if ($task['priority'] === 'Medium') echo 'selected'; ?>>Medium</option>
                <option value="Low" <?php if ($task['priority'] === 'Low') echo 'selected'; ?>>Low</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="datetime-local" class="form-control" id="deadline" name="deadline" value="<?php echo date('Y-m-d\TH:i', strtotime($task['deadline'])); ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
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
