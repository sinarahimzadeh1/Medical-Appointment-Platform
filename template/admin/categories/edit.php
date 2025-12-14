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
              <h4 class="box-title">ویرایش دسته بندی
                "<?= $category['name'] ?>"</h4>
              <a role="button" href="<?= url('admin/category') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body table-responsive">
              <form method="post" action="<?= url('admin/category/update/' . $category['id']) ?>">
                <div class="form-group">
                  <label for="name">نام</label>
                  <input type="text" class="form-control" id="name" name="name" value="<?= $category['name'] ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">ویرایش <i class="fa fa-pencil"></i></button>
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