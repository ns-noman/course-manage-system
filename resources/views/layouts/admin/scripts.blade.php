
<!-- Dashboard-1 -->

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery -->
<script src="{{ asset('public/admin-assets') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/admin-assets') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>  $.widget.bridge('uibutton', $.ui.button) </script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/admin-assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{ asset('public/admin-assets') }}/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{ asset('public/admin-assets') }}/plugins/sparklines/sparkline.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('public/admin-assets') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/admin-assets') }}/plugins/moment/moment.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('public/admin-assets') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{ asset('public/admin-assets') }}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('public/admin-assets') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/admin-assets') }}/dist/js/adminlte.js"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('public/admin-assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/pdfmake/vfs_fonts.js"></script>

<!-- Select2 -->
<script src="{{ asset('public/admin-assets') }}/plugins/select2/js/select2.full.min.js"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true
        });

        $('.select2').select2();

    });

    $(document).ready(function(){
            $('.delete').click(function(e) {
                e.preventDefault();
                let element = $(this);
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed){
                        element.submit();
                    }
            });
        });
    });
</script>




<!-- bootstrap css and js -->



