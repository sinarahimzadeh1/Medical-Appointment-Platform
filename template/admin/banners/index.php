<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';
?>

<link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
<script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">

            <div class="box-header">
              <h4 class="box-title">بنر ها</h4>
              <a role="button" style="float: left;" href="<?= url('admin/banner/create') ?>"
                class="btn btn-sm btn-success">ساختن <i class="fa-solid fa-pencil"></i></a>
            </div>

            <div class="box-body">
              <div class="table-responsive p-3">
                <table class="table table-hover table-striped align-middle text-center">
                  <caption>لیست بنر ها</caption>
                  <thead class="table-dark">
                    <tr>
                      <th class="text-center">آدرس</th>
                      <th class="text-center">تصویر</th>
                      <th class="text-center">تنظیمات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($banners as $banner) { ?>
                      <tr>
                        <td class="text-break فثطف"><?= $banner['url'] ?></td>
                        <td>
                          <img src="<?= asset($banner['image']) ?>" alt="banner" class="img-thumbnail"
                            style="width: 200px;">
                        </td>
                        <td>
                          <a href="<?= asset('admin/banner/edit/' . $banner['id']) ?>"
                            class="btn btn-sm btn-primary me-1">
                            <i class="fa fa-edit"></i> ویرایش
                          </a>
                          <a href="<?= asset('admin/banner/delete/' . $banner['id']) ?>"
                            class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i> حذف
                          </a>
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


<script src="<?= asset('public\ckeditor\ckeditor.js') ?>"></script>
<script>

  jalaliDatepicker.startWatch();

  CKEDITOR.replace('summary');
  CKEDITOR.replace('body');

</script>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>