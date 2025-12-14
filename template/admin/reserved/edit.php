<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';

function customFormat($input)
{
  return number_format((float) $input, 0, '.', ',');
}

?>

<link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
<script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header d-flex justify-content-between align-items-center flex-wrap">
              <h1 class="h5 mb-2">ویرایش زمان انتخاب شده</h1>
              <a role="button" href="<?= url('admin/reserved') ?>" class="btn btn-sm btn-secondary mb-2">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>

            <div class="box-body">
              <form method="post" action="<?= url('admin/reserved/update/' . $id) ?>">

                <div class="row mb-3">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="dp">انتخاب زمان</label>
                      <input data-jdp type="text" class="form-control" id="dp"
                        placeholder="تاریخ و ساعت را انتخاب کنید..." autofocus required readonly>
                    </div>
                  </div>
                </div>

                <div class="row g-3">
                  <!-- قیمت -->
                  <div class="col-12 col-md-6 col-lg-3">
                    <label for="price">قیمت</label>
                    <div class="input-group">
                      <span class="input-group-text">$</span>
                      <input type="text" class="form-control" name="price" id="price"
                        value="<?= customFormat($reserved['price']) ?>">
                      <span class="input-group-text fw-bold">تومان</span>
                    </div>
                  </div>

                  <!-- روز -->
                  <div class="col-12 col-md-6 col-lg-3">
                    <label for="week">روز</label>
                    <select class="form-control" id="week" name="week" required>
                      <option value="<?= $reserved['week'] ?>" selected><?= $reserved['week'] ?></option>
                      <option value="شنبه">شنبه</option>
                      <option value="یکشنبه">یکشنبه</option>
                      <option value="دوشنبه">دوشنبه</option>
                      <option value="سه‌شنبه">سه‌شنبه</option>
                      <option value="چهارشنبه">چهارشنبه</option>
                      <option value="پنج‌شنبه">پنج‌شنبه</option>
                      <option value="جمعه">جمعه</option>
                    </select>
                  </div>

                  <!-- تاریخ -->
                  <div class="col-12 col-md-6 col-lg-3">
                    <label for="date">تاریخ</label>
                    <input type="text" class="form-control" id="date" name="date" value="<?= $reserved['date'] ?>"
                      required>
                  </div>

                  <!-- زمان -->
                  <div class="col-12 col-md-6 col-lg-3">
                    <label for="time">زمان</label>
                    <input type="text" class="form-control" id="time" name="time" placeholder="زمان..."
                      value="<?= $reserved['time'] ?>" required>
                  </div>

                  <?php if (!in_array(CURRENT_PLAN, ["E"])): ?>
                    <div class="col-12 col-md-12 col-lg-12">
                      <label for="additional">توضیحات</label>
                      <input type="text" class="form-control" id="additional" name="additional" placeholder="توضیحات..."
                        value="<?= $reserved['additional'] ?>">
                    </div>
                  <?php endif; ?>

                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-primary btn-sm">
                    ویرایش <i class="fa fa-pencil"></i>
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