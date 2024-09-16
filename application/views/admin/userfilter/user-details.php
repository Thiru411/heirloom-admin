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
              <h1>Data By User</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>home-screen">User Details</a></li>
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
                  <h3 class="card-title">SELECT USER</h3>
                </div>
                <div class="card-body">

                <div class='row'>
                <div class="col-md-6">

                <div class="form-group">
                      <label>Select User:</label>
                      <div class="input-group">
                      <select class="form-control inventory_id" name="inventory_id" id="continent_id">
                      <option value=''>Select User</option>   
                      <?=$user_details?>
                        </select>
                    </div>
                    
                </div>
</div>
<div class="col-md-6">

                    <div class="form-group">
                      <label>Select:</label>
                      <div class="input-group">
                      <select class="form-control select_filter" name="select_filter" id="continent_id">
                      <option value=''>Select</option>

                          <option value='Tagged'>TAGGED</option>
                          <option value='Saved'>SAVED</option>
                          <option value='Project'>PROJECTS</option>
                    </select>
                    </div>
                    <div class="card-body">  
            </div>
</div></div>
<div class='getdetails' style="width:100%"></div>
                    </div>
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



    $('.select_filter').change(function(){
        var select_filter=$('.select_filter').val();
        var inventory_id=$('.inventory_id').val();
        $.ajax({
            url:AJAX_URL+"filters",  
                method:"POST",
                data:{select_filter:select_filter,user_id:inventory_id},
                success:function(response) { 
                  console.log(response);
                   $('.getdetails').html(response);
                }
            });
    });
  </script>

</body>

</html>