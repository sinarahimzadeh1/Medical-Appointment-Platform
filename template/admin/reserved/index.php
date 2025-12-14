<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';
?>

<?php
$limit = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

$total_result = $db->select("SELECT COUNT(*) as total FROM reservedtimes WHERE doctor_id = ?", [$this->adminEnteredID])->fetch();
$total_rows = $total_result['total'];
$total_pages = ceil($total_rows / $limit);

if ($page < 1)
  $page = 1;
if ($page > $total_pages && $total_pages > 0)
  $page = $total_pages;

$offset = ($page - 1) * $limit;


$reserves = $db->select("SELECT reservedtimes.*, doctors.name AS doctor_name, users.number AS number, users.username AS user_name FROM reservedtimes LEFT JOIN doctors ON reservedtimes.doctor_id = doctors.id LEFT JOIN users ON reservedtimes.user_id = users.id WHERE doctor_id = ? ORDER BY reservedtimes.date DESC LIMIT $limit OFFSET $offset", [$this->adminEnteredID])->fetchAll();
function customFormat($input)
{
  return number_format((float) $input, 0, '.', ',');
}
?>


<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">لیست رزرو شده ها</h4>
              <a role="button" style="float: left;" href="<?= url('admin/reserved/create') ?>"
                class="btn btn-sm btn-success">اضافه کردن دستی <i class="fa-solid fa-plus"></i></a>
            </div>
            <div class="box-body table-responsive">
              <table class="table table-striped mb-0">
                <thead>
                  <tr>
                    <th>نام</th>
                    <th>تلفن</th>
                    <th>قیمت نوبت</th>
                    <th>تاریخ</th>
                    <th>روز</th>
                    <th>دکتر</th>
                    <?php if (!in_array(CURRENT_PLAN, ["E"])): ?>
                      <th>توضیحات</th>
                    <?php endif; ?>
                    <th>تنظیمات</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($reserves as $reserve) { ?>
                    <tr>
                      <td><?= $reserve['user_name'] ?></td>
                      <td><?= $reserve['number'] ?></td>
                      <?php
                      $time = $reserve['time'];
                      $hour = (int) explode(":", $time)[0];
                      $partOfDay = ($hour < 12) ? "( صبح )" : "( بعد از ظهر )";
                      ?>
                      <td><?= customFormat($reserve['price']); ?></td>
                      <td><?= $reserve['date'] ?></td>
                      <td><?= $reserve['week'] . ' ساعت ' . $time . ' ' . $partOfDay ?></td>
                      <td><?= $reserve['doctor_name'] ?></td>
                      <?php if (!in_array(CURRENT_PLAN, ["E"])): ?>
                        <td><?= $reserve['additional'] ?></td>
                      <?php endif; ?>
                      <td>
                        <a href="<?= url('admin/reserved/edit/' . $reserve['id']) ?>"
                          class="btn btn-sm btn-primary">ویرایش <i class="fa-solid fa-edit"></i></a>
                        <a href="<?= url('admin/reserved/delete/' . $reserve['id']) ?>" class="btn btn-sm btn-danger">حذف
                          <i class="fa-solid fa-eraser"></i></a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
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