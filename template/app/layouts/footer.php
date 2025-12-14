<!-- login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content text-start">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title">ورود</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <form id="login-form" action="" method="POST">

          <div class="text-center">
            <p>ورود یا ثبت‌ نام</p>
            <p>برای ادامه لطفا شماره موبایل خود را وارد کنید.</p>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">+98</span>
            <input type="text" class="form-control" name="number" placeholder="مثال : 0000 000 912"
              aria-describedby="basic-addon1">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="far fa-user"></i></span>
            <input type="text" class="form-control" name="username" placeholder="مثال : سینا رحیم زاده"
              aria-describedby="basic-addon1">
          </div>

          <input type="submit" name="login" class="btn btn-primary w-100 mt-2" value="ادامه">

        </form>

      </div>
    </div>
  </div>
</div>

<?php
if (currentUrl() === url('/') || currentUrl() === url('/home') || currentUrl() === url('/contact-us')) {
  $link = '<a href="#" data-bs-toggle="modal" data-bs-target="#bookingModal">رزرو نوبت</a>';
} else {
  $link = '<a href="' . url('/') . '#reserve">رزرو نوبت</a>';
}

if (isset($_SESSION['number']))
  $admin = $db->select("SELECT * FROM doctors WHERE number =  ?", [$_SESSION['number']])->fetch();
?>

<div class="arrow-up"></div>
<footer class="site-footer pt-3">
  <div class="footer-top mb-5">
    <div class="footer-section nav-section">
      <h3>بخش‌های سایت&nbsp;&nbsp;<i class="fa fa-angle-left fs-6"></i></h3>
      <ul>
        <li><a href="<?= url('/') ?>">صفحه اصلی</a></li>
        <li>
          <?= $link ?>
        </li>
        <?php if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])) { ?>
          <li>
            <a href=<?= url("blog") ?>>بلاگ</a>
          </li>
        <?php } ?>
        <?php foreach ($menus as $menu) { ?>
          <li>
            <a href="<?= url($menu['url']) ?>"><?= $menu['name'] ?></a>
          </li>
        <?php } ?>
        <?php if (isset($_SESSION['username'])) { ?>
          <li>
            <a>
              کاربر <?= $_SESSION['username'] ?>
            </a>
          </li>

        <?php } else { ?>
          <li>
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
              ورود / ثبت نام
            </a>
          </li>

        <?php } ?>
      </ul>
    </div>

    <div class="footer-section text-center footer-logo">
      <img src="<?= asset($setting['logo']) ?>" alt="Clinic Logo">
      <p class="footer-desc"><?= $setting['footer_text'] ?></p>
    </div>

    <div class="footer-section">
      <h3>اطلاعات تماس&nbsp;&nbsp;<i class="fa fa-angle-left fs-6"></i></h3>
      <div class="contact-card"><i class="fa fa-location-dot"></i>&nbsp; <?= $setting['main_loc_address'] ?></div>
      <div class="contact-card"><i class="fa fa-envelope"></i>&nbsp; <?= $setting['main_email_address'] ?></div>
      <div class="contact-card"><i class="fa fa-phone"></i>&nbsp;&nbsp;<span class="d-ltr">
          <?= $setting['main_number_address'] ?></span></div>
    </div>
  </div>


  <div class="footer-top my-5">
    <div class="footer-section nav-section text-justify" style="max-width: 550px;">
      <h3><?= $setting['web_desc_title'] ?> &nbsp;&nbsp;<i class="fa fa-angle-left fs-6"></i></h3>
      <span>
        <?= $setting['web_description'] ?>
      </span>
    </div>

    <div class="footer-section">
      <h3>راه‌های ارتباطی&nbsp;&nbsp;<i class="fa fa-angle-left fs-6"></i></h3>
      <a>
        <div class="contact-card"><i class="fab fa-instagram"></i>&nbsp; <?= $setting['socialmedia_1'] ?></div>
      </a>
      <a>
        <div class="contact-card"><i class="fab fa-linkedin"></i>&nbsp; <?= $setting['socialmedia_2'] ?></div>
      </a>
      <a>
        <div class="contact-card"><i class="fa fa-phone"></i>&nbsp;&nbsp;<span class="d-ltr">
            <?= $setting['socialmedia_3'] ?></span></div>
      </a>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="footer-bottom-content">
      <div class="social-icons">
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-telegram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
      </div>

      <p class="footer-text" style="margin-bottom: 5px;">
        &copy; 2025
        طراحی شده با ❤️ توسط
        <a href="https://www.instagram.com/thesina_r/" target="_blank">thesina-r</a>
      </p>
    </div>
  </div>

