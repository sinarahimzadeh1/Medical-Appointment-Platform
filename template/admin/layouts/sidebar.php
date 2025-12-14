<aside class="main-sidebar">
  <!-- sidebar-->
  <section class="sidebar position-relative">
    <div class="d-flex align-items-center logo-box justify-content-start d-md-block d-none">
      <!-- Logo -->
      <a href="<?= url('/') ?>" class="logo">
        <!-- logo-->
        <div class="logo-mini">
          <span class="light-logo"><img style="object-fit: cover; width: 60%;" src="<?= asset($setting['icon']) ?>"
              alt="logo"></span>
        </div>
      </a>
    </div>
    <div class="user-profile my-15 px-20 py-10 b-1 rounded10 mx-15">
      <div class="d-flex align-items-center justify-content-between">
        <div class="image d-flex align-items-center">
          <img style="object-fit: cover;" src="<?= asset($doctor['profile']) ?>" class="rounded-3 me-10"
            style="object-fit: cover;" alt="User Image">
          <div>
            <h4 class="mb-0 fw-600"><?= $doctor['name'] ?> </h4>
            <p class="mb-0">ادمین</p>
          </div>
        </div>
      </div>
    </div>
    <div class="multinav">
      <div class="multinav-scroll" style="height: 97%;">
        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">منوی اصلی</li>
          <li>
            <a href="<?= url('/admin') ?>">
              <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
              <span>داشبورد</span>
            </a>
          </li>
          <li>
            <a href="<?= url('admin/reserve') ?>">
              <i class="icon-Chart-pie"><span class="path1"></span><span class="path2"></span></i>
              <span>نوبت های موجود</span>
            </a>
          </li>
          <li>
            <a href="<?= url('admin/reserved') ?>">
              <i class="icon-Alarm-clock"><span class="path1"></span><span class="path2"></span><span
                  class="path3"></span></i>
              <span>نوبت های رزرو شده</span>
            </a>
          </li>

          <?php if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])): ?>
            <li>
              <a href="<?= url('admin/post') ?>">
                <i class="icon-Library"><span class="path1"></span><span class="path2"></span></i>
                <span>پست ها</span>
              </a>
            </li>
            <li>
              <a href="<?= url('admin/category') ?>">
                <i class="icon-Flag"><span class="path1"></span><span class="path2"></span></i>
                <span>دسته بندی ها</span>
              </a>
            </li>
            <li>
              <a href="<?= url('admin/comment') ?>">
                <i class="icon-Chat2"><span class="path1"></span><span class="path2"></span></i>
                <span>کامنت ها</span>
              </a>
            </li>
            <li>
              <a href="<?= url('admin/banner') ?>">
                <i class="icon-Box2"><span class="path1"></span><span class="path2"></span></i>
                <span>بنر ها</span>
              </a>
            </li>
          <?php endif; ?>

          <li>
            <a href="<?= url('admin/user') ?>">
              <i class="icon-Add-user"><span class="path1"></span><span class="path2"></span></i>
              <span>کاربران</span>
            </a>
          </li>
          <li>
            <a href="<?= url('admin/doctor') ?>">
              <i class="icon-Diagnostics"><span class="path1"></span><span class="path2"></span><span
                  class="path3"></span></i>
              <span>دکتر ها</span>
            </a>
          </li>
          <li>
            <a href="<?= url('admin/faq') ?>">
              <i class="icon-Settings-1"><span class="path1"></span><span class="path2"></span></i>
              <span> سوالات متداول دکتر ها</span>
            </a>
          </li>
          <li>
            <a href="<?= url('admin/menu') ?>">
              <i class="icon-Globe"><span class="path1"></span><span class="path2"></span></i>
              <span>منو </span>
            </a>
          </li>
          <li>
            <a href="<?= url('admin/websetting') ?>">
              <i class="icon-Warning-2"><span class="path1"></span><span class="path2"></span><span
                  class="path3"></span></i>
              <span>تنظیمات</span>
            </a>
          </li>
      </div>
    </div>
  </section>
</aside>