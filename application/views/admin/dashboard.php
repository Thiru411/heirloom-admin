<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Heirloom | Dashboard</title>

  <?php $this->load->view('admin/inc/common-scripts-top.php');?>

</head>


<body class="<?=body_class?>">
<div class="wrapper">

<?php $this->load->view('admin/inc/nav-top.php');?>
  
<?php //$this->load->view('admin/inc/nav-side.php');?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Dashboard  <small></small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li><!-- 
              <li class="breadcrumb-item"><a href="#">Layout</a></li> -->
              <li class="breadcrumb-item active">Top Navigation</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    
    <div class="content">
      <div class="container">


      <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box-->
            <a href="<?=base_url()?>users-view">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number"><?=$count_users?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
          </div>
          <!-- ./col-->
          <div class="col-lg-3 col-6">
            <!-- small box-->
            <a href="<?=base_url()?>/inventory">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-tree"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Inventories</span>
                <span class="info-box-number"><?=$count_inventories?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
          </div>
          <!-- ./col-->
          <div class="col-lg-3 col-6">
            <!-- small box-->
            <a href="<?=base_url()?>partner-view">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-users" aria-hidden="true"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Partners</span>
                <span class="info-box-number"><?=$count_partners?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
          </div>
          <!-- ./col-->
         
          <!-- ./col-->
        </div>

       
      </div>
</div> <div class="content">
      <div class="container">
      <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box-->
            <a href="<?=base_url()?>library-view/Tagged">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tagged</span>
                <span class="info-box-number"><?=$getTaggedDetails?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
          </div>
          <!-- ./col-->
          <div class="col-lg-3 col-6">
            <!-- small box-->
            <a href="<?=base_url()?>/library-view/Project">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-project-diagram"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Projects</span>
                <span class="info-box-number"><?=$projects?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
          </div>
          <!-- ./col-->
          <div class="col-lg-3 col-6">
            <!-- small box-->
            <a href="<?=base_url()?>library-view/Saved">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-save" aria-hidden="true"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Saved</span>
                <span class="info-box-number"><?=$getSaveDetails?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
          </div>
          <!-- ./col-->
         
          <!-- ./col-->
        </div>
</div>
       
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('admin/inc/footer.php');?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php $this->load->view('admin/inc/common-scripts-bottom.php');?>
</body>
</html>