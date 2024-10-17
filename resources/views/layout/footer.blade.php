</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('template/') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('template/') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{ asset('template/') }}/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{ asset('template/') }}/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{ asset('template/') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{ asset('template/') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('template/') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ asset('template/') }}/plugins/moment/moment.min.js"></script>
<script src="{{ asset('template/') }}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('template/') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{ asset('template/') }}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('template/') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/') }}/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('template/') }}/dist/js/demo.js"></script>
<script src="{{ asset('template/') }}/dist/js/pages/dashboard.js"></script>{{-- calender --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.querySelector('.download-btn').addEventListener('click', function() {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your file is downloading",
            showConfirmButton: false,
            timer: 1500
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id', // Mengatur bahasa menjadi Indonesia
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: '',
            },
            buttonText: {
                today: 'Hari Ini', // Mengubah label tombol "Today" menjadi "Hari Ini"
            },
            customButtons: {
                prev: {
                    text: '‹',
                    click: function() {
                        calendar.prev();
                    }
                },
                next: {
                    text: '›',
                    click: function() {
                        calendar.next();
                    }
                }
            },
            contentHeight: 'auto',
            themeSystem: 'bootstrap',
        });

        calendar.render();

        const calendarHeader = calendarEl.querySelector('.fc-header-toolbar');
        calendarHeader.querySelectorAll('.fc-prev-button, .fc-next-button, .fc-today-button').forEach(btn => {
            btn.classList.add('btn', 'btn-sm');
        });
        calendarHeader.querySelector('.fc-toolbar-title').classList.add('h6');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: '',
            },
        });

        calendar.render();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function generateKodeJurusan() {
            const kodeCells = document.querySelectorAll('tbody tr td:nth-child(2)');
            let latestKode = '';

            kodeCells.forEach(cell => {
                const kodeText = cell.textContent.trim();
                if (kodeText.startsWith('KJ') && kodeText.length === 16) {
                    latestKode = kodeText;
                }
            });

            if (latestKode) {
                const numericPart = latestKode.substring(2, 5);
                const incrementedNumber = (parseInt(numericPart, 10) + 1).toString().padStart(3, '0');

                const newKode = `KJ${incrementedNumber}${latestKode.substring(5)}`;

                document.getElementById('kode_jurusan_display').value = newKode;
                document.getElementById('kode_jurusan_hidden').value = newKode;
            } else {
                const defaultKode = 'KJ00119131121418';
                document.getElementById('kode_jurusan_display').value = defaultKode;
                document.getElementById('kode_jurusan_hidden').value = defaultKode;
            }
        }

        generateKodeJurusan();
    });
</script>
<script>
    setTimeout(function() {
        var alertElement = document.getElementById('success-alert');
        if (alertElement) {
            alertElement.remove();
        }
    }, 3000);

    let progressBar = document.getElementById('progress-bar');
    let width = 100;
    let interval = setInterval(function() {
        if (width <= 0) {
            clearInterval(interval);
        } else {
            width -= 1;
            progressBar.style.width = width + '%';
        }
    }, 30);
</script>
<script>
    const scrollableDiv = document.getElementById('scrollableDiv');

    function showCustomScrollbar() {
        scrollableDiv.style.scrollbarWidth = 'thin';
        scrollableDiv.style.setProperty('--scrollbar-width', '8px');

        scrollableDiv.style.setProperty('--scrollbar-color', 'black transparent');
        scrollableDiv.style.setProperty('--scrollbar-radius', '5px');

        clearTimeout(scrollableDiv.scrollTimer);

        scrollableDiv.scrollTimer = setTimeout(function() {
            scrollableDiv.style.setProperty('--scrollbar-width', '0px');
        }, 1000);
    }

    scrollableDiv.addEventListener('scroll', showCustomScrollbar);

    scrollableDiv.style.setProperty('--scrollbar-width', '0px');
    scrollableDiv.style.scrollbarWidth = 'none';
</script>


</body>

</html>
