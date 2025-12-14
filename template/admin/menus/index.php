<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';
?>

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header">
              <h4 class="box-title">منو ها</h4>
              <a role="button" style="float: left;" href="<?= url('admin/menu/create') ?>"
                class="btn btn-sm btn-success">ساختن <i class="fa-solid fa-pencil"></i></a>
            </div>
            <div class="box-body">
              <section class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle">
                  <caption class="fw-bold">لیست منو ها</caption>
                  <thead class="table-light">
                    <tr>
                      <th class="text-center">نام</th>
                      <th class="text-center">آدرس</th>
                      <th class="text-center">شاخه</th>
                      <th class="text-center">تنظیمات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($menus as $menu) { ?>
                      <tr>
                        <td> <?= $menu['name'] ?></td>
                        <td><?= $menu['url'] ?></td>
                        <td><?= $menu['parent_id'] == null ? 'منوی اصلی' : $menu['parent_name'] ?></td>
                        <td>
                          <a role="button" class="btn btn-sm btn-primary text-white"
                            href="<?= url('admin/menu/edit/' . $menu['id']) ?>">ویرایش <i class="fa fa-edit"></i></a>
                          <a role="button" class="btn btn-sm btn-danger text-white"
                            href="<?= url('admin/menu/delete/' . $menu['id']) ?>">حذف <i class="fa fa-trash"></i></a>
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
