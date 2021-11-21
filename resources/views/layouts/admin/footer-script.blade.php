<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('js/vendor/Chart.bundle.min.js')}}"></script>
<script src="{{ asset('js/vendor/chartjs-plugin-datalabels.js')}}"></script>
<script src="{{ asset('js/vendor/moment.min.js')}}"></script>
<script src="{{ asset('js/vendor/fullcalendar.min.js')}}"></script>
{{--  <script src="{{ asset('js/vendor/datatables.min.js')}}"></script>  --}}
<script src="{{ asset('js/bootstrap-datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datatable/js/jszip.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datatable/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('js/bootstrap-datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datatable/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{ asset('js/vendor/perfect-scrollbar.min.js')}}"></script>
<script src="{{ asset('js/vendor/bootstrap-notify.min.js') }}" style="opacity: 1;"></script>
<script src="{{ asset('js/vendor/progressbar.min.js')}}"></script>
<script src="{{ asset('js/vendor/jquery.barrating.min.js')}}"></script>
<script src="{{ asset('js/vendor/select2.full.js')}}"></script>
<script src="{{ asset('js/vendor/nouislider.min.js')}}"></script>
<script src="{{ asset('js/vendor/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('js/vendor/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{ asset('js/vendor/jquery.validate/jquery.validate.min.js')}}"></script>
<script src="{{ asset('js/vendor/jquery.validate/additional-methods.min.js')}}"></script>
<script src="{{ asset('js/vendor/Sortable.js')}}"></script>
<script src="{{ asset('js/vendor/baguetteBox.min.js') }}"></script>

{{-- <script src="{{ asset('js/vendor/cropper.min.js') }}"></script> --}}

<script src="{{ asset('js/vendor/mousetrap.min.js')}}"></script>
<script src="{{ asset('js/vendor/glide.min.js')}}"></script>
<script src="{{ asset('js/dore.script.js')}}"></script>
<script src="{{ asset('js/scripts.js')}}"></script>
<script src="{{ asset('js/crud-ajax.js')}}"></script>




@yield('js')
<script>
  var app_url = "{{ url('/') }}";
  var lang = "{{ app()->getLocale() }}";
</script>

<script>


    $(document).ready(function() {
        //Default data table
        $('#default-datatable').DataTable();


        var table = $('#example').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
        } );

        table.buttons().container()
            .appendTo( '#example_wrapper .col-md-6:eq(0)' );

    } );
    
</script>

