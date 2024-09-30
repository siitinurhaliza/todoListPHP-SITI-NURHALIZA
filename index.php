<?php
// index.php
session_start();

// Inisialisasi daftar tugas jika belum ada
if (!isset($_SESSION['tasks']) || !is_array($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Mengambil pesan alert jika ada
$alert = '';
if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    unset($_SESSION['alert']);
}

// Fungsi untuk mengecek apakah tugas sudah melewati deadline
function isOverdue($deadline) {
    return strtotime($deadline) < time();
}

// Memisahkan tugas menjadi aktif dan selesai
$active_tasks = [];
$completed_tasks = [];

foreach ($_SESSION['tasks'] as $index => $task) {
    if (isset($task['completed']) && $task['completed']) {
        $completed_tasks[$index] = $task;
    } else {
        $active_tasks[$index] = $task;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/styles.css" rel="stylesheet">
</head>

<div class="container mt-5">
    <h1 class="mb-4">Task Management Application</h1>

    <!-- Menampilkan Alert jika ada -->
    <?php if (!empty($alert)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($alert); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Tombol Tambah Task -->
    <a href="add.php" class="btn btn-primary mb-3">Add Task</a>

    <!-- Menampilkan Daftar Tugas Aktif -->
    <h2>Active Tasks.</h2>
    <?php if (count($active_tasks) > 0): ?>
        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Task</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($active_tasks as $index => $task): ?>
                        <?php
                            $overdue = isOverdue($task['deadline']);
                            $rowClass = $overdue ? 'overdue' : '';
                            if ($overdue) {
                                $status = '<span class="badge bg-danger">Overdue</span>';
                            } else {
                                $status = '<span class="badge bg-warning text-dark">On Time</span>';
                            }
                        ?>
                        <tr class="<?php echo $rowClass; ?>">
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($task['name']); ?></td>
                            <td><?php echo htmlspecialchars($task['priority']); ?></td>
                            <td><?php echo htmlspecialchars(date('d M Y H:i', strtotime($task['deadline']))); ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $index; ?>" class="btn btn-sm btn-warning">Update</a>
                                <a href="delete.php?id=<?php echo $index; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus task ini?');">Delete</a>
                                <a href="complete.php?id=<?php echo $index; ?>" class="btn btn-sm btn-success">Completed</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>There are no active tasks. Click 'Add Task' to get started.</p>
    <?php endif; ?>

    <!-- Menampilkan Daftar Tugas Selesai -->
    <h2 class="mt-5">Completed Tasks.</h2>
    <?php if (count($completed_tasks) > 0): ?>
        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Task</th>
                        <th>Prioritas</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($completed_tasks as $index => $task): ?>
                        <?php
                            $status = '<span class="badge bg-success">Selesai</span>';
                        ?>
                        <tr class="completed">
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($task['name']); ?></td>
                            <td><?php echo htmlspecialchars($task['priority']); ?></td>
                            <td><?php echo htmlspecialchars(date('d M Y H:i', strtotime($task['deadline']))); ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <a href="delete.php?id=<?php echo $index; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus task ini?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Opsi Menghapus Semua Tugas Selesai -->
        <a href="delete_all_completed.php" class="btn btn-danger mb-3" onclick="return confirm('Apakah Anda yakin ingin menghapus semua tugas selesai?');">
        Delete All Completed Tasks
        </a>
    <?php else: ?>
        <p>There are no completed tasks.</p>
    <?php endif; ?>
</div>

    <!-- Footer -->
    <footer class="mt-5">
    <p>&copy; <?php echo date('Y'); ?> Task Management by <a href="https://github.com/siitinurhaliza" target="_blank"> SITI NURHALIZA</a>. All rights reserved.</p>
</footer>




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/scripts.js"></script>

</body>
</html>
