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
              <h1 class="h5">ساخت منو</h1>
              <a role="button" href="<?= url('admin/menu') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body">
              <form method="post" action="<?= url('admin/menu/store') ?>">
                <div class="form-group">
                  <label for="name">نام</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="نام..." required>
                </div>

                <div class="form-group">
                  <label for="url">آدرس</label>
                  <input type="text" class="form-control" id="url" name="url" placeholder="مثال : blog..." required>
                </div>

                <button type="submit" class="btn btn-primary btn-sm fs-5">ساختن <i class="fa-regular fa-square-plus"></i></button>
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