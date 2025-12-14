<?php
require_once BASE_PATH . '/template/app/layouts/header.php';

if (!isset($_SESSION['dataID'])) {
  $doctor = $db->select("SELECT * FROM doctors ORDER BY id ASC LIMIT 1")->fetch();
  $_SESSION['dataID'] = $doctor['id'];
  $reserves = $db->select("SELECT * FROM reserves WHERE doctor_id = ? ORDER BY date ASC", [$_SESSION['dataID']])->fetchAll();
} else {
  $reserves = $db->select("SELECT * FROM reserves WHERE doctor_id = ? ORDER BY date ASC", [$_SESSION['dataID']])->fetchAll();
}

if (!empty($reserves[0]['date'])) {
  $tomorrow = \Parsidev\Jalali\jdate::forge('now')->reforge('+ 1 day')->format('date');
  $isTomorrow = $reserves[0]['date'] === $tomorrow;
  $dateParts = explode('-', $reserves[0]['date']);
  $reversedDate = $dateParts[0] . '-' . $dateParts[1] . '-' . $dateParts[2];
} else {
  $isTomorrow = false;
  $reversedDate = '';
}

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 20;
$offset = ($page - 1) * $limit;
$totalPages = 1;
if (isset($_SESSION['user_id'])) {
  $currentUser = $db->select("SELECT username, id FROM users WHERE id = ?", [$_SESSION['user_id']])->fetch();

  if ($currentUser) {
    $totalRows = $db->select("SELECT COUNT(*) as count FROM reservedtimes WHERE user_id = ?", [$currentUser['id']])->fetch()['count'];
    $totalPages = ceil($totalRows / $limit);
    $reservedUser = $db->select("SELECT reservedtimes.*, doctors.name AS docName, users.username AS userName  FROM reservedtimes  LEFT JOIN doctors ON doctors.id = reservedtimes.doctor_id  LEFT JOIN users ON users.id = reservedtimes.user_id  WHERE user_id = ?  ORDER BY reservedtimes.created_at DESC  LIMIT $limit OFFSET $offset", [$currentUser['id']])->fetchAll();
  }
}

?>

