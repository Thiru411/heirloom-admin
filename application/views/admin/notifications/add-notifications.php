<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Heirloom |Notifications</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?=base_url();?>assets/admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="<?=base_url();?>assets/admin/plugins/fontawesome-free/css/all.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?=base_url();?>assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?=base_url() ?>assets/admin/dist/css/adminlte.min.css">
  
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
              <h1>Notifications</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>add-notifications">Notifications</a></li>
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
                  <h3 class="card-title">Add Notifications</h3>
                </div>
                <form role="form" id="quickForm" name="myForm" action="<?=base_url()?>notification-details/Add/Save" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                  <label>Notification Title:</label>
                  <input type="text" class="form-control" name="title" id="title" required placeholder="Event Title"> 
                </div>  
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label>Users:</label>
                 <!--  <select onchange="changeSelectUser(event)" name="user[]" class="select2" multiple="multiple" data-placeholder="Select Users" style="width: 100%;"> -->
                 
                 <select onchange="changeSelectUser(this)" id="userlist" name="user[]" class="select2" multiple="multiple" data-placeholder="Select Users" style="width: 100%;">
                  <?=$user_details?>
                  </select>
                  </div>
                    </div>

                    </div>
                <!--<div class="form-group">                  
                <label>Users:</label>
                  <select class="select2" multiple style="width: 100%;" name="user[]" id="location_id" required  >
                  <option value="">Select User</option>
                  </select>
                </div>-->              
                
                <button type="submit" class="btn btn-primary">Send</button>
              
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


  <?php //$this->load->view('admin/inc/common-scripts-bottom.php'); ?>
  <script src="<?=base_url();?>assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?=base_url();?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url();?>assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url() ?>assets/dist/js/adminlte.js"></script>



<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?=base_url();?>assets/admin/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/raphael/raphael.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?=base_url();?>assets/admin/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?=base_url();?>assets/admin/plugins/chart.js/Chart.min.js"></script>



<!-- OPTIONAL SCRIPTS -->
<!-- <script src="<?=base_url();?>assets/admin/plugins/chart.js/Chart.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url() ?>assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?=base_url() ?>assets/admin/dist/js/pages/dashboard2.js"></script> -->
<!-- <script src="<?=base_url() ?>assets/admin/dist/js/pages/dashboard3.js"></script> -->
  <script src="<?=base_url();?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
<script>
$(function () {
$('.select2').select2()
$('.select2bs4').select2({
theme: 'bootstrap4'
})
})
</script>

  <script type="text/javascript">
  
  </script>
 <script>



    


function changeSelectUser(val){
  var length = document.getElementById("userlist").options.length;
if(val.value == 'ALL'){
      for(var i = 1;i<length;i++)
        document.getElementById("userlist").options[i].selected = "selected";
      document.getElementById("userlist").options[0].selected = "";
      }

}
 </script>
</body>

</html>