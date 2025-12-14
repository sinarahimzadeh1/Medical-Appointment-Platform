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
              <h4 class="box-title">ویرایش تنظیمات سایت</h4>
              <a role="button" href="<?= url('admin/websetting') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body">

              <form method="post" action="<?= url('admin/websetting/update') ?>" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="title">عنوان سایت</label>
                  <input type="text" class="form-control" id="title" name="title" value="<?= $setting['title'] ?>"
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="title">توضیحات</label>
                  <input type="text" class="form-control" id="desc" name="description" value="<?= $setting['description'] ?>"
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="title">کلید واژه</label>
                  <input type="text" class="form-control" id="keywords" name="keywords"
                    value="<?= $setting['keywords'] ?>" autofocus>
                </div>

                <div class="form-group">
                  <label for="description">لوگو سایت</label>
                  <input type="file" class="form-control" id="logo" name="logo" autofocus>
                  <label for="">لوگو قبلی : </label>
                  <img src="<?= asset($setting['logo']) ?>" alt="" width="15%" height="auto"
                    style="background-size: cover; background-position: center; background-repeat: no-repeat;">
                </div>

                <div class="form-group">
                  <label for="description">آیکون سایت</label>
                  <input type="file" class="form-control" id="icon" name="icon" autofocus>
                  <label for="">آیکون قبلی : </label>
                  <img src="<?= asset($setting['icon']) ?>" alt="" width="5%" height="auto"
                    style="background-size: cover; background-position: center; background-repeat: no-repeat;">
                </div>
                <hr>
                <div class="form-group">
                  <label for="description">#1 عکس اینترو سایت</label>
                  <input type="file" class="form-control" name="intro_image_1" autofocus>
                  <label for="">عکس قبلی : </label>
                  <img src="<?= asset($setting['intro_image_1']) ?>" alt="" width="15%" height="auto"
                    style="background-size: cover; background-position: center; background-repeat: no-repeat;">
                </div>

                <div class="form-group">
                  <label for="description">#2 عکس اینترو سایت</label>
                  <input type="file" class="form-control" name="intro_image_2" autofocus>
                  <label for="">عکس قبلی : </label>
                  <img src="<?= asset($setting['intro_image_2']) ?>" alt="" width="15%" height="auto"
                    style="background-size: cover; background-position: center; background-repeat: no-repeat;">
                </div>

                <div class="form-group">
                  <label for="description">#3 عکس اینترو سایت</label>
                  <input type="file" class="form-control" name="intro_image_3" autofocus>
                  <label for="">عکس قبلی : </label>
                  <img src="<?= asset($setting['intro_image_3']) ?>" alt="" width="15%" height="auto"
                    style="background-size: cover; background-position: center; background-repeat: no-repeat;">
                </div>
                <hr>
                <div class="form-group">
                  <label for="title">متن اینترو سایت #1</label>
                  <input type="text" class="form-control" name="intro_text_1" value="<?= $setting['intro_text_1'] ?>"
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="title">متن اینترو سایت #2</label>
                  <input type="text" class="form-control" name="intro_text_2" value="<?= $setting['intro_text_2'] ?>"
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="title">متن اینترو سایت #3</label>
                  <input type="text" class="form-control" name="intro_text_3" value="<?= $setting['intro_text_3'] ?>"
                    autofocus>
                </div>
                <hr>
                <div class="form-group">
                  <label for="title">عنوان متن اینترو سایت #1</label>
                  <input type="text" class="form-control" name="intro_text_11" value="<?= $setting['intro_text_11'] ?>"
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="title">عنوان متن اینترو سایت #2</label>
                  <input type="text" class="form-control" name="intro_text_22" value="<?= $setting['intro_text_22'] ?>"
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="title">عنوان متن اینترو سایت #3</label>
                  <input type="text" class="form-control" name="intro_text_33" value="<?= $setting['intro_text_33'] ?>"
                    autofocus>
                </div>
                <hr>
                <div class="form-group">
                  <label for="title">شعار پانویس سایت</label>
                  <input type="text" class="form-control" name="footer_text" value="<?= $setting['footer_text'] ?>"
                    autofocus>
                </div>
                <hr>

                <div class="form-group">
                  <label for="title">ادرس شعبه اصلی</label>
                  <input type="text" class="form-control" name="main_loc_address"
                    value="<?= $setting['main_loc_address'] ?>" autofocus>
                </div>

                <div class="form-group">
                  <label for="title">ایمیل یا ادرس شبکه اجتماعی شعبه اصلی</label>
                  <input type="text" class="form-control" name="main_email_address"
                    value="<?= $setting['main_email_address'] ?>" autofocus>
                </div>

                <div class="form-group">
                  <label for="title">شماره شعبه اصلی</label>
                  <input type="text" class="form-control" name="main_number_address"
                    value="<?= $setting['main_number_address'] ?>" autofocus>
                </div>
                <hr>

                <div class="form-group">
                  <label for="title">ادرس اینستاگرام</label>
                  <input type="text" class="form-control" name="socialmedia_1" value="<?= $setting['socialmedia_1'] ?>"
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="title">ادرس دیگر مدیا</label>
                  <input type="text" class="form-control" name="socialmedia_2" value="<?= $setting['socialmedia_2'] ?>"
                    autofocus>
                </div>

                <div class="form-group">
                  <label for="title">شماره مطب</label>
                  <input type="text" class="form-control" name="socialmedia_3" value="<?= $setting['socialmedia_3'] ?>"
                    autofocus>
                </div>
                <hr>

                <div class="form-group">
                  <label for="title">عنوان پانویس</label>
                  <input type="text" class="form-control" name="web_desc_title"
                    value="<?= $setting['web_desc_title'] ?>" autofocus>
                </div>

                <div class="form-group">
                  <label for="title">متن پانویس</label>
                  <textarea type="text" class="form-control" name="web_description" autofocus><?= $setting['web_description'] ?></textarea>
                </div>

                <button type="submit" class="btn btn-warning">ثبت تغییر <i class="fa fa-edit"></i></button>

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