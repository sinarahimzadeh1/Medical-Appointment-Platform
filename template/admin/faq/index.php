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
              <h4 class="box-title">سوالات متداول</h4>
              <a role="button" href="<?= url('admin/') ?>" class="btn btn-sm btn-secondary">
                بازگشت </i>
              </a>
            </div>
            <div class="box-body">


              <div class="accordion" id="doctorsFaqAccordion">
                <?php
                foreach ($doctors as $index => $doctor) {
                  $doctorId = $doctor['id'];
                  $doctorName = htmlspecialchars($doctor['name']);
                  $faqs = $db->select("SELECT * FROM faq WHERE doctor_id = ?", [$doctorId])->fetchAll();
                  ?>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $index ?>">
                      <button class="accordion-button collapsed d-flex justify-content-between align-items-center"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>"
                        aria-expanded="false" aria-controls="collapse<?= $index ?>">
                        <?= $doctorName ?>
                      </button>
                    </h2>
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse"
                      aria-labelledby="heading<?= $index ?>" data-bs-parent="#doctorsFaqAccordion">
                      <div class="accordion-body">
                        <div class="d-flex justify-content-start mb-3">
                          <a href="<?= url('admin/faq/edit/' . $doctorId) ?>" class="btn btn-sm btn-primary">ویرایش
                            سوالات <i class="fa fa-edit"></i> </a>
                        </div>

                        <?php if (count($faqs) > 0) { ?>
                          <ul class="list-group">
                            <?php foreach ($faqs as $faq) { ?>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                  <strong>❓ سوال:</strong> <?= htmlspecialchars($faq['ask']) ?><br>
                                  <strong>✅ پاسخ:</strong> <?= htmlspecialchars($faq['answer']) ?>
                                </div>
                                <a href="<?= url('admin/faq/delete/' . $faq['id']) ?>" class="btn btn-sm btn-danger">حذف <i class="fa fa-trash"></i> </a>
                              </li>
                            <?php } ?>
                          </ul>
                        <?php } else { ?>
                          <p class="text-muted">سوالی برای این دکتر ثبت نشده است.</p>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>

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