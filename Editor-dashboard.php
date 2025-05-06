<?php
require_once 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM gamers WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || $user['role'] != 'editor') {
    header('Location: front-page.php');
    exit;
}

// Get all news items using MySQLi
$query = "SELECT n.*, c.name as category_name, u.name as author_name 
          FROM newstable n 
          JOIN categorytable c ON n.category_id = c.id 
          JOIN gamers u ON n.author_id = u.id 
          ORDER BY n.dateposted DESC";
          
$newsResult = $conn->query($query);
$newsItems = [];
while ($row = $newsResult->fetch_assoc()) {
    $newsItems[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المحرر</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #ffbe0b;
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
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .container {
            animation: fadeIn 0.6s ease-out;
        }

        h2 {
            color: var(--dark);
            position: relative;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        h2::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--success));
            border-radius: 2px;
        }

        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            background-color: white;
            margin-top: 1.5rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
        }

        .table th {
            font-weight: 600;
            padding: 1rem;
            text-align: right;
        }

        .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            transition: all 0.2s ease;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(67, 97, 238, 0.03);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.08);
            transform: translateX(-4px);
        }

        .btn {
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: none !important;
            margin-left: 0.25rem;
            margin-right: 0;
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.825rem;
        }

        .btn-info {
            background-color: #3a86ff;
            border-color: #3a86ff;
        }

        .btn-success {
            background-color: var(--success);
            border-color: var(--success);
        }

        .btn-danger {
            background-color: var(--danger);
            border-color: var(--danger);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .text-success {
            color: #06d6a0 !important;
        }

        .text-warning {
            color: #ffbe0b !important;
        }

        .text-danger {
            color: #ef476f !important;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table th, .table td {
            text-align: right;
        }

        .btn {
            margin-left: 0;
            margin-right: 0.25rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">لوحة تحكم المحرر</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="editor-dashboard.php">المقالات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <h2>المقالات المقدمة للمراجعة</h2>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>العنوان</th>
                        <th>المؤلف</th>
                        <th>التصنيف</th>
                        <th>تاريخ النشر</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newsItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td><?= htmlspecialchars($item['author_name']) ?></td>
                        <td><?= htmlspecialchars($item['category_name']) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($item['dateposted'])) ?></td>
                        <td>
                            <?php 
                            $statusText = '';
                            $statusClass = '';
                            switch ($item['status']) {
                                case 'approved':
                                    $statusText = 'مقبول';
                                    $statusClass = 'text-success';
                                    break;
                                case 'denied':
                                    $statusText = 'مرفوض';
                                    $statusClass = 'text-danger';
                                    break;
                                default:
                                    $statusText = 'قيد المراجعة';
                                    $statusClass = 'text-warning';
                            }
                            ?>
                            <span class="<?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                        <td>
                            <a href="view-news.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-info">عرض</a>
                            <a href="approve-news.php?id=<?= $item['id'] ?>&action=approve" class="btn btn-sm btn-success">قبول</a>
                            <a href="approve-news.php?id=<?= $item['id'] ?>&action=deny" class="btn btn-sm btn-danger">رفض</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>