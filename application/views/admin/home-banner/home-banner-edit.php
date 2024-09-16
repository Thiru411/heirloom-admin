<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Heirloom | Banner-Image</title>
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
              <h1>Banner Image</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>home-screen">Banner Image</a></li>
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

            <div class="col-md-6">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Edit Banner Image</h3>
                </div>
                <form role="form" id="quickForm" name="myForm" action="<?= base_url() ?>banner-details/update/<?=base64_encode($banner_id)?>" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                  <div class="form-group">
                      <label>Select Inventory:</label>
                      <div class="input-group">
                      <input type="text" class="form-control" name="inventory_name" value="<?=$title?>" id="banner_image">
                      <input type="hidden" class="form-control" name="inventory_id" value="<?=$inventory_id?>" id="banner_image">

                      </div>
                    </div>
                    <div class="form-group">
                      <label>Select Home Banner(Max:upto 200MB):</label>
                      <div class="input-group">
                      <input type="file" class="form-control image-size1" name="banner_image"  id="banner_image">
                      <span id="gstmessage" style="color: red;"></span>

                    </div>
                    <div>  <?php  
                      $ext = pathinfo($banner_image, PATHINFO_EXTENSION);
                      if($ext=='mp4'){?>
                      <video width='100px' height='100px' controls>
                        <source src='<?=$banner_image?>' type='video/mp4'>
                     </video>                         
                   <?php }else{?>
                      <img src="<?=$banner_image?>" width="100px" height="100px">
                      <?php }?>
                    </div>

                    </div>

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
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



    $('input.image-size1').bind('change', function() {
  $('#gstmessage').html("");
  var infoArea = document.getElementById('banner_image' );
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