<?php
require_once BASE_PATH . '/template/app/layouts/header.php';
?>


<div class="site-main-container">
  <section class="top-post-area pt-10">
    <div class="container no-padding">
      <div class="row">
        <div class="col-12">
          <div class="page-title-container">
            <h1 class="page-title">پست های دسته بندی <?= $category['name'] ?></h1>
            <div class="title-underline"></div>
          </div>
        </div>

        <?php if (!empty($breakingNews)): ?>
          <div class="col-12">
            <div class="news-tracker-wrap bg-danger text-white p-2 rounded text-center">
              <h6 class="mb-0 py-1">
                <span>مطلب مهم : </span>
                <a href="<?= url('show-post/' . $breakingNews['id']) ?>"
                  class="text-white fw-bold text-decoration-underline">
                  <?= $breakingNews['title'] ?>
                </a>
              </h6>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="latest-post-area pb-120">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="latest-post-wrap">
            <h4 class="cat-title mb-4 fw-bold"> پست های اخیر <?= $category['name'] ?> <i
                class="fa fa-angle-left fs-6"></i></h4>
            <?php foreach ($categoryPosts as $post): ?>

              <div
                class="single-latest-post mx-2 row mb-4 p-3 rounded-4 shadow-sm bg-white post-card align-items-center border border-light-subtle"
                style="transition: all 0.3s ease; min-height: 170px; box-shadow: 0 8px 16px rgba(0,0,0,0.06);">
                <div class="col-md-5">
                  <div class="feature-img position-relative overflow-hidden rounded-4" style="height: 130px;">
                    <a href="<?= url('show-post/' . $post['id']) ?>"><img
                        class="lazy-img img-fluid w-100 h-100 rounded-4 post-image" src="<?= asset($post['image']) ?>"
                        alt="" style="object-fit: cover; transition: transform 0.4s ease;"></a>
                    <ul
                      class="tags position-absolute top-0 start-0 bg-gradient bg-primary text-white px-3 py-1 rounded-end shadow-sm small"
                      style="font-size: 0.8rem;">
                      <li><?= $post['category'] ?></li>
                    </ul>
                  </div>
                </div>
                <div class="col-md-7 my-3">
                  <a href="<?= url('show-post/' . $post['id']) ?>" class="text-decoration-none text-dark hover-opacity">
                    <h5 class="fw-bold mb-2"><?= $post['title'] ?></h5>
                  </a>
                  <ul class="meta list-unstyled text-muted d-flex flex-wrap gap-3 small pe-0">
                    <li class="d-flex align-items-center"><i
                        class="fa fa-user me-1 text-primary px-2"></i><?= $post['username'] ?></li>
                    <li class="d-flex align-items-center"><i
                        class="fa fa-calendar me-1 text-primary px-2"></i><?= jalaliData($post['created_at']) ?></li>
                    <li class="d-flex align-items-center"><i
                        class="fa fa-comment me-1 text-primary px-2"></i><?= $post['comments_count'] ?> دیدگاه</li>
                  </ul>
                </div>
              </div>


            <?php endforeach; ?>
          </div>

          <?php if (!empty($bodyBanner)): ?>
            <?php foreach ($bodyBanner as $banner): ?>
              <?php
              $url = $banner['url'] ?? '';
              if (!preg_match('/^https?:\/\//', $url)) {
                $url = 'https://' . $url;
              }
              ?>
              <div class="ad-widget-wrap my-4">
                <a href="<?= htmlspecialchars($url) ?>" target="_blank">
                  <img class="lazy-img img-fluid rounded shadow-sm" style="height: 300px; width: 100%; object-fit: cover;" src="<?= asset($banner['image']) ?>" alt="">
                </a>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>


          <div class="popular-post-wrap">
            <h4 class="cat-title mb-3 mt-5 fw-bold"> پر بازدید ترین پست ها <i class="fa fa-angle-left fs-6"></i></h4>

            <?php if (isset($popularPosts[0])): ?>
              <div class="feature-post  my-3 bg-white p-3 rounded-4 shadow-sm">
                <div class="feature-img position-relative overflow-hidden rounded-3" style="width: 100%; height: 250px;">
                  <a href="<?= url('show-post/' . $popularPosts[0]['id']) ?>"><img
                      class="lazy-img img-fluid w-100 h-100 rounded-3" src="<?= asset($popularPosts[0]['image']) ?>"
                      alt="" style="object-fit: cover; transition: transform 0.4s ease;"></a>
                  <ul
                    class="tags position-absolute top-0 start-0 bg-primary text-white px-3 py-1 rounded-end small shadow-sm">
                    <li><?= $popularPosts[0]['category'] ?></li>
                  </ul>
                </div>

                <div class="details mt-3">
                  <a href="<?= url('show-post/' . $popularPosts[0]['id']) ?>" class="text-decoration-none text-dark">
                    <h3 class="fw-bold hover-opacity"><?= $popularPosts[0]['title'] ?></h3>
                  </a>
                  <ul class="meta list-unstyled small text-muted d-flex flex-wrap gap-3 mt-2 pe-0">
                    <li><i class="fa fa-user mx-1 text-primary"></i> <?= $popularPosts[0]['username'] ?></li>
                    <li><i class="fa fa-calendar mx-1 text-primary"></i> <?= $popularPosts[0]['published_at'] ?></li>
                    <li><i class="fa fa-eye mx-1 text-primary"></i> <?= $popularPosts[0]['view'] ?></li>
                    <li><i class="fa fa-heart mx-1 text-danger"></i> <?= $popularPosts[0]['comments_count'] ?></li>
                  </ul>
                </div>
              </div>
            <?php endif; ?>

            <div class="row">
              <?php for ($i = 1; $i <= 2; $i++):
                if (isset($popularPosts[$i])): ?>
                  <div class="col-md-6 mb-4">
                    <div class="single-popular-post bg-light p-3 bg-white rounded-4 shadow-sm h-100 d-flex flex-column">
                      <div class="feature-img position-relative overflow-hidden rounded-3" style="height: 180px;">
                        <a href="<?= url('show-post/' . $popularPosts[$i]['id']) ?>"><img
                            class="lazy-img img-fluid w-100 h-100 rounded-3" src="<?= asset($popularPosts[$i]['image']) ?>"
                            alt="" style="object-fit: cover; transition: transform 0.3s ease;"></a>
                        <ul
                          class="tags position-absolute top-0 start-0 bg-primary text-white px-2 py-1 rounded-end small shadow-sm">
                          <li><?= $popularPosts[$i]['category'] ?></li>
                        </ul>
                      </div>
                      <div class="details mt-3 flex-grow-1">
                        <a href="<?= url('show-post/' . $popularPosts[$i]['id']) ?>" class="text-decoration-none text-dark">
                          <h5 class="fw-bold"><?= $popularPosts[$i]['title'] ?></h5>
                        </a>
                        <ul class="meta list-unstyled small text-muted d-flex flex-wrap gap-3 mt-2 pe-0">
                          <li><i class="fa fa-user mx-1 text-primary"></i> <?= $popularPosts[$i]['username'] ?></li>
                          <li><i class="fa fa-calendar mx-1 text-primary"></i> <?= $popularPosts[$i]['published_at'] ?>
                          </li>
                          <li><i class="fa fa-eye mx-1 text-primary"></i> <?= $popularPosts[$i]['view'] ?></li>
                          <li><i class="fa fa-heart mx-0 text-danger"></i> <?= $popularPosts[$i]['rating'] ?></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                <?php endif;
              endfor; ?>
            </div>

          </div>
        </div>

        <?php require_once BASE_PATH . '/template/app/layouts/sidebar.php'; ?>
      </div>
    </div>
  </section>
</div>


<?php
require_once BASE_PATH . '/template/app/layouts/footer.php';
?>