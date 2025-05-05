<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an editor
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM gamer WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();

if ($user['role'] != 'editor') {
    header('Location: front-page.php');
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    header('Location: editor-dashboard.php');
    exit;
}

$newsId = $_GET['id'];
$action = $_GET['action'];

if ($action == 'approve') {
    $status = 'approved';
} elseif ($action == 'deny') {
    $status = 'denied';
} else {
    header('Location: editor-dashboard.php');
    exit;
}

// Update news status
$stmt = $pdo->prepare("UPDATE news SET status = ? WHERE id = ?");
$stmt->execute([$status, $newsId]);

header('Location: editor-dashboard.php');
exit;
?>