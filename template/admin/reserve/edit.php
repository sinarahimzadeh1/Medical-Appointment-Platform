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
              <h1 class="h5">ویرایش زمان انتخاب شده</h1>
              <a role="button" href="<?= url('admin/reserve') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body">

              <form method="post" action="<?= url('admin/reserve/update/' . $reserves['id']) ?>">

                <div class="row g-3">
                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="dp">انتخاب زمان</label>
                    <input data-jdp type="text" class="form-control" id="dp" name="date"
                      placeholder="تاریخ و ساعت را انتخاب کنید..." autofocus required readonly>
                  </div>

                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="price">قیمت</label>
                    <div class="input-group">
                      <span class="input-group-text">$</span>
                      <input type="text" class="form-control" name="price" id="price" value="<?= $reserves['price'] ?>">
                      <span class="input-group-text fw-bold">تومان</span>
                    </div>
                  </div>

                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="day">روز</label>
                    <select class="form-control" id="day" name="day" required>
                      <option value="<?= $reserves['day'] ?>" selected><?= $reserves['day'] ?></option>
                      <option value="شنبه">شنبه</option>
                      <option value="یکشنبه">یک شنبه</option>
                      <option value="دوشنبه">دو شنبه</option>
                      <option value="سه‌شنبه">سه‌ شنبه</option>
                      <option value="چهارشنبه">چهار شنبه</option>
                      <option value="پنج‌شنبه">پنج‌ شنبه</option>
                      <option value="جمعه">جمعه</option>
                    </select>
                  </div>

                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="date">تاریخ</label>
                    <input type="text" class="form-control" id="date" name="date" value="<?= $reserves['date'] ?>"
                      required>
                  </div>

                  <div class="col-12 col-md-6 col-lg-4">
                    <label for="time">زمان</label>
                    <input type="text" class="form-control" id="time" name="time" value="<?= $reserves['time'] ?>"
                      required>
                  </div>

                  <?php if (!in_array(CURRENT_PLAN, ["E"])): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                      <label for="additional">توضیحات</label>
                      <input type="text" class="form-control" id="additional" name="additional"
                        value="<?= $reserves['additional'] ?>">
                    </div>
                  <?php endif; ?>

                </div>

                <button type="submit" class="btn btn-primary btn-sm mt-2">ویرایش <i class="fa fa-pencil"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>



<script>
  jalaliDatepicker.startWatch({ time: true });

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