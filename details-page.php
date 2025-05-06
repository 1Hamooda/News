<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
    
    <main class="container mt-2">
        <!-- Header Section -->
        <section class="row">
            <div class="col-md-8">
                <span class="text-secondary"> Monster Hunter Wilds </span>
                <h1 class="mt-2">تعد لعبة Monster Hunter Wilds كتتمة روحية للجزء الماضي Monster Hunter World حيث يتشاركان بالكثير من العناصر</h1>
                <span class="mt-2">
                    <i class="bi bi-calendar-date"></i>
                     28-02-2024
                </span>
            </div>
        </section>

       

        <!-- Main Content & Sidebar -->
        <div class="row mt-4">
            
            <!-- Main Content -->
            <div class="col-md-8">

                <div class="col-md-12">
                    <div class="card border bg-light d-inline-block w-100">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <p class="mb-0 text-dark">شارك القصة</p>
                
                            <div class="d-flex gap-3"> 
                                <i class="bi bi-facebook"></i>
                                <i class="bi bi-twitter-x"></i>
                                <i class="bi bi-instagram"></i>
                                <i class="bi bi-youtube"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                

                <div class="card border-0 bg-body-tertiary d-inline-block h-50 ">
                    <img class="card-img-top" src="News WebPage\Photos\thumb-1920-1393476.jpg">
                    <div class="card-body">
                        <h6 class="text-muted">العاب -الكترونية</h6>
                        <p class="text-secondary"> 
                            سلسلة العاب Monster Hunter من شركة كابكوم وخلال أكثر من 20 عام من بدايتها باتت واحدة من اكثر سلاسل الشركة من حيث الشعبية وتعلق الجماهير بها،                        </p>

                        <p class="text-secondary"> 
                            خلال السنوات الماضية حصلت السلسلة على العديد من الألعاب و التطورات بكل جزء فيها، والان بعد انتظار طويل نحصل على الجزء الرئيسي الجديد منها Monster Hunter Wilds بمحرك كابكوم RE Engine ومخصصة لأجهزة الجيل الحالي المنزلية والحاسب الشخصي،                        </p>

                        <p class="text-secondary"> 
                            هل استطاعت كابكوم أن تتفوق على نفسها وتقدم لنا تجربة قوية بهذه اللعبة؟ أم تراجع مستواها في ظل ظهور العديد من الألعاب المشابهة؟ اليوم وبعد ساعات طويلة من التجربة نقدم لكم المراجعة الشاملة للعبة كابكوم المنتظرة Monster Hunter Wilds وواحدة من أضخم إصدارات هذا العام.                        </p>

                        <h5 > Monster Hunter Wilds

                            مغامرة صيد الوحوش هذه المرة من كابكوم هي الأفضل!
                             </h5>
                        <p class="text-secondary"> 
أيضا تقدم اللعبة نظاما جديدا يسمى بالـFocus Mode وفكرته انك الان بات بإمكانك ان تضرب الوحش في مكان محدد واذا ضربته في نفس المكان لعدد من المرات سيفتح جرحا وحينها تستطيع ان تستخدم الـFocus Strike وهي ضربة قوية موجعة                        </p>
                    </div>
                </div>

                <div class="row">
                    <span class="col-md border-bottom   ">
                        <div class="d-flex justify-content-between mt-3">
                
                            <div class="border-bottom border-3 border-primary pb-1">
                
                                <h5 class="text-secondary">
                
                                    إقرأ أيضا
                
                                </h5>
                
                
                            </div>
                
                        </div>
                    </span>
                    <p class="text-secondary"> 
                        الى منطقة جرح الوحش وتسبب ضرر كبير جدا و تقلب موازين المعركة أيضا وبعدها سيصبح هناك ندبة مكان الجرح ولا تستطيع فتح الجرح مرة أخرى في نفس المكان لذا يجب عليك التنويع في الضربات لفتح جروح كثيرة في الوحش وأيضا الحاق ضرر كبير له. 
                        <p class="text-secondary"> 
                            تمت مراجعة لعبة Monster Hunter Wilds بنسخة جهاز بلايستيشن5 تم توفيرها من قبل ناشر اللعبة قبل صدورها
                </div>

            </div>

            <!-- Sidebar -->
            <div class=" col-md-4">
                
                <!-- المزيد عن الألعاب -->
                <section class="mb-4">
                    <h6 class="border-bottom py-3 mt-4">
                        <span class="border-bottom border-4 border-primary">المزيد عن الألعاب</span>
                    </h6>
                    <ul class="list-unstyled mt-2">
                        <li class="py-2">◆ <a href="#" class="text-decoration-none"> Split Fiction </a></li>
                        <li class="py-2">◆ <a href="#" class="text-decoration-none">Assassin’s Creed Shadows</a></li>
                        <li class="py-2">◆ <a href="#" class="text-decoration-none">The First Berserker: Khazan</a></li>
                    </ul>
                </section>

                <div class="w-50 align-items-center d-flex justify-content-center mx-auto mb-4">
                    <img src="News WebPage\Photos\Screenshot_51.png" class="img-fluid" alt="Separator">
                </div>

   <!-- ألعاب ذات صلة -->
   <section class="mt-">
    <h6 class="border-bottom p-2 mt-0">
        <span class="border-bottom border-4 border-primary text-secondary">ألعاب ذات صلة</span>
    </h6>

    <div class="card border-0 ">
        <div class="row g-0">
            <div class="col-4">
                <img src="News WebPage\Photos\link_tears_of_hyrule_statue_3.png" class="img-fluid rounded-start" alt="Game-new">
            </div>
            <div class=" col-8">
                <div class="card-body">
                    <p class="text-muted mb-1">أخبار - ألعاب</p>
                    <h6 class="card-title">إشاعة: فيلم The Legend of Zelda السينمائي سيكون بثلاثية أفلام! 
                        </h6>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 ">
        <div class="row g-0">
            <div class="col-4">
                <img src="News WebPage\Photos\Space-Adventure-Cobra-Awakening.png" class="img-fluid rounded-start" alt="Game-new">
            </div>
            <div class=" col-8">
                <div class="card-body">
                    <p class="text-muted mb-1">أخبار - ألعاب</p>
                    <h6 class="card-title">العرض الجديد للعبة Blades of Fire يستعرض معه نظام اللعب 
                        </h6>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 ">
        <div class="row g-0">
            <div class="col-4">
                <img src="News WebPage\Photos\croc_legend.png" class="img-fluid rounded-start" alt="Game-new">
            </div>
            <div class=" col-8">
                <div class="card-body">
                    <p class="text-muted mb-1">أخبار - ألعاب</p>
                    <h6 class="card-title">لعبة NieR: Automata هي من أعاد الثقة للمطور الياباني بحسب حديث Shuhei Yoshida 
                        </h6>
                </div>
            </div>
        </div>
    </div>
</section>


            </div>
        </div>

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