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
            <div class="box-header d-flex justify-content-between align-items-center">
              <h4 class="box-title"> ساخت پست جدید</h4>
              <?php
              $referer = $_SERVER['HTTP_REFERER'] ?? '';
              $queryString = '';
              if (!empty($referer)) {
                $parsedUrl = parse_url($referer);
                if (isset($parsedUrl['query'])) {
                  $queryString = $parsedUrl['query'];
                }
              }
              ?>
              <a role="button" href="<?= url('admin/post?') . $queryString ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body table-responsive">

              <form method="post" action="<?= url('admin/post/store') ?>" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="title">عنوان</label>
                  <input type="text" class="form-control" id="title" name="title" placeholder="عنوان مطلب ..." required
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="cat_id">دسته بندی</label>
                  <select name="cat_id" id="cat_id" class="form-control" required autofocus>
                    <?php foreach ($categories as $category) { ?>
                      <option value="<?= $category['id'] ?>">
                        <?= $category['name'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
					<label for="image">تصویر پست:</label>
					<input type="file" id="image" name="image" class="form-control-file" required autofocus>
					<small id="uploadStatus" class="form-text text-muted mt-2"></small>
				</div>

				<script>
				const imageInput = document.getElementById('image');
				const statusText = document.getElementById('uploadStatus');
				imageInput.addEventListener('change', () => {
					if (imageInput.files.length > 0) {
					statusText.textContent = 'در حال آپلود... لطفاً منتظر بمانید';
					statusText.style.color = 'blue';
					// فقط شبیه‌سازی یک تأخیر برای نمایش متن
					setTimeout(() => {
						statusText.textContent = 'آپلود کامل شد ✅';
						statusText.style.color = 'green';
					}, 1500);
					} else {
					statusText.textContent = '';
					}
				});
				</script>


                <div class="form-group">
                  <label for="published_at">منشتر شده در :</label>
                  <input data-jdp type="text" class="form-control" id="published_at" name="published_at" required autofocus readonly>
                </div>

                <div class="form-group">
                  <label for="summary">خلاصه</label>
                  <textarea class="form-control" id="summary" name="summary" placeholder="summary ..." rows="3" required
                    autofocus></textarea>
                </div>

                <div class="form-group col-12">
                  <label for="body">بدنه (متن اصلی)</label>
                  <textarea class="form-control" id="body" name="body" placeholder="body ..." rows="5" required
                    autofocus></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-sm fs-5">انتشار <i class="fa-solid fa-square-plus"></i></button>

              </form>
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