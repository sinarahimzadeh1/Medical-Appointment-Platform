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
              <h1 class="h5">ویرایش کاربر <?= $user['username'] ?></h1>
              <a role="button" href="<?= url('admin/user') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body">

              <form method="post" action="<?= url('admin/user/update/' . $user['id']) ?>">

                <div class="form-group">
                  <label for="username">نام کاربر</label>
                  <input type="text" class="form-control" id="username" name="username"
                    value="<?= $user['username'] ?>">
                </div>

                <div class="form-group">
                  <label for="permission">شماره </label>
                  <input type="text" class="form-control" id="number" name="number"
                    value="<?= $user['number'] ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">ویرایش <i class="fa fa-edit"></i></button>
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