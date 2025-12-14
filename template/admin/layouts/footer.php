<!-- Vendor JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= asset('public/admin-panel/src/js/vendors.min.js') ?>"></script>
<script src="<?= asset('public/admin-panel/assets/icons/feather-icons/feather.min.js') ?>"></script>
<script src="<?= asset('public/admin-panel/assets/vendor_components/apexcharts-bundle/apexcharts.min.js') ?>"></script>
<script src="<?= asset('public/admin-panel/style/js/dashboard-light.html') ?>"></script>
<script src="<?= asset('public/admin-panel/src/js/template.js') ?>"></script>
<script src="<?= asset('public/admin-panel/src/js/pages/dashboard.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
    integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'آیا مطمئنی؟',
            text: "این عملیات قابل بازگشت نیست!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'بله، حذفش کن!',
            cancelButtonText: 'نه، بیخیال'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?= url('admin/user/delete') ?>/${userId}`;
            }
        });
    }

    function confirmPostDelete(postId) {
        Swal.fire({
            title: 'آیا مطمئنی؟',
            text: "این عملیات قابل بازگشت نیست!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'بله، حذفش کن!',
            cancelButtonText: 'نه، بیخیال'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?= url('admin/post/delete/') ?>/${postId}`;
            }
        });
    }

    function confirmDeleteDoctor(docId) {
        Swal.fire({
            title: 'میخوای دکتر رو حذف  کنی ؟',
            text: "این کار غیرقابل بازگشته!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'بله، حذف کن!',
            cancelButtonText: 'نه، منصرف شدم'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?= url('admin/doctor/delete/') ?>/${docId}`;
            }
        });
    }
</script>

</body>

</html>