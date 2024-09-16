<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Heirloom |inventory</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

 
  <?php $this->load->view('admin/inc/common-scripts-top.php'); ?>

</head>

<body class="sidebar-collapse layout-top-nav layout-navbar-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php $this->load->view('admin/inc/nav-top.php'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php //$this->load->view('admin/inc/nav-side.php');
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>inventory</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>add-inventory">Inventory</a></li>
                <li class="breadcrumb-item active">Add</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

    
      <!-- Main content -->
      <section class="content">
        <div class="container fluid">
        <span id="msg_id" style='color:red;line-height: 20px;text-align: right;font-size: 14px; display: inline-block; margin-bottom:10px'><?php echo $this->session->flashdata('message'); ?></span>
          <div class="row">



            <div class="col-md-12"> 
 

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Add Inventory</h3>
                </div>
                <form role="form" id="quickForm" name="myForm" action="<?=base_url()?>inventory-details/Add/Save" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
              <div class="form-group">
                  <label>Inventory Title:</label>
                  <input type="text" class="form-control" name="title" id="title" required placeholder="Title"> 
                </div>  
                <div class="form-group">
                  <label>Mature Size:</label>
                  <input type="text" class="form-control" name="mature_size" id="title" required placeholder="50’w x 30’ height"> 
                </div>  
                <?php $var=''; if($categoryDetails){foreach($categoryDetails as $info){ 
                  $var=$var."<option value='$info->category_id'>$info->category_type</option>";
                   }} ?>
                <div class="form-group">                  
                <label>Category Type:</label>
                <!-- <select class="form-control" name="category_type" id="location_id" required  >
                  <option value="">Select Category Type</option>
                  <?php if($categoryDetails){foreach($categoryDetails as $info){ ?>
                  <option value="<?=$info->category_id ?>"><?=$info->category_type?></option>
                  <?php }} ?>
                  </select> -->
                <select onchange="changeSelectUser(this)" id="userlist" name="category_type[]" class="select2" multiple="multiple" data-placeholder="Select Categories" style="width: 100%;">

                  <!-- <select class="form-control" name="category_type" id="location_id" required  > -->
                 <?=$var?>
                 </select>
                </div> 
                <div class="form-group">                  
                <label>Location:</label>
                <input type="text"class="form-control" name="location" id="location_id" placeholder='Enter The address' required>  
                  <!-- <select class="form-control" name="location" id="location_id" required  >
                  <option value="">Select Location</option>
                  <?php if($locationDetails){foreach($locationDetails as $info){ ?>
                  <option value="<?=$info->sk_location_id?>"><?=$info->location_name?></option>
                  <?php }} ?>
                  </select> -->
                </div> 
                <span><?php echo $this->session->flashdata('error');?></span>

                <div class="form-group">
                  <label>Inventory Image And Video(Max:upto 200MB):(Please Hold Ctrl And Select Images)</label>
                  <input type="file" class="form-control image-size1" name="inventory_image[]" id="event_image" multiple  required>  
                </div> 
               
                <span id="gstmessage" style="color: red;"></span>
                
                  </div>    
                  <div class="col-md-4">
  
                <div class="form-group">
                  <label>Description:</label>
                  <textarea  class="form-control" name="description" id="minimum_member" required></textarea>
                </div>
                <div class="form-group">
                  <label>Inventories:</label>
                  <input type="number" class="form-control" name="inventory" id="minimum_member" required />
                </div>

                <div class="form-group">
                  <label>Inventory Date:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" name="inventory_date" id="event_date">
                  </div>
                  <!-- /.input group -->
                </div>

                           

              
              <div class="form-group">
                  <label>Zone:</label>
                  <input type="text" class="form-control" name="zone" id="maximum_member" required/>
                </div>  
                <div class="form-group">                  
                <label>Available:</label>
                  <select class="form-control" name="available" id="location_id"  >
                  <option value="">Select Available</option>
                 <option value="onsite">Onsite</option>
                 <option value="field">Field</option>
                 <option value="heirloom_selection">Heirloom Selection</option>
                  </select>
                </div> 
                              <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>  
          </div> 
                </form>
              </div>
            </div>

 


          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <?php $this->load->view('admin/inc/footer.php'); ?>

  </div>
  <!-- ./wrapper -->


  <!-- <?php //$this->load->view('admin/inc/common-scripts-bottom.php'); ?>-->
  
<script>var AJAX_URL='<?php echo base_url()?>';</script>


<script src="<?=base_url();?>assets/admin/plugins/jquery/jquery.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url();?>assets/admin/dist/js/adminlte.min.js"></script>
<!-- <script src="<?=base_url();?>assets/admin/plugins/chart.js/Chart.min.js"></script> -->
<script src="<?=base_url();?>assets/admin/dist/js/demo.js"></script>
<!-- <script src="<?=base_url();?>assets/admin/dist/js/pages/dashboard3.js"></script> -->
<script src="<?=base_url();?>assets/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/jquery-validation/additional-methods.min.js"></script>

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
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script> 
<script>
  $('#event_date').daterangepicker({
    singleDatePicker: true,
    minDate:new Date(),
    maxDate: true,
  });
</script>
</script>
 <script type="text/javascript">
 $('input.image-size1').bind('change', function() {
  $('#gstmessage').html("");
  var infoArea = document.getElementById('event_image' );
  var maxSizeKB = 200000; //Size in KB
  var maxSize = maxSizeKB * 1024; //File size is returned in Bytes
  if (this.files[0].size > maxSize) {
    $('#gstmessage').html("File size can't exceed 2 MB");
    $(this).val("");
     infoArea.textContent ="";
   
    return false;
  }else{
    //alert(11)
  }
});
</script>
</body>

</html>