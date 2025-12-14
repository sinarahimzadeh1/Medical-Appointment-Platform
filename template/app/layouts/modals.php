
<!-- reserve Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title mb-0" id="bookingModalLabel">
          انتخاب نوبت مطب <span class="doc-clinic"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
      </div>

      <div class="d-flex align-items-center">
        <img src="" alt="" class="rounded-circle mx-4 doc-profile my-3"
          style="width: 100px; height: 100px; object-fit: cover;">
        <div class="text-end w-100">
          <h5 class="mb-1 fw-bold mt-2">دکتر <span class="doc-name"></span></h5>
          <p class="text-muted mb-0 my-1 mt-2">
            <i class="fas fa-map-marker-alt ms-2 text-success"></i><span class="doc-location"></span>
          </p>
          <p class="text-muted small mb-0 my-1"><i class="fas fa-cut ms-2 fs-6 text-warning "></i>تخصص : <span
              class="doc-expert"></span></p>
        </div>
      </div>

		<div id="have-reserve">
			<div class="swiper mySwiper" style="padding: 10px;">
				<div class="swiper-wrapper">
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
		
      		<div id="fixed-details" class="text-center my-4 fixed-details"></div>
		</div>
    </div>
  </div>
</div>

<!-- Confirm Modal  -->
<div class="modal fade" id="confirmTimeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title">رزرو وقت از دکتر <span class="doc-name"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p><span id="selected-time-text"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">خیر</button>
        <button type="button" class="btn btn-primary" id="confirm-time-btn">تأیید</button>
      </div>
    </div>
  </div>
</div>