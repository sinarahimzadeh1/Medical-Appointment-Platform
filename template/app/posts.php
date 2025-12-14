<?php
require_once BASE_PATH . '/template/app/layouts/header.php';

$limit = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

$total_result = $db->select("SELECT COUNT(*) as total FROM posts")->fetch();
$total_rows = $total_result['total'];
$total_pages = ceil($total_rows / $limit);

if ($page < 1)
  $page = 1;
if ($page > $total_pages && $total_pages > 0)
  $page = $total_pages;

$offset = ($page - 1) * $limit;

$posts = $db->select("SELECT posts.*, categories.name AS category_name, users.number AS number, doctors.name AS name, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comment_count FROM posts LEFT JOIN categories ON posts.cat_id = categories.id LEFT JOIN users ON posts.user_id = users.id LEFT JOIN doctors ON posts.user_id = doctors.id ORDER BY posts.id DESC LIMIT $limit OFFSET $offset ")->fetchAll();
?>

<div class="site-main-container">
  <section class="latest-post-area pb-120 my-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row g-4">
            <?php foreach ($posts as $post): ?>
              <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm rounded-4 border-0">
                  <a href="<?= url('show-post/' . $post['id']) ?>">
                    <?php if (!empty($post['image'])): ?>
                      <img src="<?= asset($post['image']) ?>" class="lazy-img card-img-top rounded-top-4" alt="<?= $post['title'] ?>"
                        style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                  </a>
                  <div class="card-body d-flex flex-column">
                    <a href="<?= url('show-post/' . $post['id']) ?>">
                      <h5 class="card-title text-dark fw-bold text-truncate" title="<?= $post['title'] ?>">
                        <?= $post['title'] ?>
                      </h5>
                    </a>
                    <a href="<?= url('show-post/' . $post['id']) ?>">
                      <p class="card-text text-muted small mb-2 text-truncate">
                        <?= strip_tags(substr($post['body'], 0, 80)) ?>...
                      </p>
                    </a>
                    <div class="mt-auto">
                      <a class="badge bg-primary text-white"
                        href="<?= url('show-category/' . $post['cat_id']) ?>"><?= $post['category_name'] ?></a>
                      <div class="d-flex justify-content- align-items-center mt-3 text-muted small">
                        <div class="mx-2">
                          <i class="fas fa-user-edit me-1 text-primary mx-1"></i>
                          <strong><?= $post['name'] ?? $post['number'] ?></strong>
                        </div>
                        <div class="mx-2">
                          <i class="fas fa-heart me-1 text-danger mx-1"></i>
                          <?= $post['rating'] ?>
                        </div>
                        <div class="mx-2">
                          <i class="fas fa-comments me-1 text-success mx-1"></i>
                          <?= $post['comment_count'] ?>
                        </div>
                      </div>
                      <a href="<?= url('show-post/' . $post['id']) ?>"
                        class="btn btn-sm text-white fw-bold btn-primary mt-3 w-100 rounded-pill">
                        مشاهده بیشتر
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <?php if ($total_pages > 1): ?>
            <nav class="d-flex justify-content-center mt-5">
              <ul class="pagination pagination-sm">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link fs-5 mx-1 px-3 rounded-2" href="?page=<?= $i ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </section>
</div>

<?php
require_once BASE_PATH . '/template/app/layouts/footer.php';
?>