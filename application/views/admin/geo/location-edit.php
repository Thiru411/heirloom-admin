<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Clique |Location</title>
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
              <h1>Location</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>location">Location</a></li>
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
                  <h3 class="card-title">Edit Location</h3>
                </div>
                <form role="form" id="quickForm" name="myForm" action="<?= base_url() ?>location-details/update/<?=base64_encode($sk_location_id)?>" method="post">
                  
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Continent:</label>
                        <select class="form-control" name="continent_id" id="continent_id" required onchange="getCountry(this.value)">
                          <option>Select Continent</option>
                          <?php if($continentDetails){foreach($continentDetails as $info){?>
                          <option value="<?=$info->sk_continent_id?>" <?php if($info->sk_continent_id==$continent_id){echo "selected";}else{echo "";}?>><?=$info->continent_name?></option>
                          <?php }}?>
                          </select>
                      </div> 
                      <div class="form-group">                  
                      <label>State Name:<?=$state_id?></label>
                        <select class="form-control" name="state_id" id="state_id" required onchange="getCity(this.value)">
                        <option value="">Select State</option> 
                        <?php if($stateDetails){foreach($stateDetails as $sinfo){?>
                        <option value="<?=$sinfo->sk_state_id?>" <?php if($sinfo->sk_state_id==$state_id){echo "selected";}else{echo "";}?>><?=$sinfo->state_name?></option>
                        <?php }}?>
                        </select>
                      </div> 
                      <div class="form-group">
                        <label>Location Name:</label>
                        <input type="text" class="form-control" name="location_name" id="location_name" value="<?=$location_name?>" required onkeypress="return AllowAlphabet(event)" />
                      </div>
                    </div> 
                    
                    <div class="col-md-6">
                      <div class="form-group">
                      <label>Country Name:</label>
                      <select class="form-control" name="country_id" id="country_id" required onchange="getState(this.value)">
                         <option value="">Select Country</option> 
                        <?php if($countryDetails){foreach($countryDetails as $cinfo){?>
                        <option value="<?=$cinfo->sk_country_id?>" <?php if($cinfo->sk_country_id==$country_id){echo "selected";}else{echo "";}?>><?=$cinfo->country_name?></option>
                        <?php }}?>
                        </select>
                      </div>               
                      <div class="form-group">
                        <label>City Name:</label>
                        <select class="form-control" name="city_id" id="city_id" required >
                        <option value="">Select City</option>
                        <?php if($cityDetails){foreach($cityDetails as $city_info){?>
                        <option value="<?=$city_info->sk_city_id?>" <?php if($city_info->sk_city_id==$city_id){echo "selected";}else{echo "";}?>><?=$city_info->city_name?></option>
                        <?php }}?>
                        </select>
                      </div>  
                      <div class="form-group">
                        <label>Pincode:</label>
                        <input type="text" class="form-control" value="<?=$pincode?>" name="pincode" id="pincode" maxlength="6" required onkeypress="return isNumberKeyevent(event)" />
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
 
</body>

</html>