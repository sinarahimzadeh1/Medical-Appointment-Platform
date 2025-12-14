<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>پنل مدیریت <?= $setting['title'] ?></title>
    <link rel="shortcut icon" href="<?= asset($setting['icon']) ?>" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= asset('public/admin-panel/src/css/vendors_css.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/admin-panel/src/css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/admin-panel/src/css/skin_color.css') ?>">
    <style>
        ::selection {
            background-color: #00ff95 !important;
            color: #fff !important;
        }

        @media screen and (max-width: 767.98px) {

            .main-header .r-side .app-menu,
            .main-header .r-side .btn-group a {
                margin: 3px 0px !important;
            }
        }
    </style>

</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed rtl">

    <div class="wrapper">
        <div id="loader"></div>

        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-start d-md-none d-block">
                <!-- Logo -->
                <a href="<?= url('/') ?>" class="logo">
                    <div class="logo-lg my-2">
                        <!-- <span class="light-logo"><img src="<?= asset($setting['logo']) ?>" alt="logo"></span> -->
                        <!-- <span class="dark-logo"><img src="<?= asset($setting['logo']) ?>" alt="logo"></span> -->
                    </div>
                </a>
            </div>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <div class="app-menu">
                    <ul class="header-megamenu nav">
                        <li class="btn-group nav-item">
                            <a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light"
                                data-toggle="push-menu" role="button">
                                <i class="icon-Menu"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">

                        <li class="btn-group nav-item">
                            <a href="<?= url('/') ?>"
                                class="waves-effect waves-light nav-link btn-primary-light svg-bt-icon" title="">
                                <i class="icon-Layout-arrange"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </a>
                        </li>
                        <?php if (CURRENT_PLAN == "A"): ?>
                            <li class="btn-group nav-item d-xl-inline-flex">
                                <a href="<?= url('/blog/') ?>"
                                    class="waves-effect waves-light nav-link btn-primary-light svg-bt-icon" title="">
                                    <i class="icon-Notification"><span class="path1"></span><span class="path2"></span></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="btn-group nav-item d-xl-inline-flex">
                            <a href="<?= url('/contact-us') ?>"
                                class="waves-effect waves-light nav-link btn-primary-light svg-bt-icon" title="">
                                <i class="icon-Chat"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                        </li>

                        <li class="btn-group nav-item d-xl-inline-flex d-none">
                            <a href="#" data-provide="fullscreen"
                                class="waves-effect waves-light nav-link btn-primary-light svg-bt-icon"
                                title="تمام صفحه">
                                <i class="icon-Expand-arrows"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                        </li>

                        <!-- User Account-->
                        <li class="dropdown user user-menu">
                            <a href="#"
                                class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent p-0 no-shadow"
                                title="User" data-bs-toggle="modal" data-bs-target="#quick_user_toggle">
                                <div class="d-flex pt-1">
                                    <div class="text-end me-10">
                                        <p class="pt-5 fs-14 mb-0 fw-700 text-primary"> <?= $doctor['name'] ?></p>
                                        <small class="fs-10 mb-0 text-uppercase text-mute"> ادمین</small>
                                    </div>
                                    <img style="object-fit: cover;" src="<?= asset($doctor['profile']) ?>"
                                        class="avatar rounded-10 bg-primary-light h-40 w-40" alt="" />
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>