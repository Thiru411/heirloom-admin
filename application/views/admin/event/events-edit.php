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
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>events-add">Events</a></li>
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
                  <h3 class="card-title">Edit Event</h3>
                </div>
                <form role="form" id="quickForm" name="myForm" action="<?=base_url()?>event-details/update/<?=base64_encode($sk_event_id)?>" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
              <div class="form-group">
                  <label>Event Title:</label>
                  <input type="text" class="form-control" value="<?=$title?>" name="title" id="title" required placeholder="Event Title"> 
                </div>  
                <div class="form-group">                  
                <label>Location:</label>
                  <select class="form-control" name="location_id" id="location_id" required  >
                  <option value="">Select Location</option>
                  <?php if($locationDetails){foreach($locationDetails as $info){ ?>
                  <option value="<?=$info->sk_location_id?>" <?php if($info->sk_location_id==$location_id){echo "selected";}else{echo "";}?>><?=$info->location_name?></option>
                  <?php }} ?>
                  </select>
                </div> 
                
                <div class="form-group">
                  <label>Event Image:</label>
                  <?php if($event_img){?><img src="<?=$event_image?>" width="100px" height="100px"><?php } ?>
                  <input type="file" class="form-control" name="event_image" id="event_image"  > 
                </div> 
               

                
              </div> 
              

              

              <div class="col-md-4">
               

                         
                <div class="form-group">
                  <label>Minimum Member:</label>
                  <input type="text" class="form-control" value="<?=$minimum_member?>" name="minimum_member" id="minimum_member" required onkeypress="return isNumberKeyevent(event)" />
                </div>

                <div class="form-group">
                  <label>Event Date:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right"  value="<?=$event_date?>"  name="event_date" id="event_date">
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Description:</label>
                  <textarea  class="form-control" name="description" id="description" required ><?=$description?></textarea>
                </div> 

                           
              </div> 

              <div class="col-md-4">
              
              <div class="form-group">
                  <label>Maximum Member:</label>
                  <input type="text" class="form-control" name="maximum_member" id="maximum_member"  value="<?=$maximum_member?>"  required onkeypress="return isNumberKeyevent(event)" />
                </div>  
               
                <div class="form-group">
                    <label>Event Time:</label>

                    <div class="input-group date" id="timepicker" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target="#timepicker"  value=""  name="event_time" id="event_time"/>
                      <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                      </div> 
                  </div>  

                  <div class="form-group">
                  <label>Category:</label>
                <select class="js-example-basic-multiple form-control" name="category[]" multiple="multiple">
                  <!-- <optgroup label="Group Name">
                    <option>Nested option</option>
                  </optgroup> -->
                <?=$CategorySubCategroyDetails?>
              </select>
                </div>

              </div> 
              <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
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
$("#event_time").val("<?=$event_time?>");
//Date range picker
$('#event_date').daterangepicker({
  singleDatePicker: true,
  minDate:new Date(),
  maxDate: true,
});
    
 </script>
</body>

</html>