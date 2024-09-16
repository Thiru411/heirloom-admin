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
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>Admin/users_view">users view</a></li>
                <li class="breadcrumb-item active">View</li>
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
    <h3 class="card-title">View Users</h3>
  </div>
  <div class="card-body">  
  </div>
</div>
</div>
            <div class="col-md-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">View Users</h3>
                </div>
                <div class="card-body"> 
                <input type="radio" id="action" class='acc' name="action" value="inactive">
                <label for="active">NEW USERS</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="action" name="action" class='acc'  value="active">
                <label for="active">APPROVED USERS</label>
                <table id="example1" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                      <tr>
                      <th>Sl.No</th>
                        <th>User Name</th>
                        <th>Companay Name</th>
                        <th>Companay Address</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Zip Code</th>
                        <th>Role</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class='getdetails'>
                      <?=$continent_details?>
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
   


    $('.acc').click(function(){
      var value= $('.acc:checked').val();
      if(value=='active'){
        value=1;
      }else{
        value=0;
      }
      var type='users';
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