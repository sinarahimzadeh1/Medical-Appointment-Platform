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

<div id="carouselExampleCaptions" class="carousel slide position-relative shadow-lg">
  <!-- Indicators & Slides -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100 color-image lazy-img" src="<?= $setting['intro_image_1'] ?>" alt="First slide"
        loading="lazy">
      <div class="carousel-caption d-md-block">
        <h3 class="mb-4"><?= $setting['intro_text_11'] ?></h3>
        <p class="dynamic-bg intro-text"><?= $setting['intro_text_1'] ?></p>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 color-image lazy-img" src="<?= $setting['intro_image_2'] ?>" alt="First slide"
        loading="lazy">
      <div class="carousel-caption d-md-block">
        <h3 class="mb-4"> <?= $setting['intro_text_22'] ?></h3>
        <p class="dynamic-bg intro-text"><?= $setting['intro_text_2'] ?></p>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 color-image lazy-img" src="<?= $setting['intro_image_3'] ?>" alt="First slide"
        loading="lazy">
      <div class="carousel-caption d-md-block">
        <h3 class="mb-4"><?= $setting['intro_text_33'] ?></h3>
        <p class="dynamic-bg intro-text"><?= $setting['intro_text_3'] ?></p>
      </div>
    </div>
  </div>

  <div class="container position-relative">
    <div class="carousel-cards d-flex flex-wrap position-absolute w-100 px-2">

      <div class="card-top text-center p-2 flex-grow-1 m-1">
        <a href="#">
          <img src="<?= asset('public/images/1.jpg') ?>" alt="نوبت دهی" class="card-img lazy-img mx-auto">
          <p class="mt-2 mb-0 itext itext-blue shadow-lg fs-7 text-black">نوبت دهی <i class="far fa-clock"></i></p>
        </a>
      </div>

      <div class="card-top text-center p-2 flex-grow-1 m-1">
        <a href="#">
          <img src="<?= asset('public/images/2.jpg') ?>" alt="خدمات" class="card-img lazy-img mx-auto">
          <p class="mt-2 mb-0 itext itext-purple shadow-lg fs-6 text-black">خدمات <i class="fas fa-user-md"></i></p>
        </a>
      </div>

      <div class="card-top text-center p-2 flex-grow-1 m-1">
        <a href="#">
          <img src="<?= asset('public/images/3.jpg') ?>" alt="دندان" class="card-img lazy-img mx-auto">
          <p class="mt-2 mb-0 itext itext-red shadow-lg fs-6">دندان <i class="fas fa-tooth"></i></p>
        </a>
      </div>

    </div>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">قبلی</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">بعدی</span>
  </button>
</div>

