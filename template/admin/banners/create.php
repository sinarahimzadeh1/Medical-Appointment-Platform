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
              <h4 class="box-title">بنر ها</h4>
              <a role="button" href="<?= url('admin/banner/') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>

            <div class="box-body">
              <form method="post" action="<?= url('admin/banner/store') ?>" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="url">آدرس</label>
                  <input type="text" class="form-control" id="url" name="url" placeholder="مثال : google.com ..." required
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="image">عکس</label>
                  <input type="file" id="image" name="image" class="form-control-file" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary btn-sm">ذخیره <i class="fa-solid fa-square-plus fs-5"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>


<script src="<?= asset('public\ckeditor\ckeditor.js') ?>"></script>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>