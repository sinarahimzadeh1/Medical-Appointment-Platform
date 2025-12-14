<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';

$limit = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

$total_result = $db->select("SELECT COUNT(*) as total FROM posts WHERE user_id = ?", [$this->adminEnteredID])->fetch();
$total_rows = $total_result['total'];
$total_pages = ceil($total_rows / $limit);

if ($page < 1)
  $page = 1;
if ($page > $total_pages && $total_pages > 0)
  $page = $total_pages;

$offset = ($page - 1) * $limit;

$posts = $db->select("SELECT posts.*, categories.name AS category_name, users.number AS number, doctors.name AS name, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comment_count FROM posts LEFT JOIN categories ON posts.cat_id = categories.id LEFT JOIN users ON posts.user_id = users.id LEFT JOIN doctors ON posts.user_id = doctors.id WHERE user_id = ? ORDER BY posts.id DESC LIMIT $limit OFFSET $offset ", [$this->adminEnteredID])->fetchAll();

?>

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">پست ها</h4>
              <a role="button" style="float: left;" href="<?= url('admin/post/create') ?>"
                class="btn btn-sm btn-success">ساختن <i class="fa-solid fa-pencil"></i></a>
            </div>
            <div class="box-body table-responsive">

              <div class="table-responsive">
                <table class="table table-hover align-middle border rounded" style="overflow: hidden;">
                  <caption class="fw-bold">لیست پست ها</caption>
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center border">عنوان</th>
                      <th class="text-center border">نویسنده</th>
                      <th class="text-center border">خلاصه</th>
                      <th class="text-center border">تاریخ انتشار</th>
                      <th class="text-center border">تعداد بازدید ها</th>
                      <th class="text-center border">تعداد کامنت ها</th>
                      <th class="text-center border">وضعیت</th>
                      <th class="text-center border">دسته بندی</th>
                      <th class="text-center border" style="width: 160px;">عکس</th>
                      <th class="text-center border">تنظیمات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($posts as $post) { ?>
                      <tr class="border-bottom">
                        <td class="border fw-semibold text-center"><a
                            href="<?= url('/show-post/' . $post['id']) ?>" class="text-white px-3 py-1 rounded-1 bg-primary d-inline-block"><?= htmlspecialchars($post['title']) ?></a>
                        </td>
                        <td class="border fw-semibold"><?= $post['name'] ?></td>
                        <td class="border"><?php
                        $text = trim($post['summary']);
                        $maxLength = 100;
                        if (mb_strlen($text, 'UTF-8') > $maxLength) {
                          $text = mb_substr($text, 0, $maxLength, 'UTF-8') . '...';
                        }
                        echo htmlspecialchars($text);
                        ?></td>
                        <td class="border text-center"><span class="badge bg-dark"><?= $post['published_at'] ?></span></td>
                        <td class="border text-center"><span class="badge bg-info"><?= $post['view'] ?></span></td>
                        <td class="border text-center"><span class="badge bg-dark"><?= $post['comment_count'] ?></span>
                        </td>
                        <td class="border text-center">
                          <?= $post['breaking_news'] == 1 ? '<span class="badge bg-danger mx-1 my-1">خبر فوری</span>' : '' ?>
                          <?= $post['selected'] == 1 ? '<span class="badge bg-secondary mx-1 my-1">انتخاب شده</span>' : '' ?>
                        </td>
                        <td class="border">
                          <a href="<?= url('/show-category/'.$post['cat_id']  ) ?>" class="text-white px-3 py-1 rounded-1 bg-info d-inline-block"><i class="bi bi-folder-fill me-1 text-warning"></i><?= $post['category_name'] ?></a>
                        </td>
                        <td class="border">
                          <a href="<?= url('/show-post/' . $post['id']) ?>">
                            <img src="<?= asset($post['image']) ?>" alt="Image" class="img-thumbnail"
                              style="width: 100%;">
                          </a>
                        </td>
                        <td class="border text-center" style="min-width: 230px;">

                          <div class="d-flex flex-wrap gap-1 justify-content-center">
                            <a class="btn btn-sm btn-warning text-white d-flex align-items-center gap-1"
                              href="<?= url('admin/post/breaking-news/' . $post['id']) ?>">
                              <i class="bi bi-broadcast-pin"></i>
                              <?= $post['breaking_news'] == 1 ? 'حذف خبر فوری' : 'خبر فوری' ?>
                            </a>

                            <a class="btn btn-sm btn-warning text-white d-flex align-items-center gap-1"
                              href="<?= url('admin/post/selected/' . $post['id']) ?>">
                              <i class="bi bi-star"></i>
                              <?= $post['selected'] == 1 ? 'حذف منتخب' : 'منتخب' ?>
                            </a>

                            <a class="btn btn-sm btn-primary text-white d-flex align-items-center gap-1"
                              href="<?= url('admin/post/edit/' . $post['id']) ?>">
                              <i class="bi bi-pencil-square"></i> ویرایش <i class="fa fa-pencil"></i></a>

                            <a class="btn btn-sm btn-danger text-white d-flex align-items-center gap-1"
                              href="javascript:void(0);" onclick="confirmPostDelete(<?= $post['id'] ?>)"> حذف <i
                                class="fa fa-trash"></i></a>

                          </div>

                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<nav class="d-flex justify-content-center">
  <ul class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
      <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php } ?>
  </ul>
</nav>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>