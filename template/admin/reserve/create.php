<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';

$query = $db->select("SHOW COLUMNS FROM reserves LIKE 'price'")->fetch();

function customFormat($input)
{
  return number_format((float) $input, 0, '.', ',');
}

$doctorName = $db->select("SELECT name FROM doctors WHERE id = ?", [$this->adminEnteredID])->fetch();
?>

<link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
<script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>

<link rel="stylesheet" href="<?= url('public\admin-panel\css\jquery.clockinput.css') ?>">
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header d-flex justify-content-between align-items-center">
              <h4 class="box-title">ایجاد زمان کاری جدید</h4>
              <a role="button" href="<?= url('admin/reserve') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body">

              <form method="post" action="<?= url('admin/reserve/store') ?>">
                <div class="row">

                  <!-- فیلد دکتر -->
                  <div class="col-md-6 col-lg-6 mb-3">
                    <label for="doctor">دکتر</label>
                    <?php
                    if (count($doctors) == 1) {
                      echo '<input type="text" class="form-control" value="' . $doctors[0]['name'] . '" readonly>';
                      echo '<input type="hidden" name="doctor_id" value="' . $doctors[0]['id'] . '">';
                    } elseif (count($doctors) > 1) {
                      echo '<select class="form-control" id="doctor" name="doctor_id" required>';
                      echo '<option value="" disabled selected>یک دکتر انتخاب کنید...</option>';
                      foreach ($doctors as $doctor) {
                        $selected = $doctor['name'] == $doctorName['name'] ? "selected=" . $doctorName['name'] : "";
                        echo '<option ' . $selected . ' value="' . $doctor['id'] . '">' . $doctor['name'] . '</option>';
                      }
                      echo '</select>';
                    } else {
                      echo '<select class="form-control" id="doctor" name="doctor_id" required>';
                      echo '<option value="" disabled selected>دکتری وجود ندارد</option>';
                    }
                    ?>
                  </div>

                  <!-- فیلد تاریخ -->
                  <div class="col-md-6 col-lg-6 mb-3">
                    <label for="date">تاریخ</label>
                    <input data-jdp type="text" class="form-control" id="date" name="date" placeholder="تاریخ..."
                      required readonly>
                  </div>

                  <!-- فیلد روز -->
                  <div class="col-md-6 col-lg-6 mb-3">
                    <label for="day">روز</label>
                    <select class="form-control" id="day" name="day" required>
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

                  <!-- فیلد مبلغ -->
                  <div class="col-md-6 col-lg-6 mb-3">
                    <label>مبلغ پیش فرض : <?= customFormat($query['Default']) ?></label>
                    <div class="input-group">
                      <span class="input-group-text">تومان</span>
                      <input type="text" class="form-control rounded-0" name="price"
                        value="<?= customFormat($query['Default']) ?>">
                    </div>
                  </div>

                  <?php if (!in_array(CURRENT_PLAN, ["E"])): ?>
                    <div class="col-md-12 col-lg-12 mb-3">
                      <label>توضیحات</label>
                      <div class="input-group">
                        <span class="input-group-text">توضیحات</span>
                        <input type="text" class="form-control rounded-0" name="additional" value=""
                          placeholder="مثال : لمینت">
                      </div>
                    </div>
                  <?php endif; ?>

                </div>
                <div class="row">
                  <div class="row">
                    <div class="col">
                      <label class="mb-4">انتخاب ساعت رزرو:</label>
                      <a id="add-time-btn" class="btn btn-sm mx-2 btn-warning mt-2">افزودن ساعت</a>
                      <div id="time-boxes" class="d-flex flex-wrap gap-2 mb-3"></div>
                    </div>
                  </div>
                  <div class="col">
                    <input id="time-input" class="w-100" type="time" value="00:00" min="0:00" max="23:55">
                  </div>
                  <label class="mb-4">با کلیک روی ساعت (ساعت را انتخاب کنید) <br> با کلیک روی دقیقه (دقیقه را انتخاب
                    کنید) <br> با کلیک روی صبح ، بین صبح و بعد از ظهر جابجا شوید.</label>

                </div>

                <input type="hidden" name="time[]" id="times-hidden">

                <button type="submit" class="btn btn-sm btn-success fw-bold fs-6">ذخیره <i
                    class="fa-solid fa-save"></i></button>

              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="<?= url('public\admin-panel\css\jquery.clockinput.js') ?>"></script>
<script>
  jalaliDatepicker.startWatch({ showTodayBtn: false });


  $("input[type=time]").clockInput();
  var times = [];
  $(document).ready(function () {

    $('#add-time-btn').on('click', function () {
      const timeValue = $('#time-input').val(); // مثلا "12:30"
      if (!timeValue) return;

      let [hour, minute] = timeValue.split(':').map(Number);

      const ampmText = $('.jq-ci-t_ap').text().trim(); // "AM" یا "PM"

      let [light, dark] = ampmText.split(' ').map(String);

      if (hour == 0 && light) {
        hour = 12;
      } else if (hour == 12 && dark) {
        hour = 0;
      }

      const finalHour = hour.toString().padStart(2, '0');
      const finalMinute = minute.toString().padStart(2, '0');
      const finalTime = `${finalHour}:${finalMinute}`;

      times.push(finalTime);

      const timeBox = $(`
    <div class="border rounded px-3 py-1 bg-light d-flex align-items-center">
      <span class="me-2">${finalTime}</span>
      <button type="button" class="btn-close ms-auto" aria-label="Remove"></button>
    </div>
  `);

      $('#time-boxes').append(timeBox);
    });


    // حذف باکس با کلیک روی ×
    $(document).on('click', '.btn-close', function () {
      const timeBox = $(this).closest('div'); // div اصلی
      const timeText = timeBox.find('span').text().trim(); // مقدار ساعت مثلاً "13:30"

      // حذف مقدار از آرایه times
      times = times.filter(t => t !== timeText);

      // حذف از DOM
      timeBox.remove();
    });


  });


  $('form').on('submit', function (e) {
    // اول، حذف inputهای قبلی اگر قبلاً ساخته شده بودن (برای جلوگیری از تکراری شدن)
    $('input[name="time[]"]').remove();

    if (times.length === 0) {
      e.preventDefault();
      alert('حداقل یک ساعت رزرو انتخاب کنید.');
      return;
    }

    // اینجا اضافه‌شون کن
    times.forEach(function (time) {
      $('<input>').attr({
        type: 'hidden',
        name: 'time[]',
        value: time
      }).appendTo(this); // this یعنی فرم فعلی
    }.bind(this));
  });



</script>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>