<main class="container my-5" id="main-content">
  <div class="row mt-5" id="reserve">

    <div class="page-title-container">
      <h1 class="page-title">انتخاب پزشک و مشاهده اطلاعات</h1>
      <div class="title-underline"></div>
    </div>

    <div class="col-12 mb-4 loc-1">
      <div id="map-desktop" style="height: 400px;" class="shadow-sm rounded-3"></div>
    </div>

    <div class="col-md-5">
      <?php foreach ($doctors as $key => $doctor) {

        $total_score = 0;
        $total_reserves = 0;
        $total_rates = 0;
        foreach ($suggestion_score as $item) {
          if ($item['doctor_id'] == $doctor['id']) {
            $total_score = $item['suggestion_score'];
            $total_reserves = $item['total_reserves'];
            $total_rates = $item['total_rating'];
            break;
          }
        }

        $profile = $doctor['profile'];
        ?>
        <div
          class="send card doctor-card doctor-selectable shadow-sm p-3 mb-3 rounded-4 <?= $key === 0 ? 'selected' : '' ?>"
          data-id="<?= $doctor['id'] ?>" data-likes="<?= $total_rates ?>" data-reserves="<?= $total_reserves ?>"
          data-score="<?= $total_score ?>" data-name="<?= $doctor['name'] ?>" data-clinic="<?= $doctor['clinic'] ?>"
          data-expert="<?= $doctor['expert'] ?>" data-doc_number="<?= $doctor['doc_number'] ?>"
          data-experience="<?= $doctor['experience'] ?>" data-location="<?= $doctor['location'] ?>"
          data-phone="<?= $doctor['surgery_phone'] ?>" data-profile="<?= $doctor['profile'] ?>"
          data-coords="<?= $doctor['coords'] ?>" data-services="<?= $doctor['services'] ?>">

          <div class="d-flex align-items-center flex-row-reverse">
            <div class="w-50">
              <h5 class="mb-1 fw-bold res-font"><?= $doctor['name'] ?></h5>
            </div>
            <img src="<?= $doctor['profile'] ?>" alt="<?= $doctor['name'] ?>" class="rounded-circle mx-3 color-image2"
              style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ffffff;">
          </div>
        </div>
      <?php } ?>

      <div class="doctor-card text-end d-none d-lg-block" id="doctor-detail">
        <div class="page-title-container" style="margin-top: 10px;">
          <h1 class="page-title">خدمات دکتر <span class="doc-name" style="line-height: 2;"></span> <i class="fa fa-angle-left fs-6"></i> </h1>
          <div class="title-underline"></div>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <span class="doc-services">
          </span>
        </div>
      </div>

      <div class="col-12 mb-4 d-none loc-2">
        <div id="map-mobile" style="height: 400px;" class="shadow-sm rounded-3"></div>
      </div>
    </div>

    <div class="col-md-7 mb-1">
      <div class="doctor-card text-end" id="doctor-detail">
        <div class="mt-3 mb-5 text-end d-block d-lg-none" id="doctor-detail">
          <div class="page-title-container" style="margin-top: 10px;">
            <h1 class="page-title">خدمات دکتر <span class="doc-name" style="line-height: 2;"></span> <i class="fa fa-angle-left fs-6"></i> </h1>
            <div class="title-underline"></div>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <span class="doc-services">
            </span>
          </div>
        </div>

        <div class="page-title-container" style="margin-top: 10px;">
          <h1 class="page-title"><i class="far fa-hospital ms-2"></i> نوبت‌ دهی اینترنتی مطب دکتر <span
              class="doc-name" style="line-height: 2;">...</span> <i class="fa fa-angle-left fs-6"></i> </h1>
          <div class="title-underline"></div>
        </div>

        <h5 class="text-bold mb-4"></h5>
        <div class="clinic-card border border-primary rounded-3 p-3 mb-5 text-end btn-book" id="btn-book">
          <div class="fw-bold mb-2"> <span class="doc-clinic"></span></div>
          <div class="mb-2 text-muted">
            <i class="fas fa-map-marker-alt ms-2"></i>
            آدرس: <span class="doc-location"></span>
          </div>
          <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3 flex-wrap">
            <div class="text-primary small">
              <i class="far fa-calendar-alt ms-1"></i>
              <span class="text-primary">اولین نوبت آزاد: </span>
              <span class="text-success fw-bold" id="reserve-info" style="direction: rtl; display: inline-block;">
                <?= $isTomorrow ? 'فردا' : $reversedDate ?> | <?= $reserves[0]['time'] ?>
              </span>
            </div>
            <a class="btn btn-primary px-3 mt-2 mt-sm-0">
              نوبت بگیرید
              <i class="fas fa-arrow-left me-2"></i>
            </a>
          </div>
        </div>


        <h5 class="text-bold mb-3"><i class="fa-regular fa-circle-question mx-2"></i> اطلاعات مطب دکتر <span
            class="doc-name" style="line-height: 2;"></span> <i class="fa fa-angle-left fs-6"></i> </h5>

        <p><strong><i class="fas fa-cut mx-2 fs-6 text-warning"></i>تخصص:</strong> <span class="doc-expert"></span>
        </p>
        <p><strong><i class="fas fa-map-marker-alt mx-2 fs-6 text-success"></i>آدرس:</strong> <span
            class="doc-location"></span> </p>
        <p><strong><i class="fa-solid fa-phone mx-2 fs-6 text-info"></i>تلفن مطب:</strong> <span id="doc-phone"></span>
        </p>
        <p><strong><i class="fas fa-check-circle text-primary mx-2 fs-6"></i>کد نظام پزشکی:</strong> <span
            id="doc-number"></span></p>
        <p><strong><i class="fa-solid fa-calendar-minus mx-2 fs-6 text-muted"></i>سال شروع فعالیت:</strong>
          <span id="doc-experience"></span>
        </p>

        <div class="row text-center small border border-primary rounded-3 p-3 mb-3 mx-1">
          <div class="col">
            <i class="fas fa-check-circle text-info mb-1"></i>
            <div class="fw-bold"><span id="doc-reserves"></span></div>
            <div class="text-muted">نوبت موفق</div>
          </div>
          <div class="col border-start border-end">
            <i class="fas fa-thumbs-up text-success mb-1"></i>
            <div class="fw-bold"><span id="doc-score"></span> ٪</div>
            <div class="text-muted">پیشنهاد کاربران</div>
          </div>
          <div class="col">
            <i class="fas fa-heart text-danger mb-1"></i>
            <div class="fw-bold"><span id="doc-like"></span></div>
            <div class="text-muted">لایک</div>
          </div>
        </div>

        <div class="map-section text-center my-4">
          <h6 class="text-muted mb-3">
            موقعیت مطب دکتر <span class="doc-name text-dark fw-semibold" style="line-height: 2;"></span> در نقشه نشان
          </h6>
          <a href="#" id="onNeshanMap" target="_blank" class="btn btn-primary w-100 rounded-3 shadow-sm">
            <i class="fas fa-map-marked-alt me-2"></i> مشاهده در نقشه نشان
          </a>
          <div class="map-note mt-3 small text-muted">
            <i class="fa fa-circle pulse-dot mx-1"></i>
            پس از ورود به نقشه، مبدا خود را انتخاب کنید
            <i class="fa fa-circle pulse-dot mx-1"></i>
          </div>
        </div>


      </div>
    </div>

    <?php if (isset($reservedUser)) { ?>
      <div class="container mt-0 mb-5" id="reserveHistory">
        <div class="page-title-container">
          <h1 class="page-title">تاریخچه نوبت های شما</h1>
          <div class="title-underline"></div>
        </div>
        <table class="table table-striped table-bordered">
          <thead class="table-dark text-center">
            <tr>
              <th>نام دکتر</th>
              <th>ساعت</th>
              <th>تاریخ</th>
              <th>روز هفته</th>
              <th>هزینه پرداخت شده</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php if (!empty($reservedUser)): ?>
              <?php foreach ($reservedUser as $index => $res): ?>
                <tr>
                  <td><?= htmlspecialchars($res['docName']) ?></td>
                  <td><?= htmlspecialchars($res['time']) ?></td>
                  <td><?= htmlspecialchars($res['date']) ?></td>
                  <td><?= htmlspecialchars($res['week']) ?></td>
                  <td><?= number_format($res['price']) ?> تومان</td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7">هیچ نوبتی ثبت نشده است.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
          <nav>
            <ul class="d-ltr pagination justify-content-center">
              <?php if ($page > 1): ?>
                <li class="page-item">
                  <a class="page-link" href="?page=<?= $page - 1 ?>">قبلی</a>
                </li>
              <?php endif; ?>

              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                  <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>

              <?php if ($page < $totalPages): ?>
                <li class="page-item">
                  <a class="page-link" href="?page=<?= $page + 1 ?>">بعدی</a>
                </li>
              <?php endif; ?>
            </ul>
          </nav>
        <?php endif; ?>
      </div>
    <?php }
    ?>

    <div class="col-12 mt-3">
      <section class="promo-section">
        <div class="promo-item">
          <i class="fas fa-check-circle icon"></i>
          <p class="promo-text fw-bold">پزشکان تایید شده و مجرب</p>
        </div>
        <div class="promo-item">
          <i class="fas fa-clock icon"></i>
          <p class="promo-text fw-bold">نوبت‌دهی سریع و آسان</p>
        </div>
        <div class="promo-item">
          <i class="fas fa-heart icon"></i>
          <p class="promo-text fw-bold">رضایت ۹۷٪ کاربران</p>
        </div>
        <div class="promo-item">
          <i class="fas fa-user-shield icon"></i>
          <p class="promo-text fw-bold">حفظ حریم شخصی کاربران</p>
        </div>
      </section>
    </div>

  </div>
</main>


<?php
require_once BASE_PATH . '/template/app/layouts/modals.php';
require_once BASE_PATH . '/template/app/layouts/footer.php';
?>