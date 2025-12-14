<?php require_once BASE_PATH . '/template/app/layouts/header.php' ?>

<div class="intro-blog" style="background: url('<?= asset("public/images/bg.avif") ?>'); background-attachment: fixed;">
  <div class="overlay"></div>
  <div class="intro-content">
    <div class="intro-text intro-text-blog">
      <div class="page-title-container">
        <h1 class="page-title mt-5 text-white">لبخندی زیباتر، زندگی شادتر</h1>
        <div class="title-underline"></div>
      </div>
      <p class="text-justify">در کلینیک تخصصی دندان‌پزشکی ما، سلامت دهان و زیبایی لبخند شما در اولویت است. با
        بهره‌گیری
        از جدیدترین روش‌ها و تکنولوژی‌های روز دنیا، بهترین خدمات درمانی، زیبایی و پیشگیری را به شما ارائه می‌دهیم. ما
        اینجا هستیم تا لبخندتان بدرخشد!</p>
    </div>
    <div class="intro-post">
      <a href="<?= url('show-post/' . $lastPost['id']) ?>"><img loading="lazy" src="<?= $lastPost['image'] ?>"
          alt="تصویر پست" class="post-image lazy-img"></a>
      <div class="post-info text-center">

        <div style="justify-content: space-evenly"
          class="d-flex align-items-center flex-wrap flex-lg-nowrap py-3 post-header">
          <a href="<?= url('show-post/' . $lastPost['id']) ?>" class="order-0 order-lg-1 m-10">
            <h2 class="m-0 res-font post-title"><?= $lastPost["title"] ?></h2>
          </a>

          <ul class="list-inline m-0 mb-2 mb-lg-0 order-1 order-lg-0 post-meta">
            <li class="list-inline-item post-category">
              <a href="<?= url('show-category/' . $topSelectedPosts[0]['cat_id']) ?>" class="text-muted fw-bold">
                <i class="fa fa-star"></i> <?= $topSelectedPosts[0]['category'] ?>
              </a>
            </li>
            <li class="list-inline-item mx-2">
              <i class="fa fa-calendar"></i> <?= str_replace('-', '/', $topSelectedPosts[0]['published_at']) ?>
            </li>
          </ul>
        </div>


        <p class="pb-1">
          <?php
          $text = $lastPost["summary"];
          $maxLength = 70;

          if (mb_strlen($text, 'UTF-8') > $maxLength) {
            echo mb_substr($text, 0, $maxLength, 'UTF-8') . '... <a href="#"></a>';
          } else {
            echo $text;
          }
          ?>
        </p>

        <a href="<?= url('show-post/' . $lastPost['id']) ?>" class="read-more w-100 mt-2"><span>مطالعه
            بیشتر</span></a>

      </div>
    </div>
  </div>
</div>

<?php if ($topSelectedPosts[0] != null) { ?>
  <section class="top-post-area pb-1">
    <div class="container">
      <div class="row">
        <div class="page-title-container">
          <h1 class="page-title">پست های مهم <?= $setting['title'] ?></h1>
          <div class="title-underline"></div>
        </div>

        <section class="intro-h-600px">
          <section class="intro-row intro-h-2-3 mb-10x">
            <section class="intro-2-3-col intro-h-100 position-relative h-md-300px"
              style="<?= count($topSelectedPosts) > 1 ? '' : 'width: 100%;' ?>">
              <img src="<?= $topSelectedPosts[0]['image'] ?>" class="lazy-img img-bg w-100 bg-1 intro-h-100 shadow-lg">
              <a href="#">
                <section class="intro-item-caption">
                  <h3 class="caption-title">
                    <a href="<?= url('show-post/' . $topSelectedPosts[0]['id']) ?>"
                      class="btn btn-success mx-4 my-3 res-font-2">
                      <?= $topSelectedPosts[0]['title'] ?>
                    </a>
                  </h3>
                  <ul class="caption-info-bar">
                    <li class="post-category">
                      <a href="<?= url('show-category/' . $topSelectedPosts[0]['cat_id']) ?>" class="text-muted fw-bold">
                        <i class="fa fa-star"></i> <?= $topSelectedPosts[0]['category'] ?>
                      </a>
                    </li>
                    <li><i class="fa fa-calendar"></i> <?= str_replace('-', '/', $topSelectedPosts[0]['published_at']) ?>
                    </li>
                    <li><i class="fas fa-eye text-yellow"></i> <?= $topSelectedPosts[0]['view'] ?></li>
                    <li><i class="fas fa-comment text-yellow"></i> <?= $topSelectedPosts[0]['comments_count'] ?></li>
                  </ul>
                </section>
              </a>
            </section>
            <section class="intro-1-3-col intro-h-100">
              <?php
              $topTwoPosts = array_slice($topSelectedPosts, 0, 3);
              for ($i = 1; $i < count($topTwoPosts); $i++) { ?>
                <section class="intro-1-3-item intro-h-50 position-relative h-md-300px">
                  <img src="<?= $topSelectedPosts[$i]['image'] ?>" class="lazy-img img-bg w-100 bg-1 intro-h-100 shadow-lg">
                  <section class="intro-item-caption">
                    <a href="/assets/Ohter Pages/Menu pages/News/news-2/irans_digital_currency_gains_traction.php">
                      <h3 class="caption-title">
                        <a href="<?= url('show-post/' . $topSelectedPosts[$i]['id']) ?>" class="btn btn-success mx-3 my-1">
                          <?= $topSelectedPosts[$i]['title'] ?>
                        </a>
                      </h3>
                    </a>
                    <ul class="caption-info-bar">
                      <li class="post-category">
                        <a href="<?= url('show-category/' . $topSelectedPosts[0]['cat_id']) ?>" class="text-muted fw-bold">
                          <i class="fa fa-star"></i> <?= $topSelectedPosts[0]['category'] ?>
                        </a>
                      </li>
                      <li><i class="fa fa-calendar"></i> <?= str_replace('-', '/', $topSelectedPosts[$i]['published_at']) ?>
                      </li>
                      <li><i class="fas fa-eye text-yellow"></i> <?= $topSelectedPosts[$i]['view'] ?></li>
                      <li><i class="fas fa-comment text-yellow"></i> <?= $topSelectedPosts[$i]['comments_count'] ?></li>
                    </ul>
                  </section>
                </section>
              <?php } ?>
            </section>
          </section>
        </section>


        <?php if (!empty($breakingNews)) { ?>
          <div class="col-12 breaking-news">
            <div class="breaking-news-banner">
              <span class="breaking-icon">●</span>
              <strong class="breaking-label">مطلب مهم : </strong>
              <a href="<?= url('show-post/' . $breakingNews['id']) ?>" class="breaking-link">
                <?= $breakingNews['title'] ?>
              </a>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </section>
<?php } ?>

<style>
  .banner-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
  }
