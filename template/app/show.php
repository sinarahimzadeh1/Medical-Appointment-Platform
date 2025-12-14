<?php

$meta = [
  'title' => htmlspecialchars($post['title']),
  'description' => mb_substr(strip_tags($post['body']), 0, 160, 'UTF-8'),
  'image' => asset($post['image']),
  'url' => url('show/' . $post['id'])
];

require_once BASE_PATH . '/template/app/layouts/header.php';

if (!isset($_SESSION['viewed_posts'])) {
  $_SESSION['viewed_posts'] = [];
}

$post_id = $id;
$allViews = $db->select("SELECT view FROM posts WHERE id = ?", [$post_id])->fetch();

if (!in_array($post_id, $_SESSION['viewed_posts'])) {
  $db->update(tableName: 'posts', id: $post_id, fields: ['view'], values: [$allViews['view'] + 1]);
  $_SESSION['viewed_posts'][] = $post_id;
}
?>

<div class="site-main-container mt-5">
  <section class="latest-post-area pb-120">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 post-list">
          <div class="single-post-wrap card-2 shadow-sm rounded-3 overflow-hidden">
            <div class="feature-img-thumb position-relative">
              <img class="lazy-img img-fluid w-100" src="<?= asset($post['image']) ?>" alt="">
              <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0%;">
              </div>
            </div>
            <div class="content-wrap p-4">
              <h4 class="cat-title mb-4 fw-bold"> <?= $post['title'] ?></h4>
              <ul class="meta list-inline text-muted mb-4 px-0">
                <li class="my-1 list-inline-item post-category fw-bold"><i
                    class="fa fa-user mx-2"></i><?= $post['username'] ?></li>
                <li class="my-1 list-inline-item post-category fw-bold"><i
                    class="fa fa-calendar mx-2"></i><?= $post['published_at'] ?></li>
                <li class="my-1 list-inline-item post-category"><i
                    class="fa fa-comments mx-2"></i><?= $post['comments_count'] ?></li>
                <li class="my-1 list-inline-item post-category"><i class="fa fa-heart mx-2"></i><?= $post['rating'] ?>
                </li>
                <li class="my-1 list-inline-item post-category"><i class="fa fa-eye mx-2"></i><?= $viewPost['view'] ?>
                </li>
                <li class="my-1 list-inline-item post-category bg-primary mx-2">
                  <a class="text-white text-decoration-none"
                    href="<?= url('show-category/' . $post['cat_id']) ?>"><?= $post['category'] ?></a>
                </li>
              </ul>
              <div class="mb-4 text-justify" style="max-width: 100%; word-wrap: break-word; overflow-wrap: break-word;">
                <?= $post['body'] ?>
              </div>

              <?php
              $doctorFlag = null;
              $actived = ['is_active' => null];
              if (isset($_SESSION['number'])) {
                if ($userId = $db->select("SELECT id FROM users WHERE number = ?", [$_SESSION['number']])->fetch()) {
                  $userId = $userId['id'];
                  $actived = $db->select("SELECT is_active FROM users WHERE number = ?", [$_SESSION['number']])->fetch();
                } else {
                  $doctorFlag = 1;
                  $userId = $db->select("SELECT id FROM doctors WHERE number = ?", [$_SESSION['number']])->fetch();
                  $userId = $userId['id'];
                }

                $userRating = $db->select("SELECT post_ratings.rating FROM post_ratings WHERE post_id = ? AND user_id = ?", [$post['id'], $userId])->fetch();
                $ratingValue = $userRating ? $userRating['rating'] : 0;
                ?>
                <div class="star-rating mx-2" data-post-id="<?= $post['id'] ?>">
                  <?php if ($doctorFlag == 1 || $actived['is_active'] == 1) {
                    for ($i = 5; $i >= 1; $i--): ?>
                      <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>">
                      <label class="star- cursor-pointer" for="star<?= $i ?>">
                        <i class="fs-4 fa fa-heart"
                          style="<?= ($ratingValue >= $i) ? 'color: rgba(254, 33, 92, 0.975);' : '' ?>"></i>
                      </label>
                    <?php endfor;
                  } ?>
                </div>
              <?php } ?>

              <?php if ($doctorFlag == 1 || $actived['is_active'] == 1): ?>
                <div class="comment-form mt-4">
                  <h5>ثبت نظر جدید :</h5>
                  <form action="<?= url('comment-store/' . $post['id']) ?>" method="post">
                    <div class="mb-3">
                      <textarea class="form-control" rows="4" name="comment" placeholder="نظر خود را بنویسید..."
                        required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mb-5 w-50">ارسال</button>
                  </form>
                </div>
              <?php else:
                if ($actived['is_active'] == 0) { ?>
                  <div class="alert alert-danger mt-4">
                    لطفا ابتدا فرایند احراز هویت خود را تکمیل کنید
                  </div>
                <?php } elseif (!isset($_SESSION['number'])) { ?>
                  <div class="alert alert-danger mt-4">
                    برای ثبت نظر لطفا وارد حساب کاربری خود شوید.
                  </div>
                <?php }
              endif; ?>

              <?php if ($commentCount['comment_count'] != 0): ?>
                <h5 class="mb-3 fw-bold">
                  <i class="fa fa-comments mx-2"></i>نظرات کاربران
                  <i class="fa fa-angle-left fs-6 fw-bold"></i>
                </h5>

                <?php foreach ($comments as $comment): ?>
                  <div class="comment-list bg-light p-3 rounded mb-3 border">
                    <div class="d-flex align-items-center mb-2">
                      <i class="fa fa-user-circle fa-2x user-icon mx-2"></i>
                      <div>
                        <h6 class="mb-0"><?= $comment['username'] ?></h6>
                        <small class="text-muted"><?= jalaliData($comment['created_at']) ?></small>
                      </div>
                    </div>
                    <p class="mb-2" style="white-space: pre-line;"><?= htmlspecialchars($comment['comment']) ?></p>

                    <!-- نمایش پاسخ‌ها -->

                    <?php if (!empty($comment['replies'])): ?>
                      <div class="ms-5 mt-3">
                        <?php foreach ($comment['replies'] as $reply): ?>
                          <div class="bg-white border rounded p-2 mb-2">
                            <?php
                            $iconClass = !empty($reply['doctor_id']) ? 'text-success' : 'text-warning';
                            $doctorSymbol = !empty($reply['doctor_id']) ? '<i class="fa fa-star text-success fs-7 mx-2 mt-1"></i>' : '';
                            ?>
                            <div class="d-flex align-items-center mb-2">
                              <i class="fa fa-user-circle fa-2x <?= $iconClass ?> mx-2"></i>
                              <div>
                                <h6 class="mb-0"><?= $reply['username'] . $doctorSymbol ?></h6>
                                <small class="text-muted"><?= jalaliData($reply['created_at']) ?></small>
                              </div>
                            </div>

                            <p class="mb-2" style="white-space: pre-line;"><?= htmlspecialchars($reply['comment']) ?></p>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    <?php endif;

                    if ($doctorFlag == 1 || $actived['is_active'] == 1):
                      ?>
                      <!-- دکمه نمایش فرم -->
                      <button type="button" class="btn btn-sm btn-outline-primary w-25 mt-2 toggle-reply-btn"
                        data-id="<?= $comment['id'] ?>">
                        پاسخ
                      </button>

                      <!-- فرم پاسخ مخفی -->
                      <form method="post" action="<?= url("/reply/" . $post['id'] . '/' . $comment['id']) ?>"
                        class="mt-2 ms-5 reply-form" id="reply-form-<?= $comment['id'] ?>" style="display: none;">
                        <input type="hidden" name="parent_id" value="<?= $comment['id'] ?>">
                        <div class="input-group">
                          <textarea type="text" name="reply" class="form-control" rows="3"
                            placeholder="پاسخ خود را بنویسید..."></textarea>
                          <button class="btn btn-primary" type="submit">ارسال</button>
                        </div>
                      </form>
                    <?php else:
                      if ($actived['is_active'] == 0 || !isset($_SESSION['number'])) { ?>
                        <div class="">
                          <button type="button" class="btn btn-sm btn-danger w-25 mt-2" disabled>
                            برای پاسخ وارد شوید
                          </button>
                        </div>
                      <?php }
                    endif; ?>


                  </div>
                <?php endforeach; ?>
              <?php endif; ?>

              <!-- جاوااسکریپت برای مخفی/نمایان کردن فرم -->
              <script>
                document.addEventListener("DOMContentLoaded", function () {
                  document.querySelectorAll(".toggle-reply-btn").forEach(function (btn) {
                    btn.addEventListener("click", function () {
                      let form = document.getElementById("reply-form-" + btn.getAttribute("data-id"));
                      form.style.display = (form.style.display === "none" || form.style.display === "") ? "block" : "none";
                    });
                  });
                });
              </script>

              <nav class="d-flex justify-content-center">
                <ul class="pagination" style="direction: ltr;">
                  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                      <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                  <?php endfor; ?>
                </ul>
              </nav>

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