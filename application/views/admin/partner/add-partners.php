<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Heirloom |Partners</title>
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
              <h1>Partners</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>partner-details">Partners</a></li>
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
                  <h3 class="card-title">Add Partner</h3>
                </div>
                <form role="form" id="quickForm" name="myForm" action="<?=base_url()?>partners-details/Add/Save" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
              <div class="form-group">
                  <label>Partner Name:</label>
                  <input type="text" class="form-control" name="partner_name" id="title" required placeholder="Event Title"> 
                </div>  
                <div class="form-group">
                  <label>Phone Number:</label>
                  <input type="number" class="form-control" name="phone_number" id="title" required placeholder="Event Title"onkeypress="return isNumberKeyevent(event)"> 
                </div>  
             <div class="form-group">
                  <label>Partner Image:</label>
                  <input type="file" class="form-control" name="partner_image" id="event_image"  >  
                </div> 
               
                <div class="form-group">
                  <label>About:</label>
                  <input type="text" class="form-control" name="about" id="event_image"  >  
                </div> 
                
              </div> 
              
              
              

              <div class="col-md-4">
               

                         
                <div class="form-group">
                  <label>Website:</label>
                  <input type="text" class="form-control" name="website" required />
                </div>
                <div class="form-group">
                  <label>Address:</label>
                  <input type="text" class="form-control" name="address" required />
                </div>

                <div class="form-group">
                  <label>Services:</label>
                    <input type="text" class="form-control float-right" name="services">
                  </div>
                  <!-- /.input group -->
                </div>

                           
              </div> 

              <div class="col-md-4">
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


  <?php $this->load->view('admin/inc/common-scripts-bottom.php'); ?>


  <script type="text/javascript">
    $(document).ready(function() {
      $.validator.setDefaults({
        submitHandler: function() {
          // alert( "Form successful submitted!" );
          document.myForm.submit();
        }
      });
      $('#quickForm').validate({
        rules: {
          unit_type: {
            required: true,
          },
        },
        messages: {
          continent_name: {
            required: "Please enter a Continent name",
            continent_name: "Please enter a Continent name"
          }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>
 <script>
 $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
      placeholder: 'Select Category',
    });
});
$('#event_time').datetimepicker({
      format: 'HH:mm',
      autoclose: true
    })
//Date range picker
$('#event_date').daterangepicker({
  singleDatePicker: true,
  minDate:new Date(),
  maxDate: true,
});
    
 </script>
</body>

</html>