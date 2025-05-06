<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an editor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'editor') {
    header('Location: login.php');
    exit;
}

// Verify article ID exists and action is valid
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['action'])) {
    $_SESSION['error_message'] = "طلب غير صالح";
    header('Location: editor-dashboard.php');
    exit;
}

$article_id = intval($_GET['id']);
$action = $_GET['action'];

// Validate action
if (!in_array($action, ['approve', 'deny'])) {
    $_SESSION['error_message'] = "إجراء غير صالح";
    header('Location: editor-dashboard.php');
    exit;
}

// Determine new status
$new_status = ($action === 'approve') ? 'approved' : 'denied';

try {
    // Update article status
    $stmt = $conn->prepare("UPDATE newstable SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $article_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $message = ($action === 'approve') 
                ? "تم قبول المقال بنجاح" 
                : "تم رفض المقال بنجاح";
            $_SESSION['success_message'] = $message;
        } else {
            $_SESSION['error_message'] = "لم يتم العثور على المقال أو لم يتم تغيير حالته";
        }
    } else {
        throw new Exception("فشل في تحديث حالة المقال");
    }
    
} catch (Exception $e) {
    $_SESSION['error_message'] = "حدث خطأ: " . $e->getMessage();
}

header('Location: editor-dashboard.php');
exit;
?>