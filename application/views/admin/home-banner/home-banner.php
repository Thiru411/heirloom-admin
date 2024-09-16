<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Heirloom | Home-Banner</title>
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
              <h1>Home-Banner</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>home-Banner">Home-Banner</a></li>
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

            <div class="col-md-6">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Add Home Banner</h3>
                </div>
                <form role="form" id="quickForm" name="myForm" action="<?= base_url() ?>banner-details/Add/Save" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                  <div class="form-group">
                      <label>Select Inventory:</label>
                      <div class="input-group">
                      <select class="form-control" name="inventory_id" id="continent_id">
                      <option value=''>Select Inventory</option>   
                      <?=$inventory_details?>
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label>Select Home Banner(Max:upto 200MB):</label>
                      <div class="input-group">
                        <input type="file" class="form-control image-size1" name="banner_image" id="banner_image">
                      </div>
                      <span id="gstmessage" style="color: red;"></span>

                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary home-banner-save">Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>


            <div class="col-md-6">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">View Banner</h3>
                </div>
                <div class="card-body">
                <input type="radio" id="action" class='acc' name="action" value="active">
                <label for="active">ACTIVE</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="action" name="action" class='acc'  value="inactive">
                <label for="active">INACTIVE</label>
                <table id="example1" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th>Sl.No</th>
                        <th>Inventory name</th>
                        <th>Banner Image</th>
                        <th>Action</th>

                      </tr>
                    </thead>
                    <tbody class='getdetails'>
                      <?=$banner_details?>
                    </tbody>
                  </table>
                </div>

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

$('.home-banner-save').click(function(){
  $(".home-banner-save'").prop('disabled', true);
})




$('.acc').click(function(){
      var value= $('.acc:checked').val();
      if(value=='active'){
        value=1;
      }else{
        value=0;
      }
      var type='banner';
      $.ajax({
            url:AJAX_URL+"active",  
                method:"POST",
                data:{value:value,type:type},
                success:function(response) { 
                  console.log(response);
                   $('.getdetails').html(response);
                }
            });
    });

  </script>
 
</body>

</html>