<main class="container mt-10" id="main-content">
  <section class="mt-5 py-5" style="margin-top: 150px !important;">
    <div class="row g-4 mt-4">
      <h4 class="fw-bold">پربازدیدترین تخصص‌ ها <i class="fa fa-angle-left fs-6"></i></h4>
      <div class="col-6 col-md-3">
        <div class="cart shadow-lg rounded-4 text-center p-3" style="background-color: #007bff;">
          <div class="bg-white p-3 rounded-3 d-inline-block w-100">
            <img src="<?= asset('public/images/1 (1).png') ?>" alt="تصویر"
              style="width: 100px; height: 100px; object-fit: contain;" class="lazy-img">
          </div>
          <p class="mb-0 mt-3 text-white fw-bold">ایمپلنتولوژی (کاشت دندان/ ایمپلنت) </p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="cart shadow-lg rounded-4 text-center p-3" style="background-color: #007bff;">
          <div class="bg-white p-3 rounded-3 d-inline-block w-100">
            <img src="<?= asset('public/images/1 (2).png') ?>" alt="تصویر"
              style="width: 100px; height: 100px; object-fit: contain;" class="lazy-img">
          </div>
          <p class="mb-0 mt-3 text-white fw-bold">اندودنتیکس (درمان ریشه/ عصب‌کشی) </p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="cart shadow-lg rounded-4 text-center p-3" style="background-color: #007bff;">
          <div class="bg-white p-3 rounded-3 d-inline-block w-100">
            <img src="<?= asset('public/images/1 (3).png') ?>" alt="تصویر"
              style="width: 100px; height: 100px; object-fit: contain;" class="lazy-img">
          </div>
          <p class="mb-0 mt-3 text-white fw-bold">بلیچینگ (ترمیم و زیبایی)</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="cart shadow-lg rounded-4 text-center p-3" style="background-color: #007bff;">
          <div class="bg-white p-3 rounded-3 d-inline-block w-100">
            <img src="<?= asset('public/images/1 (4).png') ?>" alt="تصویر"
              style="width: 100px; height: 100px; object-fit: contain;" class="lazy-img">
          </div>
          <p class="mb-0 mt-3 text-white fw-bold">جراحی دهان، فک و صورت</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="cart shadow-lg rounded-4 text-center p-3" style="background-color: #007bff;">
          <div class="bg-white p-3 rounded-3 d-inline-block w-100">
            <img src="<?= asset('public/images/1 (5).png') ?>" alt="تصویر"
              style="width: 100px; height: 100px; object-fit: contain;" class="lazy-img">
          </div>
          <p class="mb-0 mt-3 text-white fw-bold">رادیولوژی دندان‌پزشکی</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="cart shadow-lg rounded-4 text-center p-3" style="background-color: #007bff;">
          <div class="bg-white p-3 rounded-3 d-inline-block w-100">
            <img src="<?= asset('public/images/1 (6).png') ?>" alt="تصویر"
              style="width: 100px; height: 100px; object-fit: contain;" class="lazy-img">
          </div>
          <p class="mb-0 mt-3 text-white fw-bold">پروتزهای دندانی (دندان مصنوعی)</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="cart shadow-lg rounded-4 text-center p-3" style="background-color: #007bff;">
          <div class="bg-white p-3 rounded-3 d-inline-block w-100">
            <img src="<?= asset('public/images/1 (7).png') ?>" alt="تصویر"
              style="width: 100px; height: 100px; object-fit: contain;" class="lazy-img">
          </div>
          <p class="mb-0 mt-3 text-white fw-bold">ارتودنسی (ردیف‌کردن دندان‌ها)</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="cart shadow-lg rounded-4 text-center p-3" style="background-color: #007bff;">
          <div class="bg-white p-3 rounded-3 d-inline-block w-100">
            <img src="<?= asset('public/images/1 (8).png') ?>" alt="تصویر"
              style="width: 100px; height: 100px; object-fit: contain;" class="lazy-img">
          </div>
          <p class="mb-0 mt-3 text-white fw-bold">پریودنتولوژی (درمان بیماری‌های لثه)</p>
        </div>
      </div>

    </div>
  </section>
</main>

<div class="sweet mt-5">
  <div class="overlay">
    <div class="page-title-container">
      <h1 class="page-title text-white">دندان‌های سالم، لبخندی زیبا</h1>
      <div class="title-underline"></div>
    </div>
    <p class="overlay-text fs-5">دندان‌های سالم نه تنها به زیبایی لبخند شما کمک می‌کنند، بلکه نقش مهمی در حفظ سلامت
      عمومی بدن
      دارند. مراقبت‌های منظم از دندان‌ها، از جمله مسواک زدن روزانه، استفاده از نخ دندان و بازدیدهای منظم از دندان‌پزشک،
      می‌تواند شما را از مشکلات جدی مانند پوسیدگی و بیماری‌های لثه محافظت کند.</p>
  </div>
  <img src="" alt="" style="background-image: url('<?= asset('public/images/vec.jpg') ?>');" class="sweet-sec">
</div>


