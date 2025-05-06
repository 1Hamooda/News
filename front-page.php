<?php
require_once 'config.php';

try {
    // Fetch only approved news items with their categories and authors
    $query = "SELECT n.*, c.name as category_name, u.name as author_name 
              FROM newstable n 
              JOIN categorytable c ON n.category_id = c.id 
              JOIN gamers u ON n.author_id = u.id 
              WHERE n.status = 'approved'
              ORDER BY n.dateposted DESC 
              LIMIT 12"; // Limit to 12 most recent approved articles
    
    $result = $conn->query($query);
    $approvedArticles = [];
    
    while ($row = $result->fetch_assoc()) {
        $approvedArticles[] = $row;
    }
    
} catch (Exception $e) {
    // Handle error silently for front page
    $approvedArticles = [];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>أخبار الألعاب الإلكترونية</title>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
        .navbar {
            background-color: #063a6e;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .article-card {
            transition: transform 0.3s;
        }
        .article-card:hover {
            transform: translateY(-5px);
        }
        .category-header {
            border-right: 4px solid #0d6efd;
            padding-right: 10px;
        }

        /* Enhanced Navbar Styles */
    .navbar {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        padding: 0.5rem 1rem;
    }
    
    .navbar-nav {
        margin-left: 0 !important;
        margin-right: auto;
    }
    
    .nav-link {
        padding: 0.5rem 1rem;
        margin: 0 0.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 0.25rem;
    }
    
    .nav-link:hover, .nav-link.active {
        background-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }
    
    .navbar-brand {
        padding: 0;
        margin-left: 1rem;
    }
    
    @media (max-width: 991.98px) {
        .navbar-collapse {
            padding: 1rem 0;
        }
        .nav-item {
            margin: 0.25rem 0;
        }
        .d-flex.me-auto {
            margin-right: 0 !important;
            margin-top: 1rem;
        }
    }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #063a6e;">
    <div class="container-fluid">
        <!-- Brand/Logo on the right -->
        <a class="navbar-brand me-0" href="front-page.php">
            <img src="News WebPage/Photos/game.png" alt="Logo" height="30" class="d-inline-block align-text-top">
        </a>
        
        <!-- Toggler on the left -->
        <button class="navbar-toggler ms-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Navigation links - aligned right -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="front-page.php">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">مراجعات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">إصدارات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ثقافة الألعاب</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">إرشادات ونصائح</a>
                </li>
            </ul>
            
            <!-- Search form - properly aligned -->
            <form class="d-flex me-auto ms-3" role="search">
                <input class="form-control" type="search" placeholder="بحث" aria-label="بحث" style="width: 200px;">
            </form>
            
            <!-- Weather info - aligned left -->
            <div class="d-flex text-white align-items-center me-3">
                <div class="text-end">
                    <div>8 °C</div>
                    <div>الدوحة</div>
                </div>
            </div>
        </div>
    </div>
</nav>
    <main class="container mt-4">
        <?php if (!empty($approvedArticles)): ?>
        <section class="row g-4">
            <!-- Main Featured Article -->
            <div class="col-md-4">
                <div class="card bg-dark text-white article-card">
                    <?php if (!empty($approvedArticles[0]['image'])): ?>
                    <img src="<?= htmlspecialchars($approvedArticles[0]['image']) ?>" class="card-img-top" alt="Article Image">
                    <?php endif; ?>
                    <div class="card-body">
                        <h6 class="card-title text-secondary"><?= htmlspecialchars($approvedArticles[0]['category_name']) ?></h6>
                        <h5 class="card-title"><?= htmlspecialchars($approvedArticles[0]['title']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars(substr($approvedArticles[0]['body'], 0, 200))) ?>...</p>
                        <a href="view-news.php?id=<?= $approvedArticles[0]['id'] ?>" class="btn btn-primary">قراءة المزيد</a>
                    </div>
                </div>
            </div>

            <!-- Secondary Articles -->
            <div class="col-md-3">
                <?php for ($i = 1; $i <= 2; $i++): ?>
                    <?php if (isset($approvedArticles[$i])): ?>
                    <div class="card mb-3 border-0 article-card">
                        <?php if (!empty($approvedArticles[$i]['image'])): ?>
                        <img src="<?= htmlspecialchars($approvedArticles[$i]['image']) ?>" class="card-img-top">
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title text-secondary"><?= htmlspecialchars($approvedArticles[$i]['category_name']) ?></h6>
                            <h6 class="card-title"><?= htmlspecialchars($approvedArticles[$i]['title']) ?></h6>
                            <a href="view-news.php?id=<?= $approvedArticles[$i]['id'] ?>" class="btn btn-outline-primary btn-sm">قراءة المزيد</a>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>

            <!-- Third Column Articles -->
            <div class="col-md-3">
                <?php for ($i = 3; $i <= 4; $i++): ?>
                    <?php if (isset($approvedArticles[$i])): ?>
                    <div class="card mb-3 border-0 article-card">
                        <?php if (!empty($approvedArticles[$i]['image'])): ?>
                        <img src="<?= htmlspecialchars($approvedArticles[$i]['image']) ?>" class="card-img-top">
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title text-secondary"><?= htmlspecialchars($approvedArticles[$i]['category_name']) ?></h6>
                            <h6 class="card-title"><?= htmlspecialchars($approvedArticles[$i]['title']) ?></h6>
                            <a href="view-news.php?id=<?= $approvedArticles[$i]['id'] ?>" class="btn btn-outline-primary btn-sm">قراءة المزيد</a>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </section>

        <!-- Most Read Section -->
        <div class="row mt-4">
            <div class="col-md border-bottom">
                <div class="d-flex justify-content-between mt-3">
                    <h5 class="category-header">الأكثر قراءة</h5>
                    <h5 class="category-header">المزيد من الأخبار</h5>
                    <a class="text-decoration-none text-primary" href="#">المزيد</a>
                </div>
            </div>
        </div>

        <section class="row mt-3">
            <div class="col-md-4">
                <ul class="list-unstyled">
                    <?php for ($i = 5; $i < 10; $i++): ?>
                        <?php if (isset($approvedArticles[$i])): ?>
                        <li class="border-bottom py-3">
                            <a class="text-decoration-none text-dark" href="view-news.php?id=<?= $approvedArticles[$i]['id'] ?>">
                                <?= htmlspecialchars($approvedArticles[$i]['title']) ?>
                            </a>
                        </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                </ul>
            </div>

            <div class="col-md-8">
                <div class="row g-3">
                    <?php if (isset($approvedArticles[10])): ?>
                    <div class="col-md-8">
                        <div class="card border-0 article-card">
                            <?php if (!empty($approvedArticles[10]['image'])): ?>
                            <img src="<?= htmlspecialchars($approvedArticles[10]['image']) ?>" class="card-img-top">
                            <?php endif; ?>
                            <div class="card-body">
                                <h6 class="card-title text-secondary"><?= htmlspecialchars($approvedArticles[10]['category_name']) ?></h6>
                                <h5 class="card-title"><?= htmlspecialchars($approvedArticles[10]['title']) ?></h5>
                                <p class="card-text"><?= nl2br(htmlspecialchars(substr($approvedArticles[10]['body'], 0, 150))) ?>...</p>
                                <a href="view-news.php?id=<?= $approvedArticles[10]['id'] ?>" class="btn btn-primary">قراءة المزيد</a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="col-md-4">
                        <?php if (isset($approvedArticles[11])): ?>
                        <div class="card border-0 article-card">
                            <div class="card-body">
                                <h6 class="card-title text-secondary"><?= htmlspecialchars($approvedArticles[11]['category_name']) ?></h6>
                                <h6 class="card-title"><?= htmlspecialchars($approvedArticles[11]['title']) ?></h6>
                                <?php if (!empty($approvedArticles[11]['image'])): ?>
                                <img src="<?= htmlspecialchars($approvedArticles[11]['image']) ?>" class="card-img-top mt-2">
                                <?php endif; ?>
                                <a href="view-news.php?id=<?= $approvedArticles[11]['id'] ?>" class="btn btn-outline-primary btn-sm mt-2">قراءة المزيد</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Category Sections -->
        <?php 
        $categories = ['Nintendo', 'Ubisoft', 'Steam', 'Electronic Arts (EA)'];
        foreach ($categories as $category): 
            $categoryArticles = array_filter($approvedArticles, function($article) use ($category) {
                return stripos($article['category_name'], $category) !== false;
            });
            if (!empty($categoryArticles)):
        ?>
        <section class="row mt-4">
            <div class="row">
                <div class="col-md border-bottom">
                    <div class="d-flex justify-content-between mt-3">
                        <h3 class="category-header"><?= $category ?></h3>
                        <a class="text-decoration-none" href="#">المزيد</a>
                    </div>
                </div>
            </div>

            <div class="row g-2 mt-2">
                <?php $categoryArticles = array_values($categoryArticles); ?>
                <?php if (!empty($categoryArticles[0])): ?>
                <div class="col-md-6">
                    <div class="card border-0 article-card">
                        <?php if (!empty($categoryArticles[0]['image'])): ?>
                        <img src="<?= htmlspecialchars($categoryArticles[0]['image']) ?>" class="card-img-top">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($categoryArticles[0]['title']) ?></h5>
                            <p><?= nl2br(htmlspecialchars(substr($categoryArticles[0]['body'], 0, 100))) ?>...</p>
                            <a href="view-news.php?id=<?= $categoryArticles[0]['id'] ?>" class="btn btn-primary btn-sm">قراءة المزيد</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php for ($i = 1; $i < min(4, count($categoryArticles)); $i++): ?>
                <div class="col-md-3">
                    <div class="card border-0 article-card">
                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($categoryArticles[$i]['title']) ?></h6>
                            <?php if (!empty($categoryArticles[$i]['image'])): ?>
                            <img src="<?= htmlspecialchars($categoryArticles[$i]['image']) ?>" class="card-img-top mt-2">
                            <?php endif; ?>
                            <a href="view-news.php?id=<?= $categoryArticles[$i]['id'] ?>" class="btn btn-outline-primary btn-sm mt-2">قراءة المزيد</a>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </section>
        <?php 
            endif;
        endforeach; 
        ?>
        <?php else: ?>
        <div class="alert alert-info mt-4">لا توجد مقالات معتمدة للعرض حالياً</div>
        <?php endif; ?>
    </main>

    <footer class="bg-secondary text-white mt-4 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="News WebPage/Photos/4533718.png" height="70" alt="Logo">
                    <p class="mt-2">The Gaming Community</p>
                </div>
                <div class="col-md-3">
                    <h5>روابط</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">When your game is missing</a></li>
                        <li><a href="#" class="text-white">Recently found</a></li>
                        <li><a href="#" class="text-white">How to buy?</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>عن الموقع</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">General information</a></li>
                        <li><a href="#" class="text-white">About us</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>اتصل بنا</h5>
                    <div class="social-icons">
                        <i class="bi bi-facebook me-2"></i>
                        <i class="bi bi-twitter-x me-2"></i>
                        <i class="bi bi-instagram me-2"></i>
                        <i class="bi bi-youtube"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>