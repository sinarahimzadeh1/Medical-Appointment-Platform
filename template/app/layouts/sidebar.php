<div class="col-lg-4 mt-4 mt-lg-0">
  <aside class="sidebars-area position-sticky" style="top: 90px;">

    <?php if (isset($topSelectedPosts[0])): ?>
      <div class="card mb-4 shadow-sm rounded-3 overflow-hidden h-100">
        <a href="<?= url('show-post/' . $topSelectedPosts[0]['id']) ?>">
          <img src="<?= asset($topSelectedPosts[0]['image']) ?>" class="lazy-img w-100 object-fit-cover"
            style="height: 220px;" alt="">
        </a>
        <div class="card-body">
          <a class="text-white fs-7 px-3 py-1 rounded-pill bg-primary d-inline-block mb-2"
            href="<?= url('show-category/' . $topSelectedPosts[0]['cat_id']) ?>">
            <?= $topSelectedPosts[0]['category'] ?>
          </a>
          <a href="<?= url('show-post/' . $topSelectedPosts[0]['id']) ?>"
            class="text-white fs-7 px-3 py-1 rounded-pill bg-success d-inline-block mb-2">
            <?= $topSelectedPosts[0]['title'] ?>
          </a>
          <ul class="list-inline text-muted small m-0 py-1 mt-2">
            <li class="list-inline-item"><i class="fa fa-user mx-2"></i><?= $topSelectedPosts[0]['username'] ?></li>
            <li class="list-inline-item"><i class="fa fa-calendar mx-2"></i><?= $topSelectedPosts[0]['published_at'] ?>
            </li>
            <li class="list-inline-item"><i class="fa fa-comments mx-2"></i><?= $topSelectedPosts[0]['comments_count'] ?>
            </li>
          </ul>
        </div>
      </div>
    <?php endif; ?>

    <style>
      .sidebar-banner-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
      }
    </style>
    <?php if (!empty($bodyBanner)):
      foreach ($bodyBanner as $banner):
        if (!preg_match('/^https?:\/\//', $banner['url'])) {
          $banner['url'] = 'https://' . $banner['url'];
        } ?>
        <div class="ad-widget-wrap my-4 text-center">
          <a href="<?= $banner['url'] ?>" target="_blank" class="d-block w-100">
            <img src="<?= asset($banner['image']) ?>" alt="sidebar advertisement" loading="lazy"
              class="sidebar-banner-img img-fluid rounded shadow-sm">
          </a>
        </div>
      <?php endforeach;
    endif; ?>


    <div class="card shadow-sm rounded-3 mb-5">
      <div class="card-header bg-primary text-white">
        <h6 class="mb-0">محبوب‌ترین‌ها</h6>
      </div>
      <ul class="list-group list-group-flush pe-0">
        <?php foreach ($mostLikedPosts as $mostLikedPost): ?>
          <li class="list-group-item d-flex">
            <img src="<?= asset($mostLikedPost['image']) ?>" alt="" class="lazy-img rounded ms-3 object-fit-cover"
              width="80" height="60">
            <div class="flex-grow-1">
              <a href="<?= url('show-post/' . $mostLikedPost['id']) ?>" class="text-dark fw-bold d-block mb-1">
                <?= $mostLikedPost['title'] ?>
              </a>
              <small class="text-muted d-block"><i
                  class="fa fa-calendar mx-1 text-primary"></i><?= $mostLikedPost['published_at'] ?></small>
              <small class="text-muted"><i
                  class="fa fa-heart mx-1 text-danger"></i><?= $mostLikedPost['rating'] ?></small>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

  </aside>
</div>