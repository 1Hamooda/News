<?php
require_once 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Verify article ID exists
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "معرف المقال غير صالح";
    header('Location: ' . ($_SESSION['role'] === 'editor' ? 'editor-dashboard.php' : 'author-dashboard.php'));
    exit;
}

$article_id = intval($_GET['id']);

try {
    // Get article details with author and category info
    $query = "SELECT n.*, c.name as category_name, u.name as author_name 
              FROM newstable n 
              JOIN categorytable c ON n.category_id = c.id 
              JOIN gamers u ON n.author_id = u.id 
              WHERE n.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();
    
    if (!$article) {
        throw new Exception("لم يتم العثور على المقال");
    }
    
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: ' . ($_SESSION['role'] === 'editor' ? 'editor-dashboard.php' : 'author-dashboard.php'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المقال - <?= htmlspecialchars($article['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --light: #f8f9fa;
            --dark: #2b2d42;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        .navbar {
            background: linear-gradient(135deg, var(--dark), var(--secondary));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .article-container {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-top: 2rem;
        }

        .article-title {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .article-title::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--success));
            border-radius: 2px;
        }

        .article-meta {
            color: #64748b;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1rem;
        }

        .article-image {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .article-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: rgba(255, 190, 11, 0.1);
            color: #ffbe0b;
        }

        .status-approved {
            background-color: rgba(6, 214, 160, 0.1);
            color: #06d6a0;
        }

        .status-denied {
            background-color: rgba(239, 71, 111, 0.1);
            color: #ef476f;
        }

        .btn-back {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 0.375rem;
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .article-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <?= $_SESSION['role'] === 'editor' ? 'لوحة تحكم المحرر' : 'لوحة تحكم المؤلف' ?>
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="article-container">
            <h1 class="article-title"><?= htmlspecialchars($article['title']) ?></h1>
            
            <div class="article-meta">
                <div class="d-flex justify-content-between">
                    <span>التصنيف: <?= htmlspecialchars($article['category_name']) ?></span>
                    <span>المؤلف: <?= htmlspecialchars($article['author_name']) ?></span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span>تاريخ النشر: <?= date('Y-m-d H:i', strtotime($article['dateposted'])) ?></span>
                    <span class="status-badge <?= 'status-' . $article['status'] ?>">
                        <?php 
                        switch($article['status']) {
                            case 'approved': echo 'مقبول'; break;
                            case 'denied': echo 'مرفوض'; break;
                            default: echo 'قيد المراجعة';
                        }
                        ?>
                    </span>
                </div>
            </div>
            
            <?php if (!empty($article['image'])): ?>
            <img src="<?= htmlspecialchars($article['image']) ?>" class="article-image" alt="صورة المقال">
            <?php endif; ?>
            
            <div class="article-content">
                <?= nl2br(htmlspecialchars($article['body'])) ?>
            </div>
            
            <a href="<?= $_SESSION['role'] === 'editor' ? 'editor-dashboard.php' : 'author-dashboard.php' ?>" 
               class="btn btn-back">
               العودة إلى لوحة التحكم
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>