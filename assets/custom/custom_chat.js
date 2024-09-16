        $(document).on("click", '.submit', function(event) { 
            var to_user_id = $(this).attr('id');
            var to_user_id1 = to_user_id.replace(/chatButton/g, "");  
        sendMessage(to_user_id1); 
        });

        var videoUrl ='';
        function sendMessage(to_user_id) { 
            var  body = $("body");
            if($('#loading-messages').html()=='No Messages'){
                $('#loading-messages').html('Loading');
            }
            body.addClass("loading"); 
            $('.attach').removeClass("attach1");  
            $('.msg-sent').attr("disabled",true);
            $('.chattxt').attr("disabled",true); 

            let action="insert_chat";
            let inventory_image_path='';
            let inventory_id='';
            let device_id=$("#uni_device_id").val();
            inventory_image_path=$("#inventory_image_path").val();
            inventory_id=$("#inventory_id").val();
            $("#inventory_image_path").val('');
            $("#inventory_id").val('');
            var message =$("#chatMessage"+to_user_id).val();
                $("#chatMessage"+to_user_id).val('');
               
                if(message!=''){
                    inventory_image_path='';
                    inventory_id='';
                }

                if(inventory_image_path==''&& inventory_id==''){
                
                if($.trim(message)==''){
            let chat_file=$("#imgupload").prop('files')[0]; 

            $("#imgPathId").html("");
            $('#imgupload').val('');
                    var file=$("#imgupload").prop('files')[0]; 
                const extension = chat_file.type.split('/')[1];
                const fileType = chat_file.type.split('/')[0];
              //  const storageRef = firebase.storage().ref();
                // var timestamp = Date.now()+"."+extension;
                // const final =storageRef.child(`imagefiles/`+timestamp);
                // const task = final.put(chat_file)
                // task.on('state_changed',
                // function progress(progress){
                // },  
                // function error(err){
                //     chat_file = '';
                //     if(err){

                //         $('.updated').hide().fadeIn(8000).delay(30000).fadeOut(3000);
                //         body.removeClass("loading"); 
                //         $('.attach').addClass("attach1");  
                //         $('.msg-sent').attr("disabled",false);
                //         $('.chattxt').attr("disabled",false); 
                //         return;
                // }

                // },

                // function completed(){
                //     final.getDownloadURL()
                //     .then(url=>{
                //         chat_file = url;
                        var imageUrl=videoUrl='';
                        if(fileType=='image'){
                            imageUrl=$('.base64').val();
                            $('.base64').val('');                          //  timestamp=timestamp+'==gallery';
                          //  imageUrl = file;
                        }
                        else{
                            videoUrl=$('.base64').val();
                            $('.base64').val('');

                            //timestamp=timestamp+'==gallery';

                            videoUrl = videoUrl;
                        }
                        $('#getpath').val('');
                            var form_data = new FormData();
        
                            form_data.append('imageUrl', imageUrl);

                            form_data.append('inventory_image_path', inventory_image_path);
                            form_data.append('videoUrl', videoUrl);
                            form_data.append('to_user_id', to_user_id); 
                            form_data.append('chat_message', message);
                            form_data.append('action', 'insert_chat'); 
                            form_data.append('device_id',device_id);
                            form_data.append('inventory_id',inventory_id);
                            form_data.append('device_id',device_id);
                        $.ajax({ 
                        url:AJAX_URL+"chat_action",  
                                    dataType: 'text',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: form_data,
                                    type: 'post', 
                                    success:function(response){ 
                                        body.removeClass("loading"); 
                                        $('.attach').addClass("attach1");  
                                        $('.msg-sent').attr("disabled",false);
                                        $('.chattxt').attr("disabled",false); 
                                        var resp = $.parseJSON(response);
                                        $('#chat_message').html(resp.conversation); 
                                        let chat_file_id="chat_file"+to_user_id;
                                        let chat_msg_id="chatMessage"+to_user_id;
                                        let chat_btn_id="chatButton"+to_user_id;
                                        $('.chat_file_id').attr('id', chat_file_id);
                                        $('.chatMessages').attr('id', chat_msg_id);
                                        $('.chat_btn_cls').attr('id', chat_btn_id);	 
                                        $(".msgs-part").animate({ scrollTop: $(".msgs-part")[0].scrollHeight}, 1000);    
                                    }
                        });
                //     })
                // })     
            }

        else{    
            $("#imgPathId").html("");
        let  chat_file=""; 
        $.ajax({
        url:AJAX_URL+"chat_action",  
            method:"POST",
            data:{to_user_id:to_user_id,device_id:device_id,chat_message:message,inventory_id:inventory_id,inventory_image_path:inventory_image_path, action:'insert_chat'},
            success:function(response) { 
                $('.attach').addClass("attach1");  
                body.removeClass("loading"); 
                $('.msg-sent').attr("disabled",false);
                $('.chattxt').attr("disabled",false); 
            var resp = $.parseJSON(response);
                $('#chat_message').html(resp.conversation); 
                let chat_file_id="chat_file"+to_user_id;
                let chat_msg_id="chatMessage"+to_user_id;
                let chat_btn_id="chatButton"+to_user_id;
                $('.chat_file_id').attr('id', chat_file_id);
                $('.chatMessages').attr('id', chat_msg_id);
                $('.chat_btn_cls').attr('id', chat_btn_id);	 
                $(".msgs-part").animate({ scrollTop: $(".msgs-part")[0].scrollHeight}, 1000);    
            }
        });	
            }   
            }else{
            $("#imgPathId").html("");
            let  chat_file=""; 
            $.ajax({
            url:AJAX_URL+"chat_action",  
                method:"POST",
                data:{to_user_id:to_user_id,device_id:device_id,chat_message:message,inventory_id:inventory_id,inventory_image_path:inventory_image_path, action:'insert_chat'},
                success:function(response) { 
                    body.removeClass("loading"); 
                    $('.attach').addClass("attach1");  
                    $('.msg-sent').attr("disabled",false);
                    $('.chattxt').attr("disabled",false); 
                var resp = $.parseJSON(response);
                    $('#chat_message').html(resp.conversation); 
                    let chat_file_id="chat_file"+to_user_id;
                    let chat_msg_id="chatMessage"+to_user_id;
                    let chat_btn_id="chatButton"+to_user_id;
                    $('.chat_file_id').attr('id', chat_file_id);
                    $('.chatMessages').attr('id', chat_msg_id);
                    $('.chat_btn_cls').attr('id', chat_btn_id);	 
                    $(".msgs-part").animate({ scrollTop: $(".msgs-part")[0].scrollHeight}, 1000);    
                }
            });
        }   
            }    
        $(document).on('click', '.list--item', function(){ 
            $('.list--item').removeClass('active-chat');
            $(this).removeClass('unread active-chat');
            $(this).addClass('read active-chat');
            var toUserId1 = $(this).data('touserid'); 
            let id1=toUserId1.split('_dev_');
        let toUserId=id1[0];
        let device_id=id1[1];  
        $("#uni_device_id").val(device_id);
            showUserChat(toUserId,device_id);
            $(".chatMessages").attr('id', 'chatMessage'+toUserId);
            $(".chatButton").attr('id', 'chatButton'+toUserId); 
            $(".chat_file_id").attr('id', 'chat_file'+toUserId); 
        $(".msgs-part").animate({ scrollTop: $(".msgs-part")[0].scrollHeight}, 1000);
        });	
        function showUserChat(to_user_id,device_id){
            var  body = $("body");

            body.addClass("loading"); 
            $.ajax({
                url:AJAX_URL+"chat_action", 
                method:"POST",
            
                data:{to_user_id:to_user_id,action:'show_chat'},
                dataType: "json",  
                beforeSend: function(){  
                    $(".gif-overlay").show();
                },
                success:function(response){ 
                    body.removeClass("loading"); 
  
                    if(response.conversation==''){
                        body.removeClass("loading"); 

                        let chat_file_id="chat_file"+to_user_id; 
                        let chat_btn_id="chatButton"+to_user_id;
                        let chat_msg_id="chatMessage"+to_user_id;
                        $('.chat_file_id').attr('id', chat_file_id);
                        $('.chatMessages').attr('id', chat_msg_id);
                        $('.chat_btn_cls').attr('id', chat_btn_id);
                        $('.msg-sent').attr("disabled",false);
                        $('.chattxt').attr("disabled",false);    
                        $('.attach').addClass("attach1");  
                        $(".msgs-part").html('<div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"><p id="loading-messages">No Messages</p></div>');
                        $(".msgs-part").animate({ scrollTop: $(".msgs-part")[0].scrollHeight}, 1000); 
                    }else{
                        body.removeClass("loading"); 

                    $('#chat_message').html(response.conversation);	 
                    let chat_file_id="chat_file"+to_user_id; 
                    let chat_btn_id="chatButton"+to_user_id;
                    let chat_msg_id="chatMessage"+to_user_id;
                    $('.chat_file_id').attr('id', chat_file_id);
                    $('.chatMessages').attr('id', chat_msg_id);
                    $('.chat_btn_cls').attr('id', chat_btn_id);
                    $('.msg-sent').attr("disabled",false);
                    $('.chattxt').attr("disabled",false);    
                    $('.attach').addClass("attach1");  
                    $(".msgs-part").animate({ scrollTop: $(".msgs-part")[0].scrollHeight}, 1000); 
                    } 
                },
                complete:function(data){
                    $(".gif-overlay").hide();
                }
            });
        }

        $('.chattxt').keypress(function (e) {    
            var key = e.which;
            if(key == 13)
            {
                $('.submit').trigger('click'); 
            } 
        });  

        
        function updateUserChat() { 
            $('div.list--item.chat-list-menber.active').each(function(){  
                var to_user_id = $(this).attr('data-touserid'); 
                $.ajax({
                    url:AJAX_URL+"chat_action", 
                    method:"POST",
                    data:{to_user_id:to_user_id,action:'update_user_chat'}, 
                    success:function(response){	
                        body.removeClass("loading"); 

                        var resp = $.parseJSON(response); 
                        $('#chat_message').html(resp.conversation);       
                    }
                });
            }); 
        }

        // $( window ).on( "load", function() {
        //     setInterval(function(){
        //     }, 10000); 
            
        //     $(".msgs-part").animate({ scrollTop: $(".msgs-part")[0].scrollHeight}, 1000);  
        // }); 