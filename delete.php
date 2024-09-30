<?php
// delete.php
session_start();

// Memastikan ada daftar tugas
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Mendapatkan ID tugas dari parameter URL
if (isset($_GET['id']) && isset($_SESSION['tasks'][$_GET['id']])) {
    unset($_SESSION['tasks'][$_GET['id']]);
    // Reindex array untuk menjaga konsistensi indeks
    $_SESSION['tasks'] = array_values($_SESSION['tasks']);
    $_SESSION['alert'] = 'Task successfully deleted!';
} else {
    $_SESSION['alert'] = 'Task not found.';
}

header('Location: index.php');
exit();
?>
