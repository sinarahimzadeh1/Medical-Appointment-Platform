<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';

$doctors = $db->select("SELECT * FROM  doctors ORDER BY id DESC")->fetchAll();

?>

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">دکتر ها</h4>
              <?php
              if ($doctorCount > 1) {
                if (!in_array(CURRENT_PLAN, ["C", "D", "E"])): ?>
                  <a role="button" style="float: left;" href="<?= url('admin/doctor/create') ?>"
                    class="btn btn-sm btn-success">دکتر جدید <i class="fa-solid fa-pencil"></i></a>
                <?php endif;
              }
              ?>
            </div>
            <div class="box-body">
              <section class="table-responsive">
                <table class="table table-striped table-sm">
                  <caption>لیست دکتر ها</caption>
                  <thead>
                    <tr>
                      <th class="text-center">پروفایل</th>
                      <th class="text-center">نام </th>
                      <th class="text-center">شماره تلفن</th>
                      <th class="text-center">کد نظام پزشکی</th>
                      <th class="text-center">تلفن مطب</th>
                      <th class="text-center">کلینیک</th>
                      <th class="text-center">آدرس</th>
                      <th class="text-center">سرویس</th>
                      <th class="text-center">شروع فعالیت</th>
                      <th class="text-center">تنظیمات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($doctors as $doc) { ?>
                      <tr>
                        <td><img src="<?= asset($doc['profile']) ?>" alt="" class="img-thumbnail" style="width: 150px;">
                        </td>
                        <td class="fw-bold"><?= $doc['name'] ?></td>
                        <td class="fw-bold"><?= '0' . $doc['number'] ?></td>
                        <td class="fw-bold"><?= $doc['doc_number'] ?></td>
                        <td class="fw-bold"><?= $doc['surgery_phone'] ?></td>
                        <td class="fw-bold"><?= $doc['clinic'] ?></td>
                        <td class="fw-bold"><?= $doc['location'] ?></td>
                        <td class="fw-bold"><?= $doc['services'] ? $doc['services'] : 'ثبت نشده...' ?></td>
                        <td class="fw-bold"><?= $doc['experience'] ?></td>
                        <td>
                          <a role="button" class="btn btn-sm btn-primary text-white ms-1 my-1"
                            href="<?= url('admin/doctor/edit/' . $doc['id']) ?>">ویرایش <i class="fa fa-edit"></i></a>
                          <a role="button" class="btn btn-sm btn-danger text-white"
                            onclick="confirmDeleteDoctor(<?= $doc['id'] ?>)">حذف دکتر <i class="fa fa-trash"></i></a>
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


<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>