<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
require_once BASE_PATH . '/template/admin/layouts/sidebar.php';
?>

<link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
<script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
  .badge {
    background: #007bff;
    color: #fff;
    padding: 0px 12px;
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
  }

  .badge .remove {
    margin-left: 8px;
    cursor: pointer;
    font-weight: bold;
  }

  #tagContainer {
    border: 1px solid #ccc;
    min-height: 40px;
    padding: 5px;
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    border-radius: 5px;
  }

  #tagInput {
    border: none;
    outline: none;
    flex: 1;
    min-width: 120px;
    font-size: 14px;
  }

  #addTagBtn {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 6px 12px;
    cursor: pointer;
    font-size: 18px;
    margin-left: 4px;
    width: 5%;
    font-size: 19px;
    font-weight: bold;
    border-radius: 5px;
  }

  @media screen and (max-width: 767.98px) {
    #addTagBtn {
      width: 12%;
    }
  }
</style>

<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="box">
            <div class="box-header d-flex justify-content-between align-items-center">
              <h4 class="box-title">دکتر جدید</h4>
              <a role="button" href="<?= url('admin/doctor') ?>" class="btn btn-sm btn-secondary">
                بازگشت <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
            <div class="box-body">

              <form method="post" action="<?= url('admin/doctor/store') ?>" enctype="multipart/form-data">
                <div class="row">

                  <div class="form-group">
                    <label for="image">تصویر پروفایل : </label>
                    <input type="file" id="profile" name="profile" class="form-control" autofocus>
                  </div>

                  <div class="col">
                    <div class="form-group">
                      <label for="title">نام دکتر :</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="اسم دکتر..." required
                        autofocus>
                    </div>
                    <div class="form-group">
                      <label for="title">شماره تلفن :</label>
                      <input type="text" class="form-control" id="number" name="number" placeholder="شماره تلفن..."
                        required autofocus>
                    </div>
                    <div class="form-group">
                      <label for="title">کد نظام پزشکی :</label>
                      <input type="text" class="form-control" id="doc_number" name="doc_number"
                        placeholder="کد نظام پزشکی..." required autofocus>
                    </div>
                    <div class="form-group">
                      <label for="title">سال شروع فعالیت :</label>
                      <input data-jdp type="text" class="form-control" id="experience" name="experience"
                        placeholder="فقط سال مهم است..." required autofocus>
                    </div>
                  </div>


                  <div class="col">
                    <div class="form-group">
                      <label for="title">تلفن مطب :</label>
                      <input type="text" class="form-control" id="surgery_phone" name="surgery_phone"
                        placeholder="تلفن مطب..." required autofocus>
                    </div>
                    <div class="form-group">
                      <label for="title">کلینیک :</label>
                      <input type="text" class="form-control" id="clinic" name="clinic" placeholder="کلینیک..." required
                        autofocus>
                    </div>
                    <div class="form-group">
                      <label for="title">آدرس :</label>
                      <input type="text" class="form-control" id="location" name="location" placeholder="آدرس..."
                        required autofocus>
                    </div>
                    <div class="form-group">
                      <label for="title">شهر :</label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="شهر..." required
                        autofocus>
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="title">تخصص :</label>
                    <input type="text" class="form-control" id="expert" name="expert"
                      placeholder="مثال : دندان پزشک، پزشک پوست و مو..." required autofocus>
                  </div>


                  <div class="form-group">
                    <label>سرویس‌ ها:</label>
                    <div style="display: flex; align-items: center;">
                      <button type="button" id="addTagBtn">+</button>
                      <div id="tagContainer">
                        <input type="text" id="tagInput" placeholder="تخصص رو بنویس و + رو بزن، مثلا: لمینت">
                      </div>
                    </div>
                    <input type="hidden" name="services" id="hiddenTags">
                  </div>


                  <div class="form-group">
                    <label>انتخاب‌ مسیر در نقشه :</label>
                    <input type="text" class="form-control my-3" id="coords" name="coords"
                      placeholder="یک نقطه روی نقشه انتخاب کن..." required>
                    <div id="map" style="height: 300px;"></div>
                    <!-- <p>مختصات انتخاب‌شده: <span id="coords">-</span></p> -->
                  </div>



                </div>

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

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
  // SELECTING Location on the map
  // ساخت نقشه
  const map = L.map('map').setView([35.6892, 51.3890], 13);
  // جلوگیری از تایپ دستی
  coords.addEventListener('keydown', function (e) {
    e.preventDefault();
  });

  // جلوگیری از Paste دستی
  coords.addEventListener('paste', function (e) {
    e.preventDefault();
  });

  // لایه نقشه
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 21
  }).addTo(map);

  let marker;

  // افزودن مارکر با کلیک روی نقشه
  map.on('click', function (e) {
    const lat = e.latlng.lat.toFixed(6);
    const lon = e.latlng.lng.toFixed(6);

    if (marker) {
      map.removeLayer(marker);
    }

    marker = L.marker([lat, lon]).addTo(map);

    // مقدار دادن به input
    document.getElementById('coords').value = `${lat}, ${lon}`;
  });


  // جستجوگر
  L.Control.geocoder({
    defaultMarkGeocode: false
  })
    .on('markgeocode', function (e) {
      const latlng = e.geocode.center;

      if (marker) {
        map.removeLayer(marker);
      }

      marker = L.marker(latlng).addTo(map);
      map.setView(latlng, 15);

      document.getElementById('coords').textContent = `${latlng.lat.toFixed(6)}, ${latlng.lng.toFixed(6)}`;
    })
    .addTo(map);



  // -----------------
  document.addEventListener('DOMContentLoaded', function () {
    // بخش مربوط به date picker
    jalaliDatepicker.startWatch({
      showTodayBtn: false,
    });

    if (document.getElementById('dp')) {
      document.getElementById('dp').addEventListener('change', function () {
        const selectedValue = this.value;

        const [datePart, timePart] = selectedValue.split(' ');

        const formattedDate = datePart.split('/').join('-');

        document.getElementById('date').value = formattedDate;

        if (timePart) {
          document.getElementById('time').value = timePart.trim();
        }
      });
    }

    // بخش مربوط به section spliter
    const tagInput = document.getElementById('tagInput');
    const tagContainer = document.getElementById('tagContainer');
    const hiddenInput = document.getElementById('hiddenTags');
    const addTagBtn = document.getElementById('addTagBtn');
    const form = document.getElementById('myForm');

    const tags = [];

    function updateHidden() {
      hiddenInput.value = tags.join(', ');
      console.log('Hidden input value updated:', hiddenInput.value);
    }

    function createTag(text) {
      const span = document.createElement('span');
      span.className = 'badge m-1';
      span.textContent = text;

      const remove = document.createElement('span');
      remove.className = 'remove mx-2 fs-5';
      remove.textContent = '×';
      remove.onclick = () => {
        console.log('Removing tag:', text);
        tagContainer.removeChild(span);
        tags.splice(tags.indexOf(text), 1);
        updateHidden();
      };

      span.appendChild(remove);
      tagContainer.insertBefore(span, tagInput);
      console.log('Tag added:', text);
    }

    function addTag() {
      const txt = tagInput.value.trim();
      console.log('Add tag clicked with input:', txt);
      if (!txt || tags.includes(txt)) {
        console.log('Invalid input or duplicate tag');
        return;
      }
      tags.push(txt);
      createTag(txt);
      updateHidden();
      tagInput.value = '';
      tagInput.focus();
    }

    addTagBtn.addEventListener('click', addTag);

    // اختیاری: زدن Enter هم تگ اضافه کنه ولی فرم نره
    tagInput.addEventListener('keydown', e => {
      if (e.key === 'Enter') {
        e.preventDefault();
        addTag();
      }
    });

    form.addEventListener('submit', e => {
      e.preventDefault();
      alert('خدمات ارسال شده:\n' + hiddenInput.value);
      // اینجا عملیات ارسال AJAX یا فرم رو انجام بده
    });

  });


</script>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>