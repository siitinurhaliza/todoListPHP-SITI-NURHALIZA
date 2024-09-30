<?php
// complete.php
session_start();

// Memastikan ada daftar tugas
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Mendapatkan ID tugas dari parameter URL
if (isset($_GET['id']) && isset($_SESSION['tasks'][$_GET['id']])) {
    $_SESSION['tasks'][$_GET['id']]['completed'] = true;
    $_SESSION['alert'] = 'Task marked as completed successfully!';
} else {
    $_SESSION['alert'] = 'Task not found.';
}

header('Location: index.php');
exit();
?>
