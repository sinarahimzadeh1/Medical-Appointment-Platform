<?php

use BcMath\Number;

require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';
?>

<?php

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$total_result = $db->select("SELECT COUNT(*) as total FROM comments")->fetch();
$total_rows = $total_result['total'];
$total_pages = ceil($total_rows / $limit);

if ($page > $total_pages && $total_pages > 0) {
  $page = $total_pages;
  $offset = ($page - 1) * $limit;
}
if ($page < 1) {
  $page = 1;
  $offset = 0;
}


$comments = $db->select("SELECT comments.*, posts.title AS post_title, users.number AS number, doctors.name AS doc_name, doctors.number AS doc_num, users.username AS user_name  FROM comments  LEFT JOIN posts ON comments.post_id = posts.id  LEFT JOIN users ON comments.user_id = users.id  LEFT JOIN doctors ON comments.doctor_id = doctors.id  WHERE posts.user_id = ? ORDER BY comments.id DESC  LIMIT $limit OFFSET $offset", [$this->adminEnteredID])->fetchAll();
$unseenComments = $db->select('SELECT * FROM comments WHERE status = ?', ['unseen']);
foreach ($unseenComments as $comment) {
  $db->update('comments', $comment['id'], ['status'], ['seen']);
}
?>

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">

            <div class="box-header">
              <h4 class="box-title">کامنت ها</h4>
            </div>

            <div class="box-body">
              <section class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle">
                  <caption class="fw-bold">لیست کامنت‌ها</caption>
                  <thead class="table-light">
                    <tr>
                      <th class="text-center">نام</th>
                      <th class="text-center">شماره</th>
                      <th class="text-center">پست</th>
                      <th class="text-center">کامنت</th>
                      <th class="text-center">وضعیت</th>
                      <th class="text-center">تنظیمات</th>
                      <th class="text-center">پین</th>
                      <th class="text-center">حذف کامنت</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($comments as $comment) { ?>
                      <tr>
                        <td>
                          <?= $comment['user_name'] == '' ? '<i class="fa fa-star"></i> &nbsp;  ' . $comment['doc_name'] : $comment['user_name'] ?>
                        </td>
                        <td><?= $comment['number'] == '' ? $comment['doc_num'] : $comment['number'] ?></td>
                        <td class="text-truncate" style="max-width: 150px;"><?= $comment['post_title'] ?></td>
                        <td class="text-start" style="max-width: 300px;">
                          <div style="white-space: pre-wrap;"><?= $comment['comment'] ?></div>
                        </td>
                        <td>
                          <?php
                          switch ($comment['status']) {
                            case 'approved':
                              echo '<span class="btn btn-sm btn-success fs-6">تایید شده</span>';
                              break;
                            case 'seen':
                              echo '<span class="btn btn-sm btn-info fs-6">منتظر تایید</span>';
                              break;
                            case 'unseen':
                              echo '<span class="btn btn-sm btn-danger fs-6">تازه منتشر شده</span>';
                              break;
                            default:
                              echo 'نامشخص';
                              break;
                          }
                          switch ($comment['parent_id']) {
                            case !NULL:
                              echo '<span class="btn btn-sm btn-primary fs-6 mx-2">پاسخ</span>';
                              break;
                            case NULL:
                              break;
                            default:
                              echo '<span class="mx-2">نامشخص</span>';
                              break;
                          }
                          ?>
                        </td>
                        <td>
                          <?php if ($comment['status'] == 'seen') { ?>
                            <a role="button" class="btn btn-primary btn-sm text-white"
                              href="<?= url('admin/comment/change-status/' . $comment['id']) ?>">
                              تایید شود
                            </a>
                          <?php } elseif ($comment['status'] == 'approved') { ?>
                            <a role="button" class="btn btn-warning btn-sm text-white"
                              href="<?= url('admin/comment/change-status/' . $comment['id']) ?>">
                              حذف تایید
                            </a>
                          <?php } else { ?>
                            <a role="button" class="btn btn-dark btn-sm text-white"
                              href="<?= url('admin/comment/change-status/' . $comment['id']) ?>">
                              منتشر شده
                            </a>
                          <?php } ?>
                        </td>
                        <td>
                          <?php if ($comment['selected'] == 2) { ?>
                            <a role="button" class="btn btn-primary btn-sm text-white"
                              href="<?= url('admin/comment/pin-comment/' . $comment['id']) ?>">
                              پین شود
                            </a>
                          <?php } elseif ($comment['selected'] == 1) { ?>
                            <a role="button" class="btn btn-warning btn-sm text-white"
                              href="<?= url('admin/comment/pin-comment/' . $comment['id']) ?>">
                              حذف پین
                            </a>
                          <?php } ?>
                        </td>
                        <td>
                          <a role="button" class="btn btn-danger btn-sm text-white"
                            href="<?= url('admin/comment/delete-comment/' . $comment['id']) ?>">
                            حذف شود
                          </a>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </section>
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