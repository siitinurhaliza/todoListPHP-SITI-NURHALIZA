<?php
// delete_all_completed.php
session_start();

// Memastikan ada daftar tugas
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Inisialisasi array baru untuk menyimpan tugas aktif
$new_tasks = [];

// Iterasi melalui semua tugas dan hanya menyimpan yang belum selesai
foreach ($_SESSION['tasks'] as $index => $task) {
    if (!(isset($task['completed']) && $task['completed'])) {
        $new_tasks[] = $task;
    }
}

// Memperbarui sesi dengan tugas yang masih aktif
$_SESSION['tasks'] = $new_tasks;

// Mengatur pesan alert dan redirect ke index
$_SESSION['alert'] = 'Semua tugas selesai telah dihapus!';
header('Location: index.php');
exit();
?>
