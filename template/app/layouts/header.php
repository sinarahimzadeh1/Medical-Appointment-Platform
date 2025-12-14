<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="keywords" content="<?= $setting['keywords'] ?>">
  <meta name="author" content="colorlib">
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="<?= asset($setting['icon']) ?>">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
  <link rel="stylesheet" href='<?= asset("public/app/css/linearicons.css") ?>'>
  <link rel="stylesheet" href='<?= asset("public/app/css/font-awesome.min.css") ?>'>
  <link rel="stylesheet" href='<?= asset("public/app/css/magnific-popup.css") ?>'>
  <link rel="stylesheet" href='<?= asset("public/app/css/nice-select.css") ?>'>
  <link rel="stylesheet" href='<?= asset("public/app/css/animate.min.css") ?>'>
  <link rel="stylesheet" href='<?= asset("public/app/css/owl.carousel.css") ?>'>
  <link rel="stylesheet" href='<?= asset("public/app/css/jquery-ui.css") ?>'>
  <link rel="stylesheet" href='<?= asset("public/app/css/all.min.css") ?>'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href='<?= asset("public/app/css/main.css") ?>'>
  <link rel="stylesheet" href='<?= asset("public/app/css/manual-responsive.css") ?>'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <?php if (!empty($meta)) { ?>
    <title><?= $meta['title'] ?? '' ?></title>
    <meta name="description" content="<?= $meta['description'] ?? '' ?>">
    <link rel="canonical" href="<?= $meta['url'] ?? '' ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $meta['title'] ?? '' ?>">
    <meta property="og:description" content="<?= $meta['description'] ?? '' ?>">
    <meta property="og:image" content="<?= $meta['image'] ?? '' ?>">
    <meta property="og:url" content="<?= $meta['url'] ?? '' ?>">
    <meta property="og:type" content="article">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $meta['title'] ?? '' ?>">
    <meta name="twitter:description" content="<?= $meta['description'] ?? '' ?>">
    <meta name="twitter:image" content="<?= $meta['image'] ?? '' ?>">
  <?php } else { ?>
    <title><?= $setting['title'] ?></title>
    <meta name="description" content="<?= $setting['description'] ?>">
  <?php } ?>

</head>

