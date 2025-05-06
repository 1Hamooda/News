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
    header('Location: admin-dashboard.php');
    exit;
}

$userId = intval($_GET['id']);
$error = '';
$success = '';

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM gamers WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header('Location: admin-dashboard.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    // Validation
    if (empty($name) || empty($email)) {
        $error = 'الاسم والبريد الإلكتروني مطلوبان';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'البريد الإلكتروني غير صالح';
    } else {
        try {
            // Check email uniqueness
            $stmt = $conn->prepare("SELECT id FROM gamers WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $email, $userId);
            $stmt->execute();
            
            if ($stmt->get_result()->num_rows > 0) {
                $error = 'البريد الإلكتروني موجود مسبقاً';
            } else {
                // Prepare update query
                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $query = "UPDATE gamers SET name = ?, email = ?, password = ?, role = ? WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssssi", $name, $email, $hashedPassword, $role, $userId);
                } else {
                    $query = "UPDATE gamers SET name = ?, email = ?, role = ? WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sssi", $name, $email, $role, $userId);
                }
                
                // Execute update
                if ($stmt->execute()) {
                    $success = 'تم تحديث بيانات المستخدم بنجاح';
                    // Refresh user data
                    $stmt = $conn->prepare("SELECT * FROM gamers WHERE id = ?");
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();
                } else {
                    throw new Exception("خطأ في تحديث بيانات المستخدم");
                }
            }
        } catch (Exception $e) {
            $error = "حدث خطأ: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل مستخدم - لوحة التحكم</title>
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
            background-color: #f5f7fa;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 0.5s ease-in-out;
        }

        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-top: 2rem;
        }

        .form-title {
            color: var(--dark);
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 1.5rem;
        }

        .form-title::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--success));
        }

        .form-control, .form-select {
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border: none;
            padding: 0.75rem 1.5rem;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
        }

        .alert {
            border-radius: 0.375rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--dark), var(--secondary))">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin-dashboard.php">لوحة تحكم المدير</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin-dashboard.php">المستخدمون</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-user.php">إضافة مستخدم</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">تعديل مستخدم</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="admin-container mt-4">
        <h2 class="form-title">تعديل مستخدم</h2>
        
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور الجديدة (اتركها فارغة إذا لم ترغب في التغيير)</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="أدخل كلمة مرور جديدة">
                    <small class="text-muted">يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل</small>
                </div>
                
                <div class="mb-3">
                    <label for="role" class="form-label">الدور</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="author" <?= $user['role'] === 'author' ? 'selected' : '' ?>>مؤلف</option>
                        <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>محرر</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>مدير</option>
                    </select>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="admin-dashboard.php" class="btn btn-secondary">رجوع</a>
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password strength validation (optional)
        document.getElementById('password').addEventListener('input', function() {
            if (this.value.length > 0 && this.value.length < 8) {
                this.setCustomValidity('كلمة المرور يجب أن تكون 8 أحرف على الأقل');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>