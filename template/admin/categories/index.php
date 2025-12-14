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
              <h4 class="box-title">دسته بندی ها</h4>
              <a role="button" style="float: left;" href="<?= url('admin/category/create') ?>"
                class="btn btn-sm btn-success">ساختن <i class="fa-solid fa-pencil"></i></a>
            </div>
            <div class="box-body table-responsive">
              <div class="table-responsive">
                <table class="table table-striped table-sm">
                  <caption>لیست دسته بندی ها</caption>
                  <thead>
                    <tr>
                      <th>نام دسته بندی</th>
                      <th>تنظیمات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($categories as $category) { ?>
                      <tr>
                        <td>
                          <?= $category['name'] ?>
                        </td>
                        <td>
                          <a href="<?= url('admin/category/edit/' . $category['id']) ?>"
                            class="btn btn-sm btn-primary">ویرایش <i class="fa-solid fa-paperclip"></i></a>
                          <a href="<?= url('admin/category/delete/' . $category['id']) ?>"
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
      </div>
    </section>
  </div>
</div>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>