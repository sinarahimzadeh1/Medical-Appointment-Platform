<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';

function customFormat($input)
{
  return number_format((float) $input, 0, '.', ',');
}

$doctorName = $db->select("SELECT name FROM doctors WHERE id = ?", [$this->adminEnteredID])->fetch();
?>

<link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
<script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-header d-flex justify-content-between align-items-center">
              <h4 class="box-title">ایجاد زمان کاری جدید</h4>
              <a role="button" href="<?= url('admin/reserved') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body">

              <form method="post" action="<?= url('admin/reserved/store') ?>">
                <div class="row g-3">

                  <!-- انتخاب زمان -->
                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="dp">انتخاب زمان</label>
                    <input data-jdp type="text" class="form-control" id="dp"
                      placeholder="تاریخ و ساعت را انتخاب کنید..." required readonly>
                  </div>

                  <!-- تاریخ -->
                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="date">تاریخ</label>
                    <input type="text" class="form-control" id="date" name="date" placeholder="تاریخ..." required
                      readonly>
                  </div>

                  <!-- ساعت -->
                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="time">ساعت</label>
                    <input type="text" class="form-control" id="time" name="time" required>
                  </div>

                  <!-- مبلغ -->
                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="price">مبلغ پیش فرض : <?= customFormat($query['Default']) ?></label>
                    <div class="input-group">
                      <span class="input-group-text">$</span>
                      <input type="text" class="form-control" name="price"
                        value="<?= customFormat($query['Default']) ?>">
                      <span class="input-group-text fw-bold">تومان</span>
                    </div>
                  </div>

                  <!-- روز -->
                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="week">روز</label>
                    <select class="form-control" id="week" name="week" required>
                      <option value="" disabled selected>یک روز انتخاب کنید...</option>
                      <option value="شنبه">شنبه</option>
                      <option value="یکشنبه">یک شنبه</option>
                      <option value="دوشنبه">دو شنبه</option>
                      <option value="سه‌شنبه">سه‌ شنبه</option>
                      <option value="چهارشنبه">چهار شنبه</option>
                      <option value="پنج‌شنبه">پنج‌ شنبه</option>
                      <option value="جمعه">جمعه</option>
                    </select>
                  </div>

                  <!-- دکتر -->
                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="doctor">دکتر</label>
                    <?php
                    if (count($doctors) == 1) {
                      echo '<input type="text" class="form-control" value="' . $doctors[0]['name'] . '" readonly>';
                      echo '<input type="hidden" name="doctor_id" value="' . $doctors[0]['id'] . '">';
                    } elseif (count($doctors) > 1) {
                      echo '<select class="form-control" id="doctor" name="doctor_id" required>';
                      echo '<option value="" disabled selected>یک دکتر انتخاب کنید...</option>';
                      foreach ($doctors as $doctor) {
                        $selected = $doctor['name'] == $doctorName['name'] ? "selected" : "";
                        echo '<option ' . $selected . ' value="' . $doctor['id'] . '">' . $doctor['name'] . '</option>';
                      }
                      echo '</select>';
                    } else {
                      echo '<select class="form-control" id="doctor" name="doctor_id" required>';
                      echo '<option value="" disabled selected>دکتری وجود ندارد</option>';
                    }
                    ?>
                  </div>

                  <!-- نام -->
                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="name">نام و نام خانوادگی</label>
                    <input type="text" class="form-control" name="name" placeholder="مثال : سینا..." required>
                  </div>

                  <!-- شماره -->
                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="number">شماره تلفن همراه</label>
                    <input type="text" class="form-control" name="number" placeholder="شماره تلفن..." required>
                  </div>

                  <!-- توضیحات -->
                  <?php if (!in_array(CURRENT_PLAN, ["E"])): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                      <label for="additional">توضیحات</label>
                      <input type="text" class="form-control" name="additional" placeholder="توضیحات...">
                    </div>
                  <?php endif; ?>

                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-sm btn-success fw-bold fs-6">
                    اضافه <i class="fa-solid fa-save"></i>
                  </button>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>


<script>

  jalaliDatepicker.startWatch({ time: true, showTodayBtn: false });

  document.getElementById('dp').addEventListener('change', function () {
    const selectedValue = this.value;

    const [datePart, timePart] = selectedValue.split(' ');

    const parts = datePart.split('/');

    const formattedDate = datePart.split('/').join('-');

    document.getElementById('date').value = formattedDate;

    if (timePart) {
      document.getElementById('time').value = timePart.trim();
    }
  });


</script>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>