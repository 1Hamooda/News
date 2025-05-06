<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
    
</head>
<style>
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

<main class="m-4">
  <div class="row ">
    <span class="col-md border-bottom ">
        <div>
            <h3>
                <span class="border-bottom border-4 border-primary pb-1 container">
                    الالعاب الالكترونية
                </span>
            </h3>
        </div>
    </span>
</div>

<section class="row g-4 mt-2">
    <div class="col-md-8">

        <div class="card border-0 ">
            <img class="card-img-top" src="News WebPage\Photos\Games.png">
            <div class="card-body">
                <h6 class="text-muted">العاب -الكترونية</h6>
                <h5 >أخيرا ، الحقبة الزمنية المنتظرة تتحقق في هذا الجزء من سلسلة Assassin's Creed </h5>
                <p class="text-secondary"> 
                    و أخيرا ، حصلنا على جزء لأساسنز كريد بأحداث تتمحور في اليابان القديمة بعد إنتظار طويل. و هنا ستلعب بشخصيتين رئيسيتين و هما البطلة ناوي و البطل ياسوكي في رحلة قصصية ممتعة في اليابان بمناخ متغير و أجواء رائعة. السؤال الذي يطرح نفسه هل هذه أفضل جزء في السلسلة تم إصداره؟ إليك مراجعة Assassin’s Creed Shadows على منصة الحاسب الشخصي.
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0  mb-3">
            <img class="card-img-top" src="News WebPage\Photos\ubisoft.jpg" alt="ubisoft">
            <div class="card-body">
                <h6 class="text-muted">ubisoft - اخبار</h6>
                <h5 class="fw-bold">موظفو Ubisoft متخوّفون من التسريحات بعد الإعلان عن التعاون مع Tencent </h5>
            </div>
        </div>
        <div class="card  mb-3 border-0">
            <div class="row g-0">
                <div class="col-4">
                    <img src="News WebPage\Photos\hogwarts-legacy.png" class="img-fluid rounded-start" alt="Game-news">
                </div>
                <div class="col-8">
                    <div class="card-body">
                        <p class="text-muted mb-1">تقارير - WarnerBros </p>
                        <h6 class="card-title"> تقارير Warner Bros ألغت توسعة Hogwarts Legacy 
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-0 ">
            <div class="row g-0">
                <div class="col-4">
                    <img src="News WebPage\Photos\TLOA3-1.png" class="img-fluid rounded-start" alt="Game-new">
                </div>
                <div class=" col-8">
                    <div class="card-body">
                        <p class="text-muted mb-1">تقرير - TGA</p>
                        <h6 class="card-title">إشاعة: لعبة The Last of Us 3 قيد التطوير بالفعل لكن ليست بقيادة “نيل دركمان” 
                            </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mb-4 d-flex align-items-start gap-3">
                <img src="News WebPage\Photos\gta-6_oJXCNbs.png" class="img-fluid" style="width: 300px; height: auto; ">
                <div style="max-width: 500px;" alt="Game-new">
                    <h6 class="fw-bold mb-1 text-muted">GTA 6</h6>
                    <h5 class="fw-bold mb-2">محلل: تأجيل GTA 6 قد يتسبب في ضرر اقتصادي ضخم لصناعة الألعاب كلها وبعض الشركات لن تنجو </h5>
                    <p class="text-secondary mb-0">طرح المحلل بن فوستر من شركة الإحصاء Newzoo وجهة نظر مثيرة للإهتمام، قال فيها أن تاجيل GTA 6 من شأنه أن يضر صناعة الألعاب، وأن هناك شركات كثيرة لن تنجو من مثل هذا الإجراء، والسبب أن شركات كثيرة لا تعرف مستقبل ألعابها بشكل قاطع وتواريخ إطلاقها لأنها تنتظر أن تعلن Rockstar عن تاريخ إطلاق GTA 6،</p>
                    
                </div>
            </div>
    
            <div class="mb-4 d-flex align-items-start gap-3">
                <img src="News WebPage\Photos\berserker-khazan.png" class="img-fluid" style="width: 300px; height: auto;">
                <div style="max-width: 500px;" alt="Game-new">
                    <h6 class="fw-bold mb-1 text-muted">The First Berserker: Khazan</h6>
                    <h5 class="fw-bold mb-2">مطور The First Berserker: Khazan: صعوبة الألعاب يجب أن تكون بغرض التحدي لا أن تُرهق اللاعب </h5>
                    <p class="text-secondary mb-2">في تصريح جديد لموقع Gamesradar، قال Junho Lee، المدير الإبداعي لمشروع لعبة The First Berserker: Khazan أن اللعبة ستقدم صعوبة متوازنة، وأن الاستوديو المطور لها يعي جيدًا أن صعوبات الألعاب يجب أن تكون متوازنة، فكلما اشتدت كلما كان عليها أن تقدم حوائز تشعر اللاعب بقيمة هذا العناء الذي خاضه، وإلا فسوف يشعر اللاعب بالإرهاق مع مرور الوقت.</p>
                </div>
            </div>
        </div>
    
        <div class="col-md-2 ">
            <div class="card border-0">
                <img src="News WebPage\Photos\SplitF.png" class="card-img-top" alt="advertise ">
            </div>
        </div>
    </div>

</section>

</main>

<footer class="bg-secondary text-center text-lg-start text-white mt-4">
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row my-4">
        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

          <div class="rounded-circle bg-white shadow-1-strong d-flex align-items-center justify-content-center mb-4 mx-auto" style="width: 150px; height: 150px;">
            <img src="News WebPage\Photos\4533718.png" height="70" alt="" loading="lazy" />
          </div>

          <p class="text-center">The Gaming Comunity</p>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">روابط</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-paw pe-3"></i>When your game is missing</a></li>
            <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-paw pe-3"></i>Recently found</a></li>
            <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-paw pe-3"></i>How to buy?</a></li>
            <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-paw pe-3"></i>Game for adoption</a></li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">عن الموقع</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-paw pe-3"></i>General information</a></li>
            <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-paw pe-3"></i>About us</a></li>
            <li class="mb-2"><a href="#" class="text-white"><i class="fas fa-paw pe-3"></i>Statistic data</a></li>
          </ul>
        </div>
        <!--Grid column-->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">اتصل بنا</h6>
            <i class="bi bi-facebook"></i>
            <i class="bi bi-twitter-x"></i>
            <i class="bi bi-instagram"></i>
            <i class="bi bi-youtube"></i>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->
  </footer>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>