<body>
  <?php

  // header
  if (isset($_SESSION['number'])) {
    $userPermission = $db->select("SELECT permission FROM users WHERE number =  ?", [$_SESSION['number']])->fetch();
    if ($userPermission != null) {
      if ($userPermission['permission'] == "admin") {
        $userAccess = $userPermission['permission'];
      }
    }
    $admin = $db->select("SELECT * FROM doctors WHERE number =  ?", [$_SESSION['number']])->fetch();
    if (!$admin) {
      if (currentUrl() === url('/') || currentUrl() === url('/home') || currentUrl() === url('/contact-us')) {
        $reserveHistory = '<a class="link-menu btn btn-info text-white" href="#reserveHistory">تاریخچه نوبت</a>';
      } else {
        $reserveHistory = '<a class="link-menu btn btn-info text-white" href="' . url('/') . '#reserveHistory">تاریخچه نوبت</a>';
      }
    }
  }

  if (currentUrl() === url('/') || currentUrl() === url('/home') || currentUrl() === url('/contact-us')) {
    $link = '<a class="link-menu" href="#" data-bs-toggle="modal" data-bs-target="#bookingModal">رزرو نوبت</a>';
  } else {
    $link = '<a class="link-menu" href="' . url('/') . '#reserve">رزرو نوبت</a>';
  }
  ?>
  <header class="sticky-top shadow-sm">
    <nav class="navbar">
      <div class="app">

        <div class="d-flex justify-content-between align-items-center bar d-none">
          <div class="burger-menu">
            <i class="fas fa-bars"></i>
          </div>
          <a href="<?= asset('/') ?>" class="logo">
            <img src="<?= asset($setting['logo']) ?>" alt="Logo">
          </a>
        </div>

        <ul class="menu-items">
          <li class="menu-active">
            <a class="manual-image-space" href="<?= asset('/') ?>"><img src="<?= asset($setting['logo']) ?>"
                width="160"></a>
          </li>
          <li class="menu-active">
            <?= $link ?>
          </li>
          <?php if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])) { ?>
            <li class="menu-active">
              <a class="link-menu" href=<?= url("blog") ?>>بلاگ</a>
            </li>
          <?php } ?>
          <?php foreach ($menus as $menu) { ?>
            <li class="menu-active">
              <a class="link-menu" href="<?= url($menu['url']) ?>"><?= $menu['name'] ?></a>
            </li>
          <?php } ?>
          <?php if (isset($_SESSION['username'])) { ?>
            <li class="menu-active position-relative" style="position: relative;">
              <a class="link-menu" id="userMenuToggle">
                <span style="font-weight: bold; font-size: 16px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd"
                    class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path
                      d="M16 8a8 8 0 1 1-16 0 8 8 0 0 1 16 0zM6.97 10.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 8.439 6.03 6.97a.75.75 0 1 0-1.06 1.06l1.999 2z" />
                  </svg>
                  <?= $_SESSION['username'] ?>
                </span>
                <i class="fa-solid fa-angle-down"></i>
              </a>

              <div class="submenu-box rounded-3" id="userSubmenu">
                <?php if (isset($reserveHistory)) {
                  echo $reserveHistory;
                } ?>
                <?php if ($admin || isset($userAccess)) { ?>
                  <a class="btn btn-warning w-100 mt-2 text-white" href="<?= url('/admin') ?>">پنل مدیریت</a>
                <?php } ?>
                <a href="<?= asset('logout') ?>" class="btn btn-danger text-white">خروج</a>
              </div>
            </li>

          <?php } else { ?>
            <li class="menu-active">
              <a class="link-menu btn btn-info text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                ورود / ثبت نام
              </a>
            </li>

          <?php } ?>
        </ul>
      </div>
    </nav>

    <!-- Mobile navbar -->
    <nav id="responsive-navigation" style="padding: 10px;">
      <ul>
        <a href="<?= asset('/') ?>">
          <img class="manual-image-space-2" src="<?= asset('public/images/logo/logo.png') ?>">
        </a>
        <li class="menu-active">
          <?= $link ?>
        </li>
        <?php if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])) { ?>
          <li class="menu-active">
            <a class="link-menu" href=<?= url("blog") ?>>بلاگ</a>
          </li>
        <?php } ?>
        <?php foreach ($menus as $menu) { ?>
          <li class="menu-active">
            <a class="link-menu" href="<?= url($menu['url']) ?>"><?= $menu['name'] ?></a>
          </li>
        <?php } ?>
        <?php if (isset($_SESSION['username'])) { ?>
          <li class="menu-active">
            <?php if (isset($reserveHistory)) {
              echo $reserveHistory;
            } ?>
            <?php if ($admin || isset($userAccess)) { ?>
              <a class="link-menu mt-2 btn btn-warning text-white" href="<?= url('/admin') ?>">پنل مدیریت</a>
            <?php } ?>
            <a class="link-menu mt-2 btn btn-danger text-white" href="<?= asset('logout') ?>">خروج از حساب</a>
          </li>
        <?php } else { ?>
          <li class="menu-active">
            <a class="link-menu mt-1 btn btn-info text-white" href="#" data-bs-toggle="modal"
              data-bs-target="#loginModal">
              ورود / ثبت نام
            </a>
          </li>
        <?php } ?>
      </ul>
      <?php if (isset($_SESSION['username'])) { ?>
        <div style="text-align: center; margin-top: 20px;">
          <span style="font-weight: bold; font-size: 16px;">
            <?= $_SESSION['username'] ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" class="bi bi-check-circle-fill"
              viewBox="0 0 16 16">
              <path
                d="M16 8a8 8 0 1 1-16 0 8 8 0 0 1 16 0zM6.97 10.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 8.439 6.03 6.97a.75.75 0 1 0-1.06 1.06l1.999 2z" />
            </svg>
          </span>
        </div>
      <?php } ?>
    </nav>

  </header>

  <?php
  $flashKeys = [
    'register_error' => 'danger',
    'auth_error' => 'danger',
    'post_error' => 'danger',
    'register_success' => 'success',
    'auth_success' => 'success',
    'rating_error' => 'danger',
    'rating_success' => 'success',
    'comment_success' => 'success',
    'success_reserve' => 'success',
    'error' => 'danger'
  ];

  foreach ($flashKeys as $key => $type) {
    $message = flash($key);
    if (!empty($message)) {
      ?>
      <div class="flash-toast toast-<?= $type ?>">
        <?= htmlspecialchars($message) ?>
      </div>
      <?php
    }
  }
  ?>