<!-- swiper blog posts -->
<?php if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])) { ?>
  <div class="container my-5">
    <div class="text-white py-1 rounded-4 shadow-sm position-relative c-slider mt-5"
      style="background-image: url('<?= asset('public/images/bg.png') ?>'), linear-gradient(to right, rgb(59 130 246 / 83%), rgb(28 69 221))">

      <div class="box-header d-flex justify-content-between align-items-center flex-wrap">
        <h4 class="box-title">
          <div class="page-title-container mx-5">
            <h1 class="page-title text-white">پست های اخیر <?= $setting['title'] ?><i
                class="fa fa-angle-left fs-5 fw-bold mx-2"></i></h1>
            <div class="title-underline"></div>
          </div>
        </h4>
        <a role="button" href="<?= url('home/all-posts') ?>" class="btn btn-sm btn-warning mx-5 post-btn">همه پست ها <i
            class="fa-solid fa-arrow-left"></i></a>
      </div>


      <!-- Swiper -->
      <div class="swiper-container mySwiperPosts">
        <div class="swiper-wrapper">
          <?php
          foreach ($posts as $post):
            $text = trim($post['summary']);
            $maxLength = 90;
            if (mb_strlen($text, 'UTF-8') > $maxLength) {
              $text = mb_substr($text, 0, $maxLength, 'UTF-8') . '...';
            }
            $cleaned = htmlspecialchars($text);
            ?>
            <div class="swiper-slide" style="background: rgba(0,0,0,0); border: 0px;">
              <div class="card h-100 shadow-sm rounded-4 mx-auto mobile-swiper" style="border: 0px; min-height: 350px;">
                <a href="<?= url('show-post/' . $post['id']) ?>">
                  <img src="<?= asset($post['image']) ?>" class="card-img-top lazy-img"
                    style="height: 180px; object-fit: cover;" alt="<?= $post['title'] ?>">
                </a>
                <div class="card-body text-center d-flex flex-column justify-content-between" style="height: 170px;">
                  <div>
                    <a href="<?= url('show-post/' . $post['id']) ?>">
                      <h6 class="fw-bold text-truncate" title="<?= $post['title'] ?>"><?= $post['title'] ?> <span
                          class="text-danger">🔴</span></h6>
                      <p class="text-muted small text-truncate" title="<?= $cleaned; ?>"><?= $cleaned; ?></p>
                    </a>
                  </div>
                  <a href="<?= url('show-post/' . $post['id']) ?>" class="text-primary fw-bold small mt-2">مشاهده پست</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Navigation Buttons -->
        <div class="swiper-button-next swiper-next-posts"></div>
        <div class="swiper-button-prev swiper-prev-posts"></div>
      </div>

    </div>
  </div>
<?php } ?>


