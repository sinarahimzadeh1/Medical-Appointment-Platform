<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$total_result = $db->select("SELECT COUNT(*) as total FROM users")->fetch();
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

$users = $db->select("SELECT users.*,  COUNT(reservedtimes.id) AS reserve_count FROM  users LEFT JOIN  reservedtimes ON users.id = reservedtimes.user_id GROUP BY  users.id ORDER BY  users.id DESC LIMIT  $limit OFFSET $offset; ");

?>

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">کاربران</h4>
            </div>
            <div class="box-body">
              <section class="table-responsive">
                <table class="table table-striped table-sm">
                  <caption>لیست کاربران</caption>
                  <thead>
                    <tr>
                      <th>نام کاربری</th>
                      <th>شماره</th>
                      <th>حساب ها</th>
                      <th>تعداد رزرو ها</th>
                      <th>دسترسی</th>
                      <th>زمان ثبت نام</th>
                      <th>تنظیمات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($users as $user) { ?>
                      <tr>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['number'] ?></td>
                        <td><?php
                        if ($user['is_active'] == 0) {
                          echo '<a class="btn btn-sm btn-danger" href="' . url('admin/user/changeActiveMode/' . $user['id']) . '">غیر فعال</a>';
                        } else {
                          echo '<a class="btn btn-sm btn-success" href="' . url('admin/user/changeActiveMode/' . $user['id']) . '">فعال</a>';
                        }
                        ?></td>
                        <td><?= $user['reserve_count'] ?></td>
                        <td>
                          <?php
                          if ($user['permission'] == "admin") {
                            echo '<a class="btn btn-sm btn-warning" href="' . url('admin/user/changePermission/' . $user['id']) . '">مدیر</a>';
                          } else {
                            echo '<a class="btn btn-sm btn-primary" href="' . url('admin/user/changePermission/' . $user['id']) . '">کاربر</a>';
                          }
                          ?>
                        </td>
                        <td><?= jalaliData($user['created_at']) ?></td>
                        <td>
                          <a role="button" class="btn btn-sm btn-primary text-white"
                            href="<?= url('admin/user/edit/' . $user['id']) ?>">ویرایش <i class="fa fa-edit"></i></a>
                          <a href="#" class="btn btn-sm btn-danger text-white"
                            onclick="confirmDelete(<?= $user['id'] ?>)">حذف کاربر <i class="fa fa-trash"></i></a>
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