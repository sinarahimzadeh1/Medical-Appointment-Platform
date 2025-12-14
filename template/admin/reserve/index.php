<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';


$limit = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

$total_result = $db->select("SELECT COUNT(*) as total FROM reserves WHERE doctor_id = ?", [$this->adminEnteredID])->fetch();
$total_rows = $total_result['total'];
$total_pages = ceil($total_rows / $limit);

if ($page < 1)
  $page = 1;
if ($page > $total_pages && $total_pages > 0)
  $page = $total_pages;

$offset = ($page - 1) * $limit;

$workstationTimes = $db->select("SELECT  reserves.*,  doctors.name AS doctor_name FROM  reserves JOIN  doctors ON reserves.doctor_id = doctors.id WHERE doctor_id = ? ORDER BY reserves.date DESC LIMIT $limit OFFSET $offset;", [$this->adminEnteredID])->fetchAll();
$query = $db->select("SHOW COLUMNS FROM reserves LIKE 'price'")->fetch();

function customFormat($input)
{
  return number_format((float) $input, 0, '.', ',');
}

?>


<div class="content-wrapper">
  <div class="container-full">

    <!-- بخش جدید با عنوان و دکمه -->
    <section class="content" style="min-height: 0 !important;">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header d-flex justify-content-between align-items-center">

              <form action="<?= url('admin/reserve/change/price') ?>" method="post">
                <div class="d-flex align-items-center gap-2">
                  <label class="form-text mb-2 fw-bold fs-6 ms-2">مبلغ پیش فرض نوبت‌ها:</label>
                  <div class="input-group w-auto">
                    <span class="input-group-text"
                      style="border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;">$</span>
                    <input type="text" class="form-control rounded-0" name="new-price"
                      value="<?= customFormat($query['Default']) ?>">
                    <span class="input-group-text fw-bold">تومان</span>
                  </div>
                  <button type="submit" class="btn btn-success btn-sm w-100">
                    تغییر مبلغ <i class="fa-solid fa-dollar-sign"></i>
                  </button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- بخش اصلی جدول -->
    <section class="content mt-1">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">لیست زمان‌های کاری</h4>
              <a role="button" style="float: left;" href="<?= url('admin/reserve/create') ?>"
                class="btn btn-sm btn-success">اضافه کردن زمان جدید <i class="fa-solid fa-plus"></i></a>
            </div>
            <div class="box-body table-responsive">
              <table class="table table-striped mb-0">
                <thead>
                  <tr>
                    <th>تاریخ</th>
                    <th>ساعت</th>
                    <th>روز</th>
                    <th>قیمت نوبت</th>
                    <th>دکتر</th>
                    <?php if (!in_array(CURRENT_PLAN, ["E"])): ?>
                      <th>توضیحات</th>
                    <?php endif; ?>
                    <th>عملیات</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($workstationTimes as $workstationTime) { ?>
                    <tr>
                      <td><?= $workstationTime['date'] ?></td>
                      <?php
                      $time = $workstationTime['time'];
                      $hour = (int) explode(":", $time)[0];
                      $partOfDay = ($hour < 12) ? "صبح" : "بعد از ظهر";
                      $time = jalaliTime($time);
                      echo "<td><strong>{$time}</strong> ({$partOfDay})</td>";
                      ?>
                      <td><?= $workstationTime['day'] ?></td>
                      <td><?= customFormat($workstationTime['price']) ?></td>
                      <td><?= $workstationTime['doctor_name'] ?></td>
                      <?php if (!in_array(CURRENT_PLAN, ["E"])): ?>
                        <td><?= $workstationTime['additional'] ?></td>
                      <?php endif; ?>
                      <td>
                        <a href="<?= url('admin/reserve/edit/' . $workstationTime['id']) ?>"
                          class="btn btn-sm btn-primary">ویرایش <i class="fa-solid fa-paperclip"></i></a>
                        <a href="<?= url('admin/reserve/delete/' . $workstationTime['id']) ?>"
                          class="btn btn-sm btn-danger">حذف <i class="fa-solid fa-eraser"></i></a>
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