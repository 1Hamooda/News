<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an author
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Verify article ID exists
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "معرف المقال غير صالح";
    header('Location: author-dashboard.php');
    exit;
}

$article_id = intval($_GET['id']);
$author_id = $_SESSION['user_id'];

try {
    // Check if article belongs to this author
    $stmt = $conn->prepare("SELECT id FROM newstable WHERE id = ? AND author_id = ?");
    $stmt->bind_param("ii", $article_id, $author_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error_message'] = "لم يتم العثور على المقال أو ليس لديك صلاحية الحذف";
        header('Location: author-dashboard.php');
        exit;
    }
    
    // Delete the article
    $stmt = $conn->prepare("DELETE FROM newstable WHERE id = ?");
    $stmt->bind_param("i", $article_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "تم حذف المقال بنجاح";
    } else {
        throw new Exception("فشل في حذف المقال");
    }
    
} catch (Exception $e) {
    $_SESSION['error_message'] = "حدث خطأ: " . $e->getMessage();
}

header('Location: author-dashboard.php');
exit;
?>