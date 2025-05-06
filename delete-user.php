<?php
require_once 'config.php';
session_start();

// Check admin authentication
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Validate user ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = 'معرف المستخدم غير صالح';
    header('Location: admin-dashboard.php');
    exit;
}

$userId = intval($_GET['id']);

// Prevent self-deletion
if ($userId == $_SESSION['user_id']) {
    $_SESSION['error_message'] = 'لا يمكنك حذف حسابك الخاص';
    header('Location: admin-dashboard.php');
    exit;
}

// Check if user exists
$stmt = $conn->prepare("SELECT id FROM gamers WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error_message'] = 'المستخدم غير موجود';
    header('Location: admin-dashboard.php');
    exit;
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Begin transaction
        $conn->begin_transaction();
        
        // Delete user's articles (if needed)
        // $stmt = $conn->prepare("DELETE FROM newstable WHERE author_id = ?");
        // $stmt->bind_param("i", $userId);
        // $stmt->execute();
        
        // Delete user
        $stmt = $conn->prepare("DELETE FROM gamers WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        
        $conn->commit();
        $_SESSION['success_message'] = 'تم حذف المستخدم بنجاح';
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = 'حدث خطأ أثناء حذف المستخدم: ' . $e->getMessage();
    }
    
    header('Location: admin-dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حذف مستخدم - لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --danger: #f72585;
            --dark: #2b2d42;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f5f7fa;
        }

        .confirmation-container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            animation: fadeIn 0.5s ease-in-out;
        }

        .confirmation-title {
            color: var(--danger);
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 1.5rem;
        }

        .confirmation-title::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 80px;
            height: 3px;
            background: var(--danger);
        }

        .btn-danger {
            background-color: var(--danger);
            border: none;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #e11575;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(247, 37, 133, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--dark), #3f37c9)">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin-dashboard.php">لوحة تحكم المدير</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin-dashboard.php">المستخدمون</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-user.php">إضافة مستخدم</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">حذف مستخدم</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="confirmation-container mt-4">
        <h2 class="confirmation-title">تأكيد حذف المستخدم</h2>
        <p class="lead">هل أنت متأكد أنك تريد حذف هذا المستخدم؟ هذا الإجراء لا يمكن التراجع عنه.</p>
        
        <form method="POST">
            <div class="d-flex justify-content-between mt-4">
                <a href="admin-dashboard.php" class="btn btn-secondary">إلغاء</a>
                <button type="submit" class="btn btn-danger">نعم، احذف المستخدم</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>