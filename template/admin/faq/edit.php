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
              <h4 class="box-title">ویرایش سوالات مربوط به دکتر <?= $doctorName['name'] ?></h4>
              <a role="button" href="<?= url('admin/faq') ?>" class="btn btn-sm btn-secondary">
                بازگشت </i>
              </a>
            </div>
            <div class="box-body">

              <form method="post" action="<?= url('admin/faq/update/' . $id) ?>" enctype="multipart/form-data">
                <input type="hidden" name="doctor_id" value="<?= $id ?>"> <!-- doctor ID -->

                <div class="row" id="faq-container">
                  <?php foreach ($faqs as $key => $faq) { ?>
                    <div class="row mb-3 faq-item">
                      <input type="hidden" name="faq_id[]" value="<?= $faq['id'] ?>">
                      <div class="col">
                        <div class="form-group">
                          <label>سوال <?= $key + 1 ?> :</label>
                          <input type="text" class="form-control" name="ask[]" value="<?= $faq['ask'] ?>" required>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>جواب <?= $key + 1 ?> :</label>
                          <textarea class="form-control" name="answer[]" required><?= $faq['answer'] ?></textarea>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>

                <button type="button" class="btn btn-primary btn-sm mb-3" onclick="addFAQ()"><i
                    class="fas fa-plus-square fs-5"></i> افزودن سوال
                  جدید</button>
                <br>
                <button type="submit" class="btn btn-sm btn-success fw-bold fs-6">ذخیره</button>
              </form>

              <script>
                function addFAQ() {
                  const container = document.getElementById('faq-container');

                  const div = document.createElement('div');
                  div.className = 'row mb-3 faq-item';

                  div.innerHTML = `
      <input type="hidden" name="faq_id[]" value="">
      <div class="col">
        <div class="form-group">
          <label>سوال جدید :</label>
          <input type="text" class="form-control" name="ask[]" placeholder="سوال ..." required>
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <label>جواب جدید :</label>
          <textarea class="form-control" name="answer[]" placeholder="جواب ..." required></textarea>
        </div>
      </div>
      <div class="col-1 d-flex align-items-end">
        <button type="button" class="btn btn-danger btn-sm" onclick="removeFAQ(this)">✖</button>
      </div>
    `;

                  container.appendChild(div);
                }


                function removeFAQ(el) {
                  const faqItem = el.closest('.faq-item');

                  faqItem.remove();
                }

              </script>


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