</style>
<?php if (!empty($bodyBanner)) { ?>
  <div class="container mt-4">
    <div class="row g-3 justify-content-center">
      <?php
      $count = count($bodyBanner);
      foreach ($bodyBanner as $banner) {
        if (!preg_match('/^https?:\/\//', $banner['url'])) {
          $banner['url'] = 'https://' . $banner['url'];
        }

        // ستون‌ها بسته به تعداد بنر
        if ($count === 1) {
          $colClass = "col-12";
        } elseif ($count === 2) {
          $colClass = "col-12 col-md-6";
        } elseif ($count === 3) {
          $colClass = "col-12 col-md-4";
        } else {
          $colClass = "col-12 col-md-3";
        }
        ?>

        <div class="<?= $colClass ?> text-center">
          <a href="<?= $banner['url'] ?>" target="_blank" class="d-block w-100">
            <img loading="lazy" src="<?= asset($banner['image']) ?>" alt="advertisement"
              class="banner-img rounded shadow-sm">
          </a>
        </div>

      <?php } ?>
    </div>
  </div>
<?php } ?>



<div class="container">
  <!-- 1 -->
  <div class="page-title-container mb-1">
    <h1 class="page-title text-end">دیگر پست ها <i class="fa fa-angle-left fs-6"></i></h1>
  </div>
  <div class="swiper swiper-blog mySwiper2 mb-5">
    <div class="swiper-wrapper">
      <?php if (!empty($posts)) { ?>
        <?php foreach ($posts as $key => $post) { ?>
          <a href="<?= url('show-post/' . $post['id']) ?>">
            <div class="swiper-slide blog-swiper-slide uniform-card">
              <img loading="lazy" src="<?= $post['image'] ?>" alt="<?= $post['title'] ?>" class="lazy-img card-img-top"
                style="height: 180px; object-fit: cover; border-radius: 17px;">
              <div class="card-body p-3 text-center">
                <h6 class="fw-bold mt-3 mb-2"><?= $post['title'] ?></h6>
                <p class="text-muted small mb-3">
                  <?php
                  $text = trim($post['summary']);
                  $maxLength = 90;
                  if (mb_strlen($text, 'UTF-8') > $maxLength) {
                    $text = mb_substr($text, 0, $maxLength, 'UTF-8') . '...';
                  }
                  $cleaned = strip_tags(htmlspecialchars($text), '<p>');
                  echo $cleaned;
                  ?>
                </p>
                <a href="<?= url('show-post/' . $post['id']) ?>"
                  class="btn btn-sm btn-primary text-white rounded-pill px-4">
                  مشاهده پست
                </a>
              </div>
            </div>
          </a>
        <?php } ?>
      <?php } else { ?>
        <h1 class="page-title text-end my-2">● هنوز پستی گذاشته نشده است ● </h1>
      <?php } ?>
    </div>
    <div class="swiper-button-next swiper-next-posts"></div>
    <div class="swiper-button-prev swiper-prev-posts"></div>
    <div class="swiper-pagination"></div>
  </div>


  <!-- 2 -->
  <div class="page-title-container mb-1">
    <h1 class="page-title text-end">
      پست‌های مربوط به

      <select id="category-select" class="form-select d-inline w-auto">
        <?php if (!empty($categories)): ?>
          <?php
          $firstCategory = $categories[0];
          $otherCategories = array_slice($categories, 1);

          function safeVal($array, $key, $default = '')
          {
            return isset($array[$key]) && $array[$key] !== null ? $array[$key] : $default;
          }
          ?>
          <option value="<?= htmlspecialchars(safeVal($firstCategory, 'id')) ?>" selected>
            <?= htmlspecialchars(safeVal($firstCategory, 'name', 'نام دسته‌بندی نامشخص')) ?>
          </option>

          <?php foreach ($otherCategories as $category): ?>
            <option value="<?= htmlspecialchars(safeVal($category, 'id')) ?>">
              <?= htmlspecialchars(safeVal($category, 'name', 'نام دسته‌بندی نامشخص')) ?>
            </option>
          <?php endforeach; ?>
        <?php else: ?>
          <option disabled selected>دسته‌بندی‌ای یافت نشد</option>
        <?php endif; ?>
      </select>

      <i class="fa fa-angle-left fs-6"></i>
    </h1>
  </div>

  <div class="swiper swiper-blog mySwiper1 mb-5">
    <div class="swiper-wrapper" id="post-container">
    </div>

    <div class="swiper-button-next swiper-next-posts"></div>
    <div class="swiper-button-prev swiper-prev-posts"></div>
    <div class="swiper-pagination"></div>
  </div>