<?php if (isset($reservedUser)) { ?>
  <div class="container mt-10" id="reserveHistory">
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
          <th>توضیحات</th>
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
              <td><?= !empty($res['additional']) ? htmlspecialchars($res['additional']) : '-' ?></td>
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

<main class="container mt-5" id="main-content">
  <div class="row" id="reserve">
    <div class="page-title-container">
      <h1 class="page-title">انتخاب پزشک مورد نظر</h1>
      <div class="title-underline"></div>
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

        $profile = $doctor['profile']; ?>
        <div
          class="send card doctor-card doctor-selectable shadow-sm p-3 mb-3 rounded-4 <?= $key === 0 ? 'selected' : '' ?>"
          data-id="<?= $doctor['id'] ?>" data-likes="<?= $total_rates ?>" data-reserves="<?= $total_reserves ?>"
          data-score="<?= $total_score ?>" data-name="<?= $doctor['name'] ?>" data-clinic="<?= $doctor['clinic'] ?>"
          data-expert="<?= $doctor['expert'] ?>" data-doc_number="<?= $doctor['doc_number'] ?>"
          data-experience="<?= $doctor['experience'] ?>" data-location="<?= $doctor['location'] ?>"
          data-phone="<?= $doctor['surgery_phone'] ?>" data-profile="<?= $doctor['profile'] ?>"
          data-coords="<?= $doctor['coords'] ?>" data-services="<?= $doctor['services'] ?>">

          <div class="d-flex align-items-center">
            <img src="<?= $doctor['profile'] ?>" alt="<?= $doctor['name'] ?>" class="rounded-circle mx-3 color-image2"
              style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #ffffff;">

            <!-- اطلاعات اضافه که فقط در دسکتاپ نمایش داده میشه -->
            <div class="text-end w-100">
              <h5 class="mb-1 fw-bold"><?= $doctor['name'] ?></h5>
            </div>

          </div>

          <!-- اطلاعات اضافه که فقط در دسکتاپ نمایش داده میشه -->
          <div class="d-none d-lg-block">
            <p class="text-muted mb-0 margin-1">
              <i class="fas fa-user-md mx-2 "></i>
              <?php
              $text = $doctor['expert'];
              $maxLength = 90;

              if (mb_strlen($text, 'UTF-8') > $maxLength) {
                echo mb_substr($text, 0, $maxLength, 'UTF-8') . '...';
              } else {
                echo $text;
              }
              ?>
            </p>
            <p class="text-muted small mb-0">
              <i class="fas fa-map-marker-alt mx-2 text-success"></i><?= $doctor['city'] ?>
            </p>
            <p class="text-muted small mb-0">
              <i class="fas fa-check-circle text-primary mx-2 mt-1"></i>
              کد نظام پزشکی: <strong><?= $doctor['doc_number'] ?></strong>
            </p>

            <hr class="my-3">

            <div class="row text-center small">
              <div class="col">
                <i class="fas fa-check-circle text-info mb-1"></i>
                <div class="fw-bold"><?= $total_reserves ?></div>
                <div class="text-muted">نوبت موفق</div>
              </div>
              <div class="col border-start border-end">
                <i class="fas fa-thumbs-up text-success mb-1"></i>
                <div class="fw-bold"><?= $total_score ?>٪</div>
                <div class="text-muted">پیشنهاد کاربران</div>
              </div>
              <div class="col">
                <i class="fas fa-heart text-danger mb-1"></i>
                <div class="fw-bold"><?= $total_rates ?></div>
                <div class="text-muted">لایک</div>
              </div>
            </div>

          </div>
        </div>

      <?php } ?>


      <?php foreach ($doctors as $key => $doctor) { ?>
        <div class="doctor-card text-end d-none d-md-block">
          <h6 class="fw-bold mb-4">سوالات متداول راجع به دکتر <?= $doctor['name'] ?></h6>
          <div class="accordion" id="faqAccordion<?= $doctor['id'] ?>">
            <?php
            $hasFaq = false;
            foreach ($faqs as $faq) {
              if ($faq['doctor_id'] == $doctor['id']) {
                $hasFaq = true;
                $faqIndex = rand(); ?>
                <div class="accordion-item border mb-2 rounded">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed text-end rounded" type="button" data-bs-toggle="collapse"
                      data-bs-target="#faq<?= $faqIndex ?>">
                      <?= $faq['ask'] ?>
                    </button>
                  </h2>
                  <div id="faq<?= $faqIndex ?>" class="accordion-collapse collapse rounded"
                    data-bs-parent="#faqAccordion<?= $doctor['id'] ?>">
                    <div class="accordion-body text-muted">
                      <?= $faq['answer'] ?>
                    </div>
                  </div>
                </div>
              <?php }
            }

            if (!$hasFaq) {
              echo '<div class="text-muted">سوالی ثبت نشده است.</div>';
            }
            ?>
          </div>
        </div>
      <?php } ?>


    </div>

    <div class="col-md-7 mb-5">

      <div class="doctor-card text-end" id="doctor-detail">
        <div>
          <h5 class="text-bold mb-4"><i class="far fa-hospital ms-2"></i> نوبت‌دهی اینترنتی مطب دکتر <span
              class="doc-name" style="line-height: 2;">...</span> </h5>
          <div class="clinic-card border border-primary rounded-3 p-3 mb-3 text-end btn-book" id="btn-book">
            <div class="fw-bold mb-2"> <span class="doc-clinic"></span></div>
            <div class="mb-2 text-muted">
              <i class="fas fa-map-marker-alt ms-2"></i>
              آدرس: <span class="doc-location"></span>
            </div>
            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3 flex-wrap">
              <div class="text-primary small" id="nextAppointmentInfo">
                <div class="text-primary small">
                  <i class="far fa-calendar-alt ms-1"></i>
                  <span class="text-primary">اولین نوبت آزاد: </span>
                  <span class="text-success fw-bold" id="reserve-info" style="direction: rtl; display: inline-block;">
                  </span>
                </div>
              </div>
              <a class="btn btn-primary px-3 mt-2 mt-sm-0">
                نوبت بگیرید
                <i class="fas fa-arrow-left me-2"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="doctor-card text-end">
        <h6 class="text-bold mb-3"><i class="fa-regular fa-circle-question mx-2"></i> اطلاعات مطب دکتر <span
            class="doc-name" style="line-height: 2;"></span></h6>
        <p><strong><i class="fas fa-cut mx-2 fs-6 text-warning"></i>تخصص:</strong> <span class="doc-expert"></span>
        </p>
        <p><strong><i class="fas fa-map-marker-alt mx-2 fs-6 text-success"></i>آدرس:</strong> <span
            class="doc-location"></span> </p>
        <p><strong><i class="fa-solid fa-phone mx-2 fs-6 text-info"></i>تلفن مطب:</strong> <span id="doc-phone"></span>
        </p>
        <p><strong><i class="fas fa-check-circle text-primary mx-2 fs-6"></i>کد نظام پزشکی:</strong> <span
            id="doc-number"></span></p>
        <p><strong><i class="fa-solid fa-calendar-minus mx-2 fs-6 text-muted"></i>سال شروع فعالیت:</strong> <span
            id="doc-experience"> </span></p>
        <hr class="my-3">
        <div class="row text-center small">
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

      </div>
      <div class="doctor-card text-end">
        <h6 class="fw-bold mb-3">خدمات دکتر <span class="doc-name" style="line-height: 2;"></span></h6>
        <div class="d-flex flex-wrap gap-2">
          <span class="doc-services"></span>
        </div>
      </div>

      <?php
      foreach ($doctors as $key => $doctor) { ?>
        <?php
        $faqs = $db->select("SELECT * FROM faq WHERE doctor_id = ?", [$doctor['id']])->fetchAll();
        if (count($faqs) >= 1) { ?>
          <div class="doctor-card text-end d-block d-md-none">
            <h6 class="fw-bold mb-4">سوالات متداول راجع به دکتر <?= $doctor['name'] ?></h6>
            <div class="accordion" id="faqAccordion">
              <?php foreach ($faqs as $faq):
                if ($faq['doctor_id'] == $doctor['id']) {
                  $hasFaq = true;
                  $faqIndex = rand(); ?>
                  <div class="accordion-item border mb-2 rounded">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed text-end rounded" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq<?= $faqIndex ?>">
                        <?= htmlspecialchars($faq['ask']) ?>
                      </button>
                    </h2>
                    <div id="faq<?= $faqIndex ?>" class="accordion-collapse collapse rounded" data-bs-parent="#faqAccordion">
                      <div class="accordion-body text-muted">
                        <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                      </div>
                    </div>
                  </div>
                <?php }endforeach; ?>
            </div>
          </div>
        <?php }
      } ?>


    </div>
  </div>
</main>

<?php
require_once BASE_PATH . '/template/app/layouts/modals.php';
require_once BASE_PATH . '/template/app/layouts/footer.php';
?>