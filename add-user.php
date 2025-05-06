<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'جميع الحقول مطلوبة';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'البريد الإلكتروني غير صالح';
    } else {
        try {
            // Check if email exists
            $stmt = $conn->prepare("SELECT id FROM gamers WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            
            if ($stmt->get_result()->num_rows > 0) {
                $error = 'البريد الإلكتروني موجود مسبقاً';
            } else {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $stmt = $conn->prepare("INSERT INTO gamers (name, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
                
                if ($stmt->execute()) {
                    $success = 'تمت إضافة المستخدم بنجاح';
                    $_POST = []; // Clear form
                } else {
                    throw new Exception("خطأ في إضافة المستخدم");
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
    <title>إضافة مستخدم جديد</title>
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
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border: none;
            padding: 0.75rem 1.5rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--dark), var(--secondary))">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin-dashboard.php">لوحة تحكم المدير</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin-dashboard.php">المستخدمون</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="add-user.php">إضافة مستخدم</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="form-title">إضافة مستخدم جديد</h2>
        
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
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="mb-3">
                    <label for="role" class="form-label">الدور</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="author">مؤلف</option>
                        <option value="editor">محرر</option>
                        <option value="admin">مدير</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">إضافة مستخدم</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>