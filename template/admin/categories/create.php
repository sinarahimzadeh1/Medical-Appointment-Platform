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
            <div class="box-header d-flex justify-content-between align-items-center">
              <h4 class="box-title">ساخت دسته بندی جدید</h4>
              <a role="button" href="<?= url('admin/category') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body table-responsive">
              <form method="post" action="<?= url('admin/category/store') ?>">
                <div class="form-group">
                  <label for="name">نام دسته بندی</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="مثال : دندان پزشکی ...">
                </div>
                <button type="submit" class="btn btn-sm btn-success fw-bold fs-6">ذخیره <i class="fa-solid fa-save"></i></button>
              </form>
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