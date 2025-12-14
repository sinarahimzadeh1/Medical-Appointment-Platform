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
              <h4 class="box-title">تنظیمات</h4>
              <a role="button" style="float: left;" href="<?= url('admin/websetting/edit') ?>"
                class="btn btn-sm btn-primary">ویرایش <i class="fa-solid fa-pencil"></i></a>
            </div>
            <div class="box-body">
              <section class="table-responsive">
                <table class="table table-striped table-sm">
                  <caption>تنظیمات سایت</caption>
                  <thead>
                    <tr>
                      <th>عنوان</th>
                      <th>مقدار</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr>
                      <td>عنوان سایت</td>
                      <td>
                        <?= $setting['title'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>توضیحات</td>
                      <td>
                        <?= $setting['description'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>کلید واژه</td>
                      <td>
                        <?= $setting['keywords'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>لوگو سایت</td>
                      <td><img src="<?= asset($setting['logo']) ?>" alt="" width="15%" height="auto"
                          style="background-size: cover; background-position: center; background-repeat: no-repeat;">
                      </td>
                    </tr>
                    <tr>
                      <td>آیکون سایت</td>
                      <td><img src="<?= asset($setting['icon']) ?>" alt="" width="5%" height="auto"> </td>
                    </tr>
                    <tr>
                      <td>#1 عکس و متن اینترو سایت</td>
                      <td>
                        <img src="<?= asset($setting['intro_image_1']) ?>" alt="" width="15%" height="auto">
                        <?= " / " . $setting['intro_text_1'] . "  /  " ?>
                        <?= $setting['intro_text_11'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>#2 عکس و متن اینترو سایت</td>
                      <td>
                        <img src="<?= asset($setting['intro_image_2']) ?>" alt="" width="15%" height="auto">
                        <?= " / " . $setting['intro_text_2'] . "  /  " ?>
                        <?= $setting['intro_text_22'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>#3 عکس و متن اینترو سایت</td>
                      <td>
                        <img src="<?= asset($setting['intro_image_3']) ?>" alt="" width="15%" height="auto">
                        <?= " / " . $setting['intro_text_3'] . "  /  " ?>
                        <?= $setting['intro_text_33'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>شعار پانویس سایت</td>
                      <td>
                        <?= $setting['footer_text'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>ادرس شعبه اصلی</td>
                      <td>
                        <?= $setting['main_loc_address'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>ایمیل یا ادرس شبکه اجتماعی شعبه اصلی</td>
                      <td>
                        <?= $setting['main_email_address'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>شماره شعبه اصلی</td>
                      <td style="direction: ltr;">
                        <?= $setting['main_number_address'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>ادرس اینستاگرام</td>
                      <td>
                        <?= $setting['socialmedia_1'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>ادرس دیگر مدیا</td>
                      <td>
                        <?= $setting['socialmedia_2'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>شماره مطب</td>
                      <td style="direction: ltr;">
                        <?= $setting['socialmedia_3'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>عنوان پانویس</td>
                      <td>
                        <?= $setting['web_desc_title'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>متن پانویس</td>
                      <td>
                        <?= $setting['web_description'] ?>
                      </td>
                    </tr>
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