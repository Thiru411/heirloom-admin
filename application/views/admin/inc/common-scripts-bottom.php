<script>var AJAX_URL='<?php echo base_url()?>';</script>


<script src="<?=base_url();?>assets/admin/plugins/jquery/jquery.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url();?>assets/admin/dist/js/adminlte.min.js"></script>
<!-- <script src="<?=base_url();?>assets/admin/plugins/chart.js/Chart.min.js"></script> -->
<script src="<?=base_url();?>assets/admin/dist/js/demo.js"></script>
<!-- <script src="<?=base_url();?>assets/admin/dist/js/pages/dashboard3.js"></script> -->
<script src="<?=base_url();?>assets/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?=base_url();?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/select2/js/select2.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/moment/moment.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/toastr/toastr.min.js"></script>
<!-- <script src="<?=base_url();?>assets/admin/plugins/toastr/toastr.css"></script> -->
<script src="<?=base_url();?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/fullcalendar/main.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/fullcalendar-interaction/main.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/fullcalendar-bootstrap/main.min.js"></script>
<script src="<?=base_url();?>assets/custom/my.validations.js"></script>
<script src="<?=base_url();?>assets/custom/custom.js"></script>
<!-- <script src="assets/js/lib/Angular/angular-duallistbox/angular-bootstrap-duallistbox.js"></script>
    <script src="common/directives/bsDuallistbox/bsDuallistbox.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">

$(document).ready(function () {
  $.validator.setDefaults({
    submitHandler: function () {
     // alert( "Form successful submitted!" );
     document.myForm.submit();
    }
  });
  $('#quickForm').validate({
    rules: {
      vehicle_category: {
        required: true,
      },
      fule_type: {
        required: true,
      },
      vehicle_reg_number: {
        required: true
      },
       vehicle_name: {
        required: true
      },
      meter_reading: {
        required: true
      },
      vehicle_brand: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    
     $('#post_content').select2()
    
    $('#post_content1').select2()
    
    $('#post_content2').select2()
    
    $('#post_content3').select2()
    
    $('#post_content4').select2()
    
    $('#post_content5').select2()
    
    $('#post_content6').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT',
      autoclose: true
      
    })
    
    // //Bootstrap Duallistbox
    // $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<script>
  $(function () {
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
  });
</script> 
<script>
  $('#event_date').daterangepicker({
    singleDatePicker: true,
    minDate:new Date(),
    maxDate: true,
  });
</script>
<script> 
        setTimeout(function() {
            $('#msg_id').hide('fast');
        }, 10000);
        var time_zone=Intl.DateTimeFormat().resolvedOptions().timeZone;
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('set_time_zone')?>",
                    data:{time_zone:time_zone},
                    success: function (response){
                    
                    }
                     });
    </script>
    
