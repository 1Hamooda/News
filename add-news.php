<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'author') {
    header("Location: unauthorized.php");
    exit();
}


require_once 'config.php';

$error = '';
$categories = [];

try {
    $stmt = $conn->prepare("SELECT id, name FROM categorytable ORDER BY name");
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    $error = "خطأ في جلب التصنيفات: " . $e->getMessage();
    error_log($e->getMessage());
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $title = trim($_POST['title'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);
    $body = trim($_POST['body'] ?? '');
    $author_id = $_SESSION['user_id'];
    
    // Basic validation
    if (empty($title)) {
        $error = "عنوان المقال مطلوب";
    } elseif (empty($category_id)) {
        $error = "التصنيف مطلوب";
    } elseif (empty($body)) {
        $error = "محتوى المقال مطلوب";
    } else {
        // Handle image upload if provided
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                $upload_dir = 'News WebPage\Photos';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid('news_') . '.' . $file_ext;
                $target_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $image_path = $target_path;
                } else {
                    $error = "حدث خطأ أثناء رفع الصورة";
                }
            } else {
                $error = "نوع الملف غير مسموح به. يرجى رفع صورة (JPEG, PNG, GIF, WebP)";
            }
        }
        
        if (empty($error)) {
            // Insert the article into database with 'pending' status
            try {
                // No transaction needed since we're only doing one operation
                $stmt = $conn->prepare("INSERT INTO newstable 
                                      (title, body, image, dateposted, category_id, author_id, status) 
                                      VALUES (?, ?, ?, NOW(), ?, ?, 'pending')");
                
                if ($stmt === false) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                
                $stmt->bind_param("sssii", $title, $body, $image_path, $category_id, $author_id);
                
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: " . $stmt->error);
                }
                
                $stmt->close();
                
                // Redirect to success page or dashboard
                $_SESSION['success_message'] = "تم إرسال المقال بنجاح بانتظار الموافقة من المحرر";
                header("Location: author-dashboard.php");
                exit();
                
            } catch (Exception $e) {
                $error = "حدث خطأ أثناء حفظ المقال: " . $e->getMessage();
                error_log("Article submission error: " . $e->getMessage());
            }
        }
    }
}

// The HTML part remains exactly as you have it, just make sure to include the PHP processing code above
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مقال جديد</title>
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
            --gray: #94a3b8;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
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

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* Main Content */
        .container {
            animation: fadeIn 0.6s ease-out;
            max-width: 800px;
            padding-bottom: 3rem;
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

        /* Form Styling */
        form {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        form:hover {
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            background-color: white;
        }

        textarea.form-control {
            min-height: 200px;
            resize: vertical;
        }

        /* File Input Customization */
        .form-control[type="file"] {
            padding: 0.5rem;
        }

        /* Alert Styling */
        .alert-danger {
            background-color: rgba(247, 37, 133, 0.1);
            border-left: 4px solid var(--danger);
            border-radius: 0.5rem;
            color: var(--danger);
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(67, 97, 238, 0.3);
            width: 100%;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.4);
            opacity: 0.95;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* RTL specific adjustments */
        .form-control, .form-select, .alert {
            text-align: right;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            form {
                padding: 1.5rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">إضافة مقال جديد</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="author-dashboard.php">العودة للوحة التحكم</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
    <h2>إضافة مقال جديد</h2>
    
    <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">عنوان المقال</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            
            <div class="mb-3">
                <label for="category_id" class="form-label">التصنيف</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">اختر تصنيف</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="body" class="form-label">محتوى المقال</label>
                <textarea class="form-control" id="body" name="body" rows="10" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">صورة المقال (اختياري)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            
            <button type="submit" class="btn btn-primary">حفظ المقال</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>