<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong><a href="#">Uji Kompetensi</a> Tahun {{ Carbon\Carbon::now()->year }}.</strong>
  <div class="float-right d-none d-sm-inline-block">
    <b>Kasir Jojo</b>
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset ('')}}plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset ('')}}plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset ('')}}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{asset ('')}}plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{asset ('')}}plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{asset ('')}}plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{asset ('')}}plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset ('')}}plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{asset ('')}}plugins/moment/moment.min.js"></script>
<script src="{{asset ('')}}plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset ('')}}plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{asset ('')}}plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{asset ('')}}plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset ('')}}dist/js/adminlte.js"></script>

{{-- Jquery Block UI --}}
<script src="{{ asset('plugins/jquery-block-ui/jquery-blockui.min.js') }}"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset ('')}}dist/js/pages/dashboard.js"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

{{-- Autonumeric --}}
<script src="{{ asset('plugins/autonumeric/js/autonumeric.min.js') }}"></script>

{{-- Global Function  --}}
<script src="{{ asset('global.js') }}"></script>

{{-- Select2 --}}
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</body>
</html>