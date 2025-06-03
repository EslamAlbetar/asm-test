<script type="text/javascript">
    function confirmation(ev) {
        ev.preventDefault();

        var urlToRedirect = ev.currentTarget.getAttribute('href');

        console.log(urlToRedirect);

        swal({
                title: "Are You Sure Delete This item?",
                text: "This Delete will be permanent",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })

            .then((willCancel) => {
                if (willCancel) {
                    window.location.href = urlToRedirect;
                }
            });
    }
</script>

<!-- Dashboard Waiting List -->
<script>
    // reuse الدالة لتحويل العدد للـ color class
    function getColorClass(count) {
        if (count <= 5) return 'badge-green';
        if (count <= 10) return 'badge-blue';
        if (count <= 15) return 'badge-purple';
        if (count <= 20) return 'badge-orange';
        return 'badge-red';
    }

    // تحدث Waiting List count
    function updateWaitingCount() {
        $.ajax({
            url: '/waiting-list-count',
            type: 'GET',
            success: function(res) {
                const cnt = res.count;
                const el = $('#waiting-count');
                if (el.length) {
                    el.text(cnt)
                        .removeClass('badge-green badge-blue badge-purple badge-orange badge-red')
                        .addClass(getColorClass(cnt));
                }
            }
        });
    }

    // جدولة التحديث كل 10 ثواني
    setInterval(updateWaitingCount, 3000);
    // تحديث أول ما الصفحة تفتح
    updateWaitingCount();
</script>


<!-- End of <body> -->
<!-- jQuery -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@4.0.1/dist/js/multi-select-tag.min.js"></script>
<script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
<script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
<script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('admincss/js/charts-home.js')}}"></script>
<script src="{{asset('admincss/js/front.js')}}"></script>
<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Dashboard patients today -->
<script>
    function getColor(percentage) {
        if (percentage < 25) return 'bg-danger';
        if (percentage < 50) return 'bg-warning';
        if (percentage < 75) return 'bg-info';
        return 'bg-success';
    }

    function updatePatientCount() {
        fetch('/today-patients-count')
            .then(response => response.json())
            .then(data => {
                const count = data.count;
                const target = 50;
                const percentage = Math.min((count / target) * 100, 100);

                // تحديث الرقم
                document.getElementById('today-count').innerText = count;

                // تحديث البار
                const progressBar = document.getElementById('progress-bar');
                progressBar.style.width = percentage + '%';
                progressBar.setAttribute('aria-valuenow', count);

                // تغيير اللون
                progressBar.className = 'progress-bar progress-bar-template ' + getColor(percentage);
            });
    }

    // أول تحميل
    updatePatientCount();

    // كل 30 ثانية
    setInterval(updatePatientCount, 3000);
</script>

{{-- تعديل اسم النظام --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // عرض نموذج التعديل عند الضغط على زر القلم
        $('#edit-name-btn').click(function() {
            $('#name-display').hide();
            $('#name-edit').show();
            $('#first_name').focus(); // تركيز المؤشر على أول حقل
        });

        // إلغاء التعديل
        $('#cancel-edit-btn').click(function() {
            $('#name-edit').hide();
            $('#name-display').show();
        });

        // حفظ التعديلات
        $('#save-name-btn').click(function() {
            const firstName = $('#first_name').val().trim();
            const secondName = $('#second_name').val().trim();
            const address = $('#address').val().trim();
            const phone = $('#phone').val().trim();

            // التحقق من عدم وجود حقول فارغة
            if (!firstName || !secondName || !address || !phone) {
                Swal.fire('خطأ!', 'الرجاء إدخال القيم في جميع الحقول', 'error');
                return;
            }

            Swal.fire({
                title: 'تأكيد التعديل',
                text: 'هل أنت متأكد من تغيير بيانات النظام بالكامل؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، تحديث',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("update.center.name") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            first_name: firstName,
                            second_name: secondName,
                            address: address,
                            phone: phone
                        },
                        success: function(response) {
                            if (response.success) {
                                // تحديث العرض
                                $('#name-display h2').text(firstName + ' ' + secondName + ' ' + address + ' ' + phone);
                                $('#name-edit').hide();
                                $('#name-display').show();

                                Swal.fire({
                                    title: 'تم!',
                                    text: 'تم تحديث الاسم بنجاح',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'حدث خطأ أثناء التحديث';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire('خطأ!', errorMessage, 'error');
                        }
                    });
                }
            });
        });

        // السماح بالضغط على زر Enter لحفظ التعديلات
        $('#name-edit input').keypress(function(e) {
            if (e.which === 13) { // 13 هو كود زر Enter
                $('#save-name-btn').click();
            }
        });
    });
</script>

<!-- تحديث اللون -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const usertypeSelect = document.getElementById('usertype-select');
        const colorInput = document.getElementById('color_code_input');

        function updateColorCode() {
            const selectedOption = usertypeSelect.options[usertypeSelect.selectedIndex];
            const color = selectedOption.getAttribute('data-color');
            colorInput.value = color;
        }

        // تحديث أول مرة لما الصفحة تفتح
        updateColorCode();

        // تحديث كل ما يتغير الاختيار
        usertypeSelect.addEventListener('change', updateColorCode);
    });
</script>
