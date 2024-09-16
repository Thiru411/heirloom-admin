<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Clique | Continent</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php $this->load->view('admin/inc/common-scripts-top.php');?>

</head>
<body class="sidebar-collapse layout-top-nav layout-navbar-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php $this->load->view('admin/inc/nav-top.php');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php //$this->load->view('admin/inc/nav-side.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Continent</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url()?>dashboard">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>continent">Continent</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container fluid">
        
        <div class="row">
          <!-- left column -->
          <div class="card col-md-4">
            <div class="card-header">
              <h3 class="card-title">Edit Continent</h3>
            </div> 
            <div class="card-body">
            <?php echo $this->session->flashdata('message');?>
            <form role="form" id="quickForm" name="myForm" action="<?=base_url()?>continent-details/update/<?=base64_encode($sk_continent_id)?>" method="post">
               
               <div class="card-body row"> 
                 <div class="form-group">
                    <label for="unit_type">Continent Name</label>                     
                    <input type="text" name="continent_name" value="<?=$continent_name?>" class="form-control" id="continent_name" required />
                 </div> 
               </div>  
               <div class="form-group">
                    <label for="unit_type"></label> 
                    <button type="submit" class="btn btn-primary" id="btn" >Update</button>
                 </div> 
             </form> 
            </div>
          </div>
         
            
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

   <?php $this->load->view('admin/inc/footer.php');?>

</div>
<!-- ./wrapper -->


<?php $this->load->view('admin/inc/common-scripts-bottom.php');?>


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
      unit_type: {
        required: true,
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

</body>
</html>
