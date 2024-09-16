<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Clique |Event</title>
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
              <h1>Event</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>events-view">Events</a></li>
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
    <h3 class="card-title">View Event</h3>
  </div>
  <div class="card-body">  
              
              <form role="form" id="quickForm" name="myForm" action="<?=base_url()?>events-view" method="get">
              <div class="row">  
                  <div class="col-4">
                    <label>Location:</label>
                    <select class="form-control" name="location_id" id="location_id" required  >
                    <option value="">Select Location</option>
                    <?php $locaId=""; if(isset($_GET['location_id'])){$locaId=$_GET['location_id'];}?>    
                    <option value="All" <?php if($locaId=="All"){echo "selected";}else{echo "";} ?>>All</option>
                    <?php if($locationDetails){foreach($locationDetails as $info){ ?>
                    <option value="<?=$info->sk_location_id?>" <?php if($locaId==$info->sk_location_id){echo "selected";}else{echo "";} ?>><?=$info->location_name?></option>
                    <?php }} ?>
                    </select>
                  </div>
                  <div class="col-4">
                    <label>Event Type:</label>   
                    <?php $eventType=""; if(isset($_GET['event_type'])){$eventType=$_GET['event_type'];}?>                    
                    <select class="form-control" name="event_type" id="event_type" required  >
                    <option value="">Select Event Type</option> 
                      <option value="Past Events" <?php if($eventType=="Past Events"){echo "selected";}else{echo "";} ?>>Past Events</option>
                      <option value="Current Events" <?php if($eventType=="Current Events"){echo "selected";}else{echo "";} ?>>Current Events</option>
                    </select>
                  </div>
                  <div class="col-4"> 
                  <button type="submit" class="btn btn-primary" style="margin-top: 9%;">Get Details</button>
                  </div>
                                
                </div>
                </form>

               
               
 
  </div>

</div>
</div>

            <div class="col-md-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">View Event</h3>
                </div>
                <div class="card-body"> 
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Sl.No</th>
                        <th>Title</th>
                        <th>Address</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>No of People</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <?php  if(isset($_GET['location_id'])){
                    $location_id=$event_type="";
                     if(isset($_GET['location_id'])){$location_id=$_GET['location_id'];}
                     if(isset($_GET['event_type'])){$event_type=$_GET['event_type'];}
                     $event_detailsByLoc=$this->CI->getEventsView($location_id,$event_type); 
                     $eventDetails=$event_detailsByLoc;
                    }else{
                      $eventDetails=$event_details;
                    }
                     ?>
                    <tbody>
                      <?=$eventDetails?>
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
  </script>
 
</body>

</html>