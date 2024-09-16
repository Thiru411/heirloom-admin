<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Heirloom |Chat</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->load->view('admin/inc/common-scripts-top.php'); ?>
<style>
 .attach {
    pointer-events: none;
    opacity: 500;
}
.attach1 {
  pointer-events: visible;
    opacity: 500;
}
.updated{
  display:none;
  position: absolute;
    top: 50%;
    left: 20%;
    color:red;
}
.modal24 {
    display:none;
    position:   absolute;
    top:        45%;
    left:       60%;
    height:     50px;
    width:      50px;
    background-color: rgba( 255, 255, 255, .8 ) ;
    background-image:  url('http://i.stack.imgur.com/FhHRx.gif') ;
  background-size : cover ;
            background-repeat:    no-repeat;
}
      .select-image img{width: 200px;height: 200px;object-fit: cover;padding: 10px 10px;}
      .select-image  .custom-radio .custom-control-input:checked~.custom-control-label::after{background-image:unset;}
      .select-image  .custom-control-input:checked~.custom-control-label::before{background-color: transparent;}
      .select-image  .custom-radio .custom-control-label::before{border-radius: unset; width: 100%; height: 100%;border:0px;box-shadow:unset;}
      .select-image .custom-control-label::before{left: unset;}
      .select-image .custom-radio .custom-control-label::before{background-color: transparent;}
      .select-image .custom-control-input:not(:disabled):active~.custom-control-label::before{background-color: transparent;box-shadow: unset;}
      .select-image .custom-control-input:checked~.custom-control-label::before{border:2px solid #007bff !important}
      #imgPathId{position: absolute;top: -25px;}    
      body.loading .modal24 {
    overflow: hidden;   
}
body.loading .modal24 {
    display: block;
}
    /* .modal-backdrop.show ; */
 </style>
 <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
</head>

<body class="sidebar-collapse layout-top-nav layout-navbar-fixed">




  <div class="wrapper">
    <?php $this->load->view('admin/inc/nav-top.php'); ?>
      <div class="d-flex flex-wrap msg-menu pt-5 mt-4">
        <div class="d-flex mr-auto">
          <p class="msg-conversation align-self-center mr-5 pr-md-5 d-none d-md-block">Message Conversation</p>
          <p class="chatname align-self-center mr-2 d-none d-md-block"><?=$admin_session_name?></p>
        </div>
       </div>
      <div class="row mx-0">
        <div class="col-md-3 px-0 mobile-chat-people">
          <div class="chat-list" id="userSection">
            <?php  
            $user_id="";$i=1;$recieverId=$recieverName=$chat_current_session=$chat_online_status=$profile_pic=$profile_path_pic=$unique_request_id=""; 
            if($ChatUsers){ 
              foreach($ChatUsers as $chat_info){
              $unique_request_id=$chat_info->userid;
              $recieverId=$chat_info->userid;
              $recieverName=$chat_info->name;
               $deviceId=$chat_info->deviceId;
              ?>
            <div class="chat-list-menber  list--item"   data-touserid='<?=$unique_request_id?>_dev_<?=$deviceId?>' id='<?=$unique_request_id?>_dev_<?=$deviceId?>'>
              <div class="chat-list-content d-flex">
              <div class="position-relative">
                <?php if($profile_pic!=""){?>
              <img class="profile--pic" src="<?=$profile_path_pic?>">
              <?php } else {?>
                <p class="chat-bg-text red"><?=substr($recieverName, 0, 1)?></p>
                <?php } ?>
                </div>
                <div class="align-self-center mr-2">
                  <p  id="receiverName" class="name limit_one_line"><?=$recieverName?></p>
                </div>
              </div>
            </div>
            <?php $i++;}}else{?>
              <div class="chat-list-menber">
              <div class="chat-list-content d-flex"> 
                <p>No Messages</p>
              </div>
            </div>
              <?php } ?> 
          </div>
        </div>
        <div class="col-md-9 px-0 mobile-chat-msg ">
          <div class="d-block d-md-none">
            <div class="d-flex mobile-chat-profile">
              <p class="chatname align-self-center mr-2 text-center w-100"><?=$admin_session_name?></p>
            </div>
          </div>
          <div class='updated'><p>Something went wrong Please try again</p></div>

          <div class="d-flex">
          <div class="msg-part w-100 position-relative">
          <div class="messages pt-md-5 pt-3 msgs-part" id="chat_message">
            <div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"><p>Click on user to start message</p></div>
                <div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"><p>Click on user to start message</p></div>
                
              </div>
              <div class="send-msg-field">
                <span id="custom-text" style="position: absolute;top: -5px;font-size: 14px;font-family: 'Inter', sans-serif;"></span>
                <div class="d-flex">
                  <div class="form-group mr-md-3 w-100 position-relative">
                  <div id="custom-button" data-toggle="modal" data-target="#exampleModal1" class="attach attach22"><img src="<?=base_url()?>assets/images/attach.png">
                </div>
                    <input type='hidden' id='uni_device_id' value='<?=$deviceId?>'/>
                    <input type='hidden' id='inventory_id' value=''/>
                    <input type='hidden' id='inventory_image_path' value=''/>
                    <input type='hidden' class="getpath" id='getpath' name="getpath" value=''/>
                    <input type="hidden" class="base64" value=''>
                    <span id='imgPathId'></span>
                    <input type="text" class="form-control chatMessages chattxt" name="" value='' placeholder="Write a message" id="chatMessage<?php echo $unique_request_id?>">
                    <input type="" data-toggle="modal" data-target="#exampleModal" class="form-control image-size chat_file_id" onchange="ValidateSingleInput(this);"  id="chat_file<?=$unique_request_id?>" hidden="hidden" >
                    <div class="send"><button class="submit chatButton chat_btn_cls msg-sent" id="chatButton<?php echo $unique_request_id?>"><img src="<?=base_url()?>assets/images/send.png"></button></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal -->
<div class="modal fade ModalForm12234" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select upload Files</h5>
       
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">
         <button type="button" class="btn btn-primary photos-videos" data-toggle="modal"  data-target="#dummyModal"><input class="photosvideo" type="hidden" name="photos"  value="photo" >Photos</button>

         <button type="button" class="btn btn-primary photos-videos1" data-toggle="modal"  data-target="#dummyModal"><input class="photosvideo12" type="hidden" name="video"  value="video" >Videos</button>
          <input type="file" name="gallery"  id="imgupload"  style="display:none">
         <button type="button" class="btn btn-primary" id="OpenImgUpload">Choose From Gallery</button>

      </div>
    </div>
  </div>
</div>

     
    
      <div class="modal fade dummyModal" id="dummyModal" tabindex="-1" aria-labelledby="exampleModalLabel11" aria-hidden="true">

        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" class="close" id="closecancel">&times;</button>
          </div>
          <div class="modal-body">
            <div class="col-md-12 select-image">
        <form>
          <div class="form-group row" id="imageId">
              
          </div>
        </form>

        </div>
          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="hideclose">Close</button>
        <button type="button" class="btn btn-primary"data-dismiss="modal" id="select_inventory">Select</button>
      </div>
        </div>
      </div>
    </div>
    <div class="modal24">
    
  </div>
  

    <?php $this->load->view('admin/inc/footer.php'); ?>
    <?php $this->load->view('admin/inc/common-scripts-bottom.php'); ?>
    <script src="<?=base_url()?>assets/custom/custom_chat.js"></script> 


    <script>
    if (window.matchMedia('(max-width: 768px)').matches) {
      $('.mobile-chat-people .chat-list-content').click(function() {  
        $('.mobile-chat-msgs').show();
        $('.mobile-chat-people').hide();
      });

      $('.backtopeople').click(function() {  
        $('.mobile-chat-msgs').hide();
        $('.mobile-chat-people').show();
      });
    };

      const realFileBtn =document.getElementById("chat_file<?=$unique_request_id?>"); 
      const customBtn = document.getElementById("custom-button");
      const customTxt = document.getElementById("custom-text");
    
      customBtn.addEventListener("click", function() {
        realFileBtn.click();
      });
    
      realFileBtn.addEventListener("change", function() {
        if (realFileBtn.value) {
          customTxt.innerHTML = realFileBtn.value.match(
            /[\/\\]([\w\d\s\.\-\(\)]+)$/
          )[1];
        } else {
          customTxt.innerHTML = "No file chosen, yet.";
        }
      });
    
        </script>
        <script type="text/javascript">

        


  $('.msg-sent').attr("disabled",true);
  $('.chattxt').attr("disabled",true); 
  </script>
<script>
$('.photos-videos').click(function() {   
// $('#exampleModal1').hide();
$('#exampleModal1').modal('hide');
                // $('.modal-backdrop').modal('hide');
 var type=$('.photosvideo').val();
   $.ajax({ 
            url:AJAX_URL+"inventoryAll/"+type, 
                        success:function(response){  
                        $("#imageId").html(response);
                        }
});
  });
$('.photos-videos1').click(function() { 
  $('#exampleModal1').modal('hide');
 var type=$('.photosvideo12').val();
   $.ajax({   
            url:AJAX_URL+"inventoryAll/"+type, 
           
                        success:function(response){  
                        $("#imageId").html(response);
                        }
});
  });



  $('#select_inventory').click(function() { 
    $('#exampleModal1').modal('hide');
 $('#dummyModal').modal('hide');
 $('.modal-backdrop').modal('hide');

    let inventory=$('input[name="customRadio"]:checked').val();
    let id1=inventory.split('_dev_');
  var invetory_id=id1[0]
  var imageUrl=id1[1]
 let id2=imageUrl.split('uploads/inventory/');
 let image_name=id2[1]
 document.getElementById("inventory_image_path").value = imageUrl;
 document.getElementById("inventory_id").value = invetory_id;
 $("#imgPathId").html(image_name);


  });
</script>
<script type="text/javascript">
         


let filedata2='';
    $( "#imgupload" ).change(function() {
var files = $('#imgupload').get(0).files;
//console.log(files[0]);
let reader = new FileReader();
reader.readAsDataURL(files[0]);
reader.addEventListener('load', event => {
filedata2=event.target.result;
$('.base64').val(filedata2);
filename2=files[0].name;
var filename=filename2.split('.');
filename2='DOC.'+filename[1]
$('#imgPathId').text(filename2);
// $('.tick2').css('display:block');
$('#exampleModal1').modal('hide');
    //             $('.modal-backdrop').modal('hide');

})
});

</script>
<script type="text/javascript">
   var counter = 1;
var auto_refresh = setInterval(
function () {
  var to_user_id=$('.submit').attr('id');
 // var to_user_id = $(this).attr('id');
 var to_user_id1 = to_user_id.replace(/chatButton/g, "");  

  //console.log(to_user_id1)
  let device_id=$("#uni_device_id").val();
// let message=inventory_id=inventory_image_path=action=''
          // /  var to_user_id1 = to_user_id.replace(/chatButton/g, "");  
  //alert()
  var  body = $("body");

  $("#imgPathId").html("");
            let  chat_file=""; 
            $.ajax({
            url:AJAX_URL+"chat_action",  
                method:"POST",
                data:{to_user_id:to_user_id1,action:'show_chat'},
                success:function(response) { 
                    body.removeClass("loading"); 
                    $('.attach').addClass("attach1");  
                    $('.msg-sent').attr("disabled",false);
                    $('.chattxt').attr("disabled",false); 
                var resp = $.parseJSON(response);
                    $('#chat_message').html(resp.conversation); 
                    // let chat_file_id="chat_file"+to_user_id;
                    // let chat_msg_id="chatMessage"+to_user_id;
                    // let chat_btn_id="chatButton"+to_user_id;
                    // $('.chat_file_id').attr('id', chat_file_id);
                    // $('.chatMessages').attr('id', chat_msg_id);
                    // $('.chat_btn_cls').attr('id', chat_btn_id);	 
                    $(".msgs-part").animate({ scrollTop: $(".msgs-part")[0].scrollHeight}, 1000);    
                }
            });
          
  //  var newcontent= 'Refresh nr:'+counter;
}, 10000);
</script>
<script>
  $('#hideclose').click(function() { 
    $('#exampleModal1').hide();
 $('#dummyModal').hide();
 $('.modal-backdrop').hide();
    });
   $('#closecancel').click(function() { 
    $('#exampleModal1').hide();
 $('#dummyModal').hide();
 $('.modal-backdrop').hide();
    });

</script>
<script type="text/javascript">
  $('#OpenImgUpload').click(function(){ 
    $('#imgupload').trigger('click'); 
  });
  // $('.openimages').click(function(){ 
  //   $('.uploadimages').trigger('click'); 
  //   alert(3)
  // });

</script>



    
  </body>
</html>