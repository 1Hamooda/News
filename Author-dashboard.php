<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an author
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user info
$stmt = $conn->prepare("SELECT * FROM gamers WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']); // "i" for integer
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || $user['role'] != 'author') {
    header('Location: front-page.php');
    exit;
}

// Get author's news items using MySQLi
$stmt = $conn->prepare("SELECT n.*, c.name as category_name 
                      FROM newstable n 
                      JOIN categorytable c ON n.category_id = c.id 
                      WHERE n.author_id = ? 
                      ORDER BY n.dateposted DESC");
                      
$stmt->bind_param("i", $_SESSION['user_id']); // "i" for integer parameter
$stmt->execute();
$result = $stmt->get_result();

$newsItems = [];
while ($row = $result->fetch_assoc()) {
    $newsItems[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المؤلف</title>
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
            padding-bottom: 2rem;
        }

        /* Navbar Styling */
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

        /* Main Content */
        .container {
            animation: fadeIn 0.6s ease-out;
            max-width: 1200px;
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

        /* Table Styling */
        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            background-color: white;
            margin-top: 1.5rem;
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
        }

        .table th {
            font-weight: 600;
            padding: 1rem;
            text-align: right;
            border: none;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            transition: all 0.2s ease;
            border-top: 1px solid #f1f5f9;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(67, 97, 238, 0.03);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.08);
            transform: translateX(-4px);
        }

        /* Status Badges */
        .text-success {
            color: #06d6a0 !important;
            font-weight: 500;
        }

        .text-warning {
            color: var(--warning) !important;
            font-weight: 500;
        }

        .text-danger {
            color: var(--danger) !important;
            font-weight: 500;
        }

        /* Buttons */
        .btn {
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: none !important;
            margin-left: 0.25rem;
            border: none;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.825rem;
            border-radius: 0.375rem;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border: none;
            padding: 0.5rem 1.25rem;
            box-shadow: 0 2px 6px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.4);
        }

        .btn-info {
            background-color: #3a86ff;
            border-color: #3a86ff;
        }

        .btn-warning {
            background-color: var(--warning);
            border-color: var(--warning);
            color: #333;
        }

        .btn-info:hover, .btn-warning:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* RTL specific adjustments */
        .table th, .table td {
            text-align: right;
        }

        .btn {
            margin-left: 0;
            margin-right: 0.25rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 0.5rem;
            }
            
            .table th, .table td {
                padding: 0.75rem;
            }
            
            .btn-sm {
                display: block;
                margin-bottom: 0.25rem;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">لوحة تحكم المؤلف</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="author-dashboard.php">مقالاتي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-news.php">إضافة مقال جديد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>مقالاتي</h2>
        <a href="add-news.php" class="btn btn-primary mb-3">إضافة مقال جديد</a>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>العنوان</th>
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
                            <div class="d-flex">
                                <a href="view-news.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-info">عرض</a>
                                <?php if ($item['status'] == 'pending' || $item['status'] == 'denied'): ?>
                                <a href="edit-news.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">تعديل</a>
                                <?php endif; ?>
                            </div>
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