</div>


<div class="container my-5 text-center">
  <a href="<?= url('home/all-posts') ?>" class="fancy-btn">
    <i class="fas fa-eye"></i> مشاهده همه پست‌ها
  </a>
</div>


<div class="sweet mt-5">
  <div class="overlay">
    <div class="sweet-cards">
      <div class="sweet-card">
        <i class="fas fa-heart"></i>
        <p>مهارت</p>
      </div>

      <div class="sweet-card">
        <i class="fas fa-star"></i>
        <p>محبوبیت</p>
      </div>

      <div class="sweet-card">
        <i class="fas fa-leaf"></i>
        <p>تجربه</p>
      </div>

      <div class="sweet-card">
        <i class="fas fa-magic"></i>
        <p>تخصص</p>
      </div>
    </div>
  </div>
  <img src="" alt="" style="background-image: url('<?= asset('public/images/bg.avif') ?>');" class="sweet-sec-blog">
</div>


<div class="openions py-5" id="openions">
  <div class="container">

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="page-title-container">
          <h1 class="page-title">نظرات منتخب</h1>
          <div class="title-underline"></div>
        </div>
      </div>
    </div>

    <?php if (count($comments) != 0) { ?>
      <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <?php foreach ($comments as $index => $comment) { ?>
                <button class="bg-success <?php echo $index === 0 ? 'active' : ''; ?>" type="button"
                  data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $index; ?>"
                  aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                  aria-label="Slide <?php echo $index + 1; ?>"></button>
              <?php } ?>
            </div>
            <div class="carousel-inner">
              <?php foreach ($comments as $index => $comment) { ?>
                <div
                  class="op-item carousel-item <?php echo $index === 0 ? 'active' : ''; ?> bg-white rounded-3 shadow-sm p-4 mb-5">
                  <div class="some-info d-flex align-items-center">
                    <div class="author me-3">
                      <h3 class="fs-6 mb-1 fw-bold"><i
                          class="fa fa-user ms-3"></i><?= $comment['user_username'] ?? $comment['doctor_name']; ?>
                      </h3>
                      <a href="<?= url('show-post/' . $comment['post_id']) ?>" class="text-muted fw-bold">
                        <i class="fa fa-window-restore ms-3"></i><?php echo $comment['post_title']; ?>
                      </a>
                    </div>
                  </div>
                  <div class="mb-3">
                    <i class="fa fa-message ms-3 me-3"></i><?= $comment['comment'] ?>
                  </div>
                  <div class="rating text-success">
                    <?php
                    $rating = $comment['user_rating'];
                    if ($rating !== null) { ?>
                      <div class="post-category mx-1">

                        <?php for ($i = 1; $i <= $rating; $i++) {
                          echo '<i class="fas fa-star text-muted"></i>';
                        } ?>

                      </div>
                    <?php }
                    ?>
                    <span class="post-category-muted text-white fw-bold">
                      <i class="fa fa-calendar-alt mx-2"></i><?= jalaliData($comment['created_at']) ?>
                    </span>
                    <a href="<?= url('show-category/' . $comment['cat_id']) ?>"
                      class="mx-1 fw-bold text-muted post-category">
                      <?= $comment['category'] ?>
                    </a>
                  </div>
                </div>
              <?php } ?>
            </div>

          </div>

        </div>
      </div>

    <?php } else { ?>
      <h2 class="fw-bold mb-5 text-center"><i class="fa fa-circle fs-6 bounce-circle"></i>&nbsp; نظری ثبت نشده</h2>
    <?php } ?>

  </div>
</div>


<?php
require_once BASE_PATH . '/template/app/layouts/footer.php';
?>