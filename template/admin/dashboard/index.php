<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="container-full">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xl-3 col-md-6 col-12">
          <div class="box">
            <div class="box-body bg-gradiant-green-blue">
              <h4 class="mt-0 text-white fw-bold">تمام دکتر ها</h4>
              <div class="d-flex align-items-center justify-content-between">
                <h2 class="fw-600 my-0 text-white"><?= count($doctors) ?></h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
          <div class="box">
            <div class="box-body bg-juicy-orange">
              <h4 class="text-white fw-bold mt-0">تعداد نوبت ها</h4>
              <div class="d-flex align-items-center justify-content-between">
                <h2 class="fw-600 my-0 text-white"><?= count($reservingTimes) ?></h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
          <div class="box">
            <div class="box-body bg-dracula">
              <h4 class="text-white fw-bold mt-0">آخرین نوبت آزاد</h4>
              <div class="d-flex align-items-center justify-content-between">
                <h2 class="fw-bold my-0 text-white"><?= $lastReservesTime["date"] ?></h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
          <div class="box">
            <div class="box-body bg-neon-life">
              <h4 class="text-white fw-bold mt-0">آخرین نوبت رزرو شده</h4>
              <div class="d-flex align-items-center justify-content-between">
                <h2 class="fw-600 my-0 text-white"><?= $lastReservedTime["date"] ?></h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">بیشترین روز های رزرو شده</h4>
            </div>
            <div class="box-body">
              <div id="analytics-bar-chart1"></div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">رزرو های اخیر</h4>
            </div>
            <div class="box-body px-0">
              <div class="table-responsive">
                <table class="table table-borderless mb-0">
                  <tbody>
                    <?php
                    $nullTable = 4 - count($lastFourReservedTimes);
                    foreach ($lastFourReservedTimes as $user):
                      ?>
                      <tr>
                        <td>
                          <h5 class="fw-500 my-0 min-w-150"><img style="object-fit: cover;"
                              src="<?= asset('public/admin-panel/images/avatar/user.webp') ?>"
                              class="avatar me-10 bg-primary-light" alt="">
                            <?= $user["username"] ?>
                          </h5>
                        </td>
                        <td>
                          <h5 class="fw-500 my-0"><span
                              class="me-10 badge badge-dot badge-primary"></span><?= $user['number'] ?></h5>
                        </td>
                        <td>
                          <h5 class="fw-500 my-0"><?= $user['date'] ?></h5>
                        </td>
                        <td>
                          <h5 class="fw-500 my-0"><span
                              class="me-10 badge badge-dot badge-primary"></span><?= $user['week'] ?></h5>
                        </td>
                      </tr>
                    <?php endforeach;
                    for ($nullTable; $nullTable > 0; $nullTable--) { ?>
                      <tr>
                        <td>
                          <h5 class="fw-500 my-0 min-w-150"><img style="object-fit: cover;"
                              src="<?= asset('public/user-image/profile.jpg') ?>" class="avatar me-10 bg-primary-light"
                              alt="">
                            -
                          </h5>
                        </td>
                        <td>
                          <h5 class="fw-500 my-0"><span class="me-10 badge badge-dot badge-primary"></span>-</h5>
                        </td>
                        <td>
                          <h5 class="fw-500 my-0">-</h5>
                        </td>
                        <td>
                          <h5 class="fw-500 my-0"><span class="me-10 badge badge-dot badge-primary"></span>-</h5>
                        </td>
                      </tr>
                    <?php }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">تمام کامنت ها</h4>
            </div>
            <?php
            $sum = $commentCount['COUNT(*)'] + $commentSeenCount['COUNT(*)'] + $commentApprovedCount['COUNT(*)'] + $commentUnseenCount['COUNT(*)'];
            $sum = 10 - $sum;
            ?>
            <div class="box-body">
              <div class="d-flex py-10 w-p100 rounded100 overflow-hidden">
                <div class="bg-warning h-10" style="width: <?= $commentCount['COUNT(*)']; ?>0%;"></div>
                <div class="bg-info h-10" style="width: <?= $commentSeenCount['COUNT(*)']; ?>0%;"></div>
                <div class="bg-success h-10" style="width: <?= $commentApprovedCount['COUNT(*)']; ?>0%;"></div>
                <div class="bg-danger h-10" style="width: <?= $commentUnseenCount['COUNT(*)']; ?>0%;"></div>
                <div class="bg-secondary h-10" style="width: <?= $sum ?>0%;"></div>
              </div>
            </div>
            <div class="box-body p-0">
              <div class="media-list media-list-hover media-list-divided">
                <a class="media media-single rounded-0" href="#">
                  <span class="badge badge-xl badge-dot badge-warning"></span>
                  <span class="title">تعداد تمام کامنت ها </span>
                  <span class="badge badge-pill badge-warning-light"><?= $commentCount['COUNT(*)']; ?></span>
                </a>

                <a class="media media-single rounded-0" href="#">
                  <span class="badge badge-xl badge-dot badge-info"></span>
                  <span class="title">رد شده </span>
                  <span class="badge badge-pill badge-info-light"><?= $commentSeenCount['COUNT(*)']; ?></span>
                </a>

                <a class="media media-single rounded-0" href="#">
                  <span class="badge badge-xl badge-dot badge-success"></span>
                  <span class="title">پذیرفته شده</span>
                  <span class="badge badge-pill badge-success-light"><?= $commentApprovedCount['COUNT(*)']; ?></span>
                </a>

                <a class="media media-single rounded-0" href="#">
                  <span class="badge badge-xl badge-dot badge-danger"></span>
                  <span class="title">پذیرفته نشده</span>
                  <span class="badge badge-pill badge-danger-light"><?= $commentUnseenCount['COUNT(*)']; ?></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">گردش مالی رزرو آنلاین</h4>
            </div>
            <div class="box-body">
              <div id="staff_turnover1"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
require_once BASE_PATH . '/template/admin/dashboard/min.php';
?>