</footer>


<button id="topBtn" onclick="scrollToTop()"><i class="fa fa-angle-up"></i></button>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"
  integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
  integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

  // Posts Swiper
  var swiperPosts = new Swiper('.mySwiperPosts', {
    spaceBetween: 5,
    loop: false,
    navigation: {
      nextEl: '.swiper-next-posts',
      prevEl: '.swiper-prev-posts',
    },
    breakpoints: {
      768: { slidesPerView: 2 },
      992: { slidesPerView: 3 },
      1200: { slidesPerView: 4 }
    },
    paginationClickable: true,
  });


  let currentDoctorId = <?= $_SESSION['dataID'] ?? 1 ?>; // مقدار اولیه
  // تابع برای بارگذاری لیست روزهای دکتر
  function loadDatesForDoctor(doctorId) {
    fetch('<?= url('get-dates') ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'doctor_id=' + encodeURIComponent(doctorId)
    })
      .then(res => res.text())
      .then(html => {
        // جایگزینی HTML جدید برای تاریخ‌ها
        $('.mySwiper .swiper-wrapper').html(html);

        // به‌روزرسانی اسلایدر
        swiperDate.update();

        // انتخاب و کلیک روی اولین تاریخ موجود
        $('.mySwiper .swiper-slide:first').trigger('click');
      })
      .catch(err => {
        console.error("خطا در گرفتن تاریخ‌ها:", err);
      });
  }

  // ایونت داینامیک برای کلیک روی تاریخ‌ها (بعد از آپدیت DOM همچنان کار می‌کنه)
  $('.mySwiper').on('click', '.swiper-slide', function () {
    selectedDate = $(this).data('date');

    $('.mySwiper .swiper-slide').removeClass('active');
    $(this).addClass('active');

    $('#fixed-details').html('در حال بارگذاری...');

    fetch(`<?= url('get-time') ?>?ajax=1&date=${encodeURIComponent(selectedDate)}&doctor_id=${encodeURIComponent(currentDoctorId)}`)
      .then(response => response.text())
      .then(data => {
        $('#fixed-details').html(data);
      })
      .catch(() => {
        $('#fixed-details').html('<div class="text-danger">خطا در بارگذاری اطلاعات</div>');
      });
  });

  // وقتی روی دکمه ارسال کلیک می‌کنیم (انتخاب دکتر)
  $('.send').click(function () {
    const doctorId = $(this).data('id');
    currentDoctorId = doctorId;

    // ذخیره doctor_id در سشن سمت سرور
    fetch('<?= url('send') ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'dataId=' + encodeURIComponent(doctorId)
    })
      .then(response => response.json())
      .then(result => {
        if (result.error) {
          document.getElementById('reserve-info').textContent = 'رزروی وجود ندارد';
          return;
        }

        const text = (result.isTomorrow ? 'فردا' : result.date) + ' | ' + result.time;
        document.getElementById('reserve-info').textContent = text;

        // بارگذاری تاریخ‌های مربوط به دکتر انتخاب شده
        loadDatesForDoctor(doctorId);
      })
      .catch(err => {
        console.error("خطا در ارسال اطلاعات:", err);
      });
  });

  // (اختیاری) بارگذاری اولیه برای doctorId اولیه
  $(document).ready(function () {
    loadDatesForDoctor(currentDoctorId);
    $('.send').first().trigger('click');
  });


  var swiperDate = new Swiper('.mySwiper', {
    slidesPerView: 3,
    spaceBetween: 10,
    freeMode: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      768: { slidesPerView: 4 },
      992: { slidesPerView: 6 },
      1200: { slidesPerView: 7 }
    }
  });


  firstSwiperBlog = new Swiper(".mySwiper2", {
    spaceBetween: 15,
    loop: false,
    freeMode: false,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      768: { slidesPerView: 1 },
      992: { slidesPerView: 3 },
      1200: { slidesPerView: 4 },
    },
    pagination: {
      el: ".swiper-pagination",
      dynamicBullets: true,
    },
  });


  // blog category swipper
  let swiper = null;

  function initializeSwiper() {
    if (swiper && typeof swiper.destroy === 'function') {
      swiper.destroy(true, true);
      swiper = null;
    }

    swiper = new Swiper(".mySwiper1", {
      spaceBetween: 15,
      loop: false,
      freeMode: false,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        768: { slidesPerView: 1 },
        992: { slidesPerView: 3 },
        1200: { slidesPerView: 4 },
      },
      pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
      },
    });

    // اطمینان از بازگشت به اسلاید اول
    if (swiper && typeof swiper.slideTo === 'function') {
      swiper.slideTo(0, 0); // 0ms برای رفتن سریع
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const categorySelect = document.getElementById('category-select');
    const postContainer = document.getElementById('post-container');

    if (!categorySelect || !postContainer) return;

    const loadPostsByCategory = (category) => {
      fetch('<?= url("get-posts") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ category })
      })
        .then(res => res.text())
        .then(html => {
          postContainer.innerHTML = html;
          initializeSwiper();
        })
        .catch(err => {
          console.error("خطا در بارگذاری پست‌ها:", err);
          postContainer.innerHTML = `<p style="color:red;">خطا در بارگذاری پست‌ها</p>`;
        });
    };

    // بارگذاری اولیه
    loadPostsByCategory(categorySelect.value);

    // روی تغییر دسته‌بندی
    categorySelect.addEventListener('change', () => {
      loadPostsByCategory(categorySelect.value);
    });
  });


  // Submit Time
  $('#confirmTimeModal').on('shown.bs.modal', function () {
    $(this).addClass('custom-backdrop');
  });
  $('#confirmTimeModal').on('hidden.bs.modal', function () {
    $(this).removeClass('custom-backdrop');
  });

  // Login Form
  $('#loginModal').on('shown.bs.modal', function () {
    $(this).addClass('custom-backdrop');
  });
  $('#loginModal').on('hidden.bs.modal', function () {
    $(this).removeClass('custom-backdrop');
  });


  // Change background color of text
  $(window).on('load', function () {
    const colorThief = new ColorThief();

    $('.color-image').each(function () {
      const img = this;
      const $img = $(this);
      let $text = null;

      if ($img.closest('.carousel-item').length) {
        $text = $img.closest('.carousel-item').find('.dynamic-bg');
      } else if ($img.closest('.card').length) {
        $text = $img.closest('.card').find('.dynamic-bg');
      }

      if (!$text || !$text.length) return;

      if (img.complete) {
        setColor(img, $text);
      } else {
        $img.on('load', function () {
          setColor(img, $text);
        });
      }
    });

    function setColor(img, $text) {
      try {
        const color = colorThief.getColor(img);
        const [r, g, b] = color;
        const bgColor = `rgb(${r}, ${g}, ${b})`;

        $text.css('background-color', bgColor);

        const luminance = (0.299 * r + 0.587 * g + 0.114 * b);
        $text.css('color', luminance > 180 ? 'black' : 'white');
      } catch (e) {
        $text.css({
          backgroundColor: '#444',
          color: 'white'
        });
      }
    }

  });


  // Change background color of doctor profile
  const colorThief = new ColorThief();
  document.addEventListener("DOMContentLoaded", function () {
    const observer = new MutationObserver(function (mutationsList) {
      mutationsList.forEach(mutation => {
        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
          const target = mutation.target;
          if (target.classList.contains('doctor-card')) {
            updateCardStyle(target);
          }
        }
      });
    });

    document.querySelectorAll('.doctor-card').forEach(card => {
      observer.observe(card, { attributes: true });
    });

    function updateCardStyle(card) {
      const imageElement = card.querySelector('.color-image2');
      const dynamicBgElement = card.querySelector('.dynamic-bg');

      const defaultColor = 'rgb(72, 119, 229)';

      if (!imageElement) return;

      // وقتی selected داره
      if (card.classList.contains('selected')) {
        let rgbColor = defaultColor;

        try {
          const color = colorThief.getColor(imageElement);
          rgbColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
        } catch (err) {
          console.warn("خطا در گرفتن رنگ. استفاده از رنگ پیش‌فرض.");
        }

        if (dynamicBgElement) {
          dynamicBgElement.style.backgroundColor = rgbColor;
        }

        card.style.background = `linear-gradient(61deg, rgb(255 255 255) 0%, ${rgbColor} 100%)`;
        card.style.border = "1px solid rgb(253 253 253)";
      } else {
        // وقتی selected برداشته میشه، استایل‌ها ریست بشن
        card.style.background = "";
        card.style.border = "";

        if (dynamicBgElement) {
          dynamicBgElement.style.backgroundColor = "";
        }
      }
    }

    // اولین بار هم بررسی کنیم
    document.querySelectorAll('.doctor-card.selected').forEach(card => {
      updateCardStyle(card);
    });
  });


  // active menu
  $(document).ready(function () {
    function bindMenuEvents() {
      if ($(window).width() > 991) {
        $('.menu-active').off('mouseenter mouseleave click');
        $('.menu-active').hover(
          function () {
            $(this).find('.submenu-box').stop(true, true).fadeIn(200);
          },
          function () {
            $(this).find('.submenu-box').stop(true, true).fadeOut(200);
          }
        );
      } else {
        $('.menu-active').off('mouseenter mouseleave click');
        $('.menu-active').on('click', function (e) {
          var $submenu = $(this).find('.submenu-box');
          if ($submenu.length) {
            e.preventDefault(); // فقط اگر زیرمنو داریم
            $('.submenu-box').not($submenu).slideUp(200);
            $submenu.stop(true, true).slideToggle(200);
          }
        });
      }
    }

    bindMenuEvents();

    $(window).on('resize', function () {
      bindMenuEvents();
    });
  });


  // top button
  let topButton = $("#topBtn");
  topButton.hide();
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      topButton.show();
    } else {
      topButton.hide();
    }
  });
  topButton.click(function () {
    $('html, body').animate({ scrollTop: 0 }, 'smooth');
  });


  // reserve float cart
  document.addEventListener("DOMContentLoaded", function () {
    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    const confirmTimeModal = new bootstrap.Modal(document.getElementById('confirmTimeModal'));
    const selectedTimeText = document.getElementById('selected-time-text');

    let selectedTime = "";
    let selectedDate = "";
    let selectedId = "";
    let selectedPrice = "";

    // تابع گرفتن تاریخ از اسلاید فعال
    function updateSelectedDateFromActive() {
      const activeSlide = document.querySelector(".swiper-slide.active-date");
      selectedDate = activeSlide ? activeSlide.dataset.date || "" : "";
    }

    // مقداردهی اولیه (در صورت وجود اسلاید)
    function initializeFirstSlideSelection() {
      const initialSlides = document.querySelectorAll(".mySwiper .swiper-slide");
      if (initialSlides.length > 0) {
        initialSlides[0].classList.add("active-date");
        selectedDate = initialSlides[0].dataset.date || "";
      }
    }

    // 📌 این قسمت برای وقتی هست که تاریخ‌ها بعداً با fetch لود می‌شن
    document.querySelector(".mySwiper").addEventListener("click", function (e) {
      const slide = e.target.closest(".swiper-slide");
      if (slide) {
        document.querySelectorAll(".swiper-slide").forEach(s => s.classList.remove("active-date"));
        slide.classList.add("active-date");
        selectedDate = slide.dataset.date || "";
      }
    });

    // کلیک روی تایم‌ها
    document.body.addEventListener("click", function (e) {
      const timeTarget = e.target.closest(".time-item");
      if (timeTarget) {
        selectedTime = timeTarget.dataset.time;
        selectedId = timeTarget.dataset.id;
        selectedPrice = timeTarget.dataset.price;

        // اگه selectedDate هنوز مقدار نگرفته، بگیرش
        if (!selectedDate) {
          updateSelectedDateFromActive();
        }

        fetch("<?= url('check-login') ?>")
          .then(response => response.json())
          .then(result => {
            if (result.needtologin) {
              loginModal.show();
            } else if (result.confirmTime) {
              const hour = parseInt(selectedTime.split(":")[0]);
              let partOfDay = hour < 12 ? "صبح" : "بعد از ظهر";
              selectedTimeText.innerHTML = `
              رزرو وقت در ساعت <strong>${selectedTime}</strong> (${partOfDay}) 
              و تاریخ <strong style="direction: rtl; display: inline-block;">${selectedDate}</strong> 
              به قیمت <strong>${selectedPrice}</strong> تومان
            `;
              confirmTimeModal.show();
            }

            if (result.redirect) {
              window.location.href = result.redirect;
            }
          });
      }
    });

    // حالا اینجا event listener مربوط به دکمه تایید
    document.getElementById('confirm-time-btn').addEventListener('click', () => {
      fetch("<?= url('reserve') ?>", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: selectedId })
      })
        .then(response => response.json())
        .then(data => {
          if (data.error_) {
            console.log(data.error_);
          }
          if (data.successReserved) {
            confirmTimeModal.hide();
            window.location.href = data.redirect;
          }
        });
    });


    // اجرای مقداردهی اولیه
    initializeFirstSlideSelection();
  });


  // register Form float cart
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('login-form');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const phone = form.querySelector('[name="number"]').value.trim();
      const username = form.querySelector('[name="username"]').value.trim();

      const modalBody = form.parentElement;

      fetch("<?= url('register/store') ?>", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `number=${encodeURIComponent(phone)}&username=${encodeURIComponent(username)}`
      })

        .then(response => response.json())
        .then(data => {

          if (data.closeModals) {
            const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            const bookingModal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
            if (loginModal) loginModal.hide();
            if (bookingModal) bookingModal.hide();
          }

          if (data.redirect) {
            window.location.href = data.redirect;
          }

          if (data.showVerifyForm) {
            const modalBody = document.querySelector('#loginModal .modal-body');
            modalBody.innerHTML = `
    <form id="verify-form" action="" method="POST">
      <div class="text-center">
        <p>کد تأیید</p>
        <p>کدی که به شماره <strong>${data.phone}</strong> ارسال شده رو وارد کن.</p>
      </div>
      <div class="d-flex justify-content-center gap-2 mb-2 d-ltr">
        ${[...Array(5)].map(() => `
          <input type="text" maxlength="1" class="form-control text-center code-input"
            style="width: 50px; height: 60px; font-size: 24px;" />
        `).join('')}
      </div>

      <input type="hidden" name="code" id="full-code">
      <input type="submit" name="complete_reg" class="btn btn-success w-100 mt-2 rounded-2" value="تأیید">

      <div class="text-center mt-2">
        <button type="button" id="resendCode" class="btn btn-primary w-100 d-flex justify-content-center align-items-center gap-2 rounded-2" disabled style="opacity: 0.6; cursor: not-allowed; font-weight: 600;" >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
            <path d="M8 1.5a.5.5 0 0 1 .5.5v3l2-2-.707-.707L8 3.793V2a.5.5 0 0 1 .5-.5z" />
          </svg>
          ارسال مجدد کد
          <span id="timer" style="font-family: monospace; font-weight: 700; margin-left: 8px; min-width: 50px; text-align: center;">
            02:00
          </span>
        </button>
      </div>

    </form>
  `;

            const inputs = document.querySelectorAll('.code-input');
            if (inputs.length > 0) inputs[0].focus();

            inputs.forEach((input, index) => {
              input.addEventListener('input', (e) => {
                const value = e.target.value;
                if (value.length === 1 && index < inputs.length - 1) inputs[index + 1].focus();
                updateFullCode();
              });
              input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                  inputs[index - 1].focus();
                }
              });
            });

            function updateFullCode() {
              const code = Array.from(inputs).map(input => input.value).join('');
              document.getElementById('full-code').value = code;
            }

            const resendBtn = document.getElementById('resendCode');
            const timerSpan = document.getElementById('timer');
            let timerInterval = null;

            let clickCount = parseInt(localStorage.getItem('resendClickCount')) || 1;
            const baseDuration = 120;

            function startTimer(duration) {
              clearInterval(timerInterval);

              let countdown = duration;
              updateDisplay(countdown);

              resendBtn.disabled = true;
              resendBtn.style.opacity = '0.6';
              resendBtn.style.cursor = 'not-allowed';

              timerInterval = setInterval(() => {
                countdown--;
                updateDisplay(countdown);

                if (countdown <= 0) {
                  clearInterval(timerInterval);
                  resendBtn.disabled = false;
                  resendBtn.style.opacity = '1';
                  resendBtn.style.cursor = 'pointer';
                  timerSpan.textContent = "ارسال مجدد";

                  // ریست clickCount بعد از تموم شدن تایمر
                  clickCount = 1;
                  localStorage.setItem('resendClickCount', clickCount);
                }
              }, 1000);
            }


            function updateDisplay(countdown) {
              const minutes = String(Math.floor(countdown / 60)).padStart(2, '0');
              const seconds = String(countdown % 60).padStart(2, '0');
              timerSpan.textContent = `${minutes}:${seconds}`;
            }

            // شروع اولیه تایمر
            startTimer(baseDuration);

            resendBtn.addEventListener('click', () => {
              clickCount++;
              localStorage.setItem('resendClickCount', clickCount);

              const newDuration = baseDuration + (clickCount - 1) * 60;

              fetch("<?= url('auth/resend') ?>", {
                method: 'POST'
              })
                .then(res => res.json())
                .then(result => {
                  if (result.status === 'success') {
                    console.log('کد مجدد ارسال شد');
                    startTimer(newDuration); // اینجا تایمر رو با مدت جدید استارت بزن
                  } else {
                    console.error(result.message || "خطا در ارسال مجدد");
                  }
                })
                .catch(err => {
                  console.error("خطا در ارسال مجدد:", err);
                });
            });


            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            document.getElementById('loginModal').addEventListener('hidden.bs.modal', function () {
              fetch("<?= url('auth/abort') ?>", {
                method: "POST"
              })
                .then(response => response.json())
                .then(result => {
                  window.location.href = result.redirect;
                });
            });

            document.getElementById('verify-form').addEventListener('submit', function (e) {
              e.preventDefault();
              const code = this.querySelector('[name="code"]').value.trim();

              fetch("<?= url('auth/number') ?>", {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `code=${encodeURIComponent(code)}`
              })
                .then(response => response.json())
                .then(result => {
                  window.location.href = result.redirect;
                });
            });

          }
          if (data.loggedin) {
            window.location.href = result.redirect;
          }
        })
        .catch(err => {
          console.error("خطا در ارتباط با سرور:", err);
        });


    });
  });


  // منوی کشویی در هدر
  $('header .burger-menu').click(function () {
    const responsiveMenu = $('#responsive-navigation');
    responsiveMenu.animate({ right: 0 }, 300);
    $('body').append('<div class="back-container"></div>');
    $('.back-container').click(function () {
      responsiveMenu.animate({ right: '-300px' }, 300);
      $(this).remove();
    });
  });

  // Chosing doctors
  let mapDesktop, markerDesktop;
  let mapMobile, markerMobile;
  $(document).ready(function () {
    const hasDesktopMap = $('#map-desktop').length > 0;
    const hasMobileMap = $('#map-mobile').length > 0;

    function initMap(containerId, coordsStr, isMobile = false) {
      const [lat, lon] = coordsStr.split(',').map(parseFloat);
      const mapObj = L.map(containerId, {
        center: [lat, lon],
        zoom: 17,
        zoomControl: false,
        dragging: true,
        scrollWheelZoom: true,
        doubleClickZoom: false,
        boxZoom: false,
        keyboard: false,
        tap: false,
        touchZoom: false
      });

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 17
      }).addTo(mapObj);

      // گرفتن آدرس از طریق reverse geocoding
      fetch(`https://api.neshan.org/v5/reverse?lat=${lat}&lng=${lon}`, {
        headers: {
          'Api-Key': 'service.b1e11ae1a2c14e78a7a25637b133c6d2'
        }
      })
        .then(response => response.json())
        .then(data => {
          const address = data.formatted_address || 'آدرس پیدا نشد';
          const marker = L.marker([lat, lon]).addTo(mapObj)
            .bindPopup(address)
            .openPopup();

          // ذخیره متغیرها
          if (isMobile) {
            mapMobile = mapObj;
            markerMobile = marker;
          } else {
            mapDesktop = mapObj;
            markerDesktop = marker;
          }
        })
        .catch(error => {
          console.error("خطا در دریافت آدرس:", error);
        });

      setTimeout(() => {
        mapObj.invalidateSize();
      }, 300);
    }


    function updateMap(mapObj, coordsStr, oldMarker, isMobile = false) {
      const [lat, lon] = coordsStr.split(',').map(parseFloat);
      mapObj.setView([lat, lon], 17);

      if (oldMarker) {
        mapObj.removeLayer(oldMarker);
      }

      fetch(`https://api.neshan.org/v5/reverse?lat=${lat}&lng=${lon}`, {
        headers: {
          'Api-Key': 'service.b1e11ae1a2c14e78a7a25637b133c6d2'
        }
      })
        .then(response => response.json())
        .then(data => {
          const address = data.formatted_address || 'آدرس پیدا نشد';
          const marker = L.marker([lat, lon]).addTo(mapObj)
            .bindPopup(address)
            .openPopup();

          if (isMobile) {
            markerMobile = marker;
          } else {
            markerDesktop = marker;
          }
        })
        .catch(error => {
          console.error("خطا در دریافت آدرس:", error);
        });
    }


    // for ajax
    function loadDoctorData(doctor) {
      const profile = doctor.data('profile');
      const name = doctor.data('name');
      const id = doctor.data('id');
      const clinic = doctor.data('clinic');
      const expert = doctor.data('expert');
      const docNumber = doctor.data('doc_number');
      const experience = doctor.data('experience');
      const location = doctor.data('location');
      const surgeryPhone = doctor.data('phone');
      const coords = doctor.data('coords');
      const services = doctor.data('services');
      const like = doctor.data('likes');
      const score = doctor.data('score');
      const reserves = doctor.data('reserves');
      const assetBase = "<?= asset('') ?>";

      $(".doc-profile").attr('src', assetBase + profile);
      $(".doc-name").text(name);
      $(".doc-id").text(id);
      $(".doc-expert").text(expert);
      $("#doc-number").text(docNumber);
      $("#doc-experience").text(experience);
      $(".doc-location").text(location);
      $(".doc-clinic").text(clinic);
      $("#doc-phone").text(surgeryPhone);
      $("#doc-like").text(like);
      $("#doc-score").text(score);
      $("#doc-reserves").text(reserves);

      const servicesArray = services ? services.split(',') : [];
      let servicesHtml = '';
      servicesArray.forEach(service => {
        servicesHtml += `<span class="badge bg-light text-dark border m-1">${service.trim()}</span>`;
      });
      $(".doc-services").empty().append(servicesHtml);

      if (hasDesktopMap && mapDesktop) {
        markerDesktop = updateMap(mapDesktop, coords, markerDesktop);
      }
      if (hasMobileMap && mapMobile) {
        markerMobile = updateMap(mapMobile, coords, markerMobile);
      }


      if (coords && typeof coords === "string" && coords.includes(',')) {
        const [lat, lon] = coords.split(',').map(s => s.trim());
        const neshanLink = `https://neshan.org/maps/routing/car/destination/${lat},${lon}`;
        const linkElement = document.getElementById("onNeshanMap");
        if (linkElement) {
          linkElement.setAttribute("href", neshanLink);
        }
      }

    }


    const firstDoctor = $('.doctor-selectable').first();
    const coords = firstDoctor.data('coords');

    if (hasDesktopMap) initMap('map-desktop', coords, false);
    if (hasMobileMap) initMap('map-mobile', coords, true);

    if (firstDoctor.length > 0) {
      firstDoctor.addClass('selected');
      loadDoctorData(firstDoctor);
    }

    $(document).on('click', '.doctor-selectable', function () {
      $('.doctor-selectable').removeClass('selected');
      $(this).addClass('selected');
      loadDoctorData($(this));
    });

  });


  // show Modals
  $(document).ready(function () {
    const modal = new bootstrap.Modal($('#bookingModal')[0]);

    $('#btn-book').click(function () {
      modal.show();
    });

    $('#bookingModal').on('show.bs.modal', function () {
      $('#main-content').addClass('blurred');
    });

    $('#bookingModal').on('hidden.bs.modal', function () {
      $('#main-content').removeClass('blurred');
    });
  });


  // starts rating
  document.querySelectorAll('.star-rating input').forEach(function (radio) {
    radio.addEventListener('change', function () {
      var rating = this.value;
      const postId = document.querySelector('.star-rating').getAttribute('data-post-id');


      fetch('<?= url('save-rate') ?>', {
        method: 'POST',  // تغییر متد به POST
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'rating=' + rating + '&post_id=' + postId
      })
        .then(response => {
          return response.text();
        })
        .then(text => {
          try {
            const result = JSON.parse(text);
            if (result.status === 'error') {
              console.log('خطا: ' + result.message);
            }
            if (result.needtologin) {
              loginModal.show();
            }

            if (result.redirect) {
              window.location.href = result.redirect;
            }
          } catch (e) {
            console.log(e);
          }
        })
        .catch(error => {
          console.log(error);
        });

    });
  });



  // حذف فلش‌ها از DOM بعد از انیمیشن
  setTimeout(() => {
    document.querySelectorAll('.flash-toast').forEach(el => el.remove());
  }, 5000);



  /* lazy blur loading image */
  document.addEventListener("DOMContentLoaded", function () {
    const lazyImages = document.querySelectorAll("img.lazy-img");

    lazyImages.forEach(img => {
      img.addEventListener("load", () => {
        img.classList.add("loaded");
      });

      // برای مرورگرهایی که ممکنه تصویر قبلاً لود شده باشه
      if (img.complete) {
        img.classList.add("loaded");
      }
    });
  });


</script>

</body>

</html>

<!-- Have project? BETTER CALL thesina-r : 09159702153 -->