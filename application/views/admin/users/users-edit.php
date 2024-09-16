<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Heirloom |Users</title>
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
              <h1>Users</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>users-view">Users</a></li>
                <li class="breadcrumb-item active">Edit</li>
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
                  <h3 class="card-title">Edit User</h3>
                </div>
                <form role="form" id="quickForm" name="myForm" action="<?=base_url()?>user-details/update/<?=base64_encode($sk_user_id)?>" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
              <div class="form-group">
                  <label>User name:</label>
                  <input type="text" class="form-control" name="Username"value="<?=$name?>" id="title" required placeholder="user Name"> 
                </div>  
                <div class="form-group">
                  <label>Company Name:</label>
                  <input type="text" class="form-control" name="company_name" value="<?=$company_name?>" id="title" required placeholder="Event Title"> 
                </div>  
                <!-- <div class="form-group">
                  <label>Password:</label>
                  <input type="text" class="form-control" name="password" value="<?=$password?>" id="title" required placeholder="Event Title"> 
                </div>   -->
                <div class="form-group">                  
                <label>Company Address:</label>
                <input type="text" class="form-control" name="company_address" value="<?=$company_address?>" id="title" required placeholder="Event Title">
                </div> 
                <div class="form-group">                  
                <label>City:</label>
                <input type="text" class="form-control" name="city" value="<?=$city?>" id="title" required placeholder="Event Title">
                </div> 
              </div> 
              <div class="col-md-4">    
                <div class="form-group">
                  <label>mobile:</label>
                  <input type="text" class="form-control" name="mobile" value="<?=$mobile?>" required />
                </div>
                <div class="form-group">
                  <label>Email:</label>
                  <input type="text" class="form-control" name="email" value="<?=$email?>" required />
</div>     
              </div> 

              <div class="col-md-4">
              
              <div class="form-group">
                  <label>Zip Code:</label>
                  <input type="text" class="form-control" name="zipcode" value="<?=$zipcode?>"  required/>
                </div> 
                <div class="form-group">
                  <label>Role:</label>
                  <input type="text" class="form-control" name="role" value="<?=$role?>"  required/>
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