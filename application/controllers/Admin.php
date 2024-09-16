<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public $CI = NULL; 
	public function __construct(){
        parent::__construct();   
		$this->load->library('common');     
        $this->load->model('AdminModel','',TRUE);
        $this->load->model('CommonModel','',TRUE);
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper("jwt_helper");
		$this->CI = & get_instance();
		$this->load->library('firebase');

    }
    public function set_time_zone(){
		$time_zone=$this->input->post('time_zone');
		 $this->session->set_userdata('time_zone',$time_zone);
		echo json_encode(array('success'=>'success'));
	}
/*************** Common Methods ***********************/
public function common_data()
    {

		  $this->session->userdata('time_zone');
       date_default_timezone_set($this->session->userdata('time_zone'));
          $post_date = date('Y-m-d');
        $timestamp = date("Y-m-d H:i:s");
		  $post_time = date("H:i:s");
        $data["post_date"] = $post_date;
		$data["post_time"] = $post_time;
        $data["timestamp"] = $timestamp;

		$data['access_token_header']=""; 

		$access_token_header = array('Content-Type:application/json','Accesstoken:'.globalAccessToken);
		$data['access_token_header']=$access_token_header;

       
        $data['admin_session_id']="1";
        $data['admin_session_email']= "";
        $data['admin_session_name'] = "";  $data['admin_session_token'] = ""; 
        
       if($this->session->userdata("admin_session_id")=="" || $this->session->userdata("admin_session_id")==null){
            redirect("/");
        }
	
        $data['admin_session_id']= $this->session->userdata("admin_session_id");
		$data['admin_session_token']= $this->session->userdata("admin_session_token");
		$data['admin_session_email'] = $this->session->userdata("admin_session_email");
		$data['admin_session_name'] = $this->session->userdata("admin_session_name");  
		$data['login_access_token_header']="";
		if($data['admin_session_token']!="")
		{
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			$data['login_access_token_header']=$login_access_token_header;
		}
        return $data;
	}
	public function encryption($payload) {
    	return $encryptedId = JWT::encode($payload,pkey);
    }
    public function decryption($cipher) {
    	return $encryptedId = JWT::decode($cipher,pkey);
    }
	/*************** Common Methods ***********************/
	/*************** Common Geo Methods ***********************/
	function getDetailsByType($id,$view_type)
	{$data=$this->common_data();	
		if($view_type=="getCountry")
		{
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"country_id:".$id,"country_status:1","view_type:Continent");
 		    $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/country_details", array(), $login_access_token_header);
 			$countryDetails="";
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{ 
					 $countryDetails=$result->data;
				}
			}
			   return $countryDetails;
		}
		else if($view_type=="getStates")
		{
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"state_id:".$id,"state_status:1","view_type:Country");
			  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/state_details", array(), $login_access_token_header);
			 
			$stateDetails="";
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{ 
					 $stateDetails=$result->data;
				}
			}
			   return $stateDetails;
		}
		else if($view_type=="getCity")
		{
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"city_id:".$id,"city_status:1","view_type:States");
		  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/city_details", array(), $login_access_token_header);
			 
			$cityDetails="";
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{ 
					 $cityDetails=$result->data;
				}
			}
			   return $cityDetails;
		}
	}
	function getDetails()
	{ 
		$data=$this->common_data();	 
		  $view_type=$this->input->post('view_type'); 

		$data['continentDetails']=$getCountryDetails="";

		if($view_type=="getCountry")
		{
			$continent_id=$this->input->post('continent_id');

			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"country_id:".$continent_id,"country_status:1","view_type:Continent");
 		    $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/country_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status; 
			$getCountryDetails="<option value=''>Select Country</option>"; 
			if($status==200)
			{
				if($result->data!="")
				{ 
					 foreach($result->data as $info)
					 {
						$sk_country_id=$info->sk_country_id;
						$country_name=$info->country_name;
						$getCountryDetails=$getCountryDetails."<option value=$sk_country_id>$country_name</option>";
					 }
				}
			}
			 echo $getCountryDetails; 

		}
		else if($view_type=="getStates")
		{
			$country_id=$this->input->post('country_id');

			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"state_id:".$country_id,"state_status:1","view_type:Country");
 		    $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/state_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status; 
			$getStateDetails="<option value=''>Select State</option>"; 
			if($status==200)
			{
				if($result->data!="")
				{ 
					 foreach($result->data as $info)
					 {
						$sk_state_id=$info->sk_state_id;
						$state_name=$info->state_name;
						$getStateDetails=$getStateDetails."<option value=$sk_state_id>$state_name</option>";
					 }
				}
			}
			 echo $getStateDetails; 
		}
		else if($view_type=="getCity")
		{
			$state_id=$this->input->post('state_id');

			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"city_id:".$state_id,"city_status:1","view_type:States");
 		   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/city_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status; 
			$getCityDetails="<option value=''>Select City</option>"; 
			if($status==200)
			{
				if($result->data!="")
				{ 
					 foreach($result->data as $info)
					 {
						$sk_city_id=$info->sk_city_id;
						$city_name=$info->city_name;
						$getCityDetails=$getCityDetails."<option value=$sk_city_id>$city_name</option>";
					 }
				}
			}
			 echo $getCityDetails; 
		}
		elseif($view_type=="getLocation"){
			$city_id=$this->input->post('city_id');

			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"location_id:".$city_id,"location_status:1","view_type:city");
 		   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/location_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status; 
			$getLocationDetails="<option value=''>Select Location</option>"; 
			if($status==200)
			{
				if($result->data!="")
				{ 
					 foreach($result->data as $info)
					 {
						$sk_location_id=$info->sk_location_id;
						$location_name=$info->location_name;
						$getLocationDetails=$getLocationDetails."<option value=$sk_location_id>$location_name</option>";
					 }
				}
			}
			 echo $getLocationDetails; 
		}
		
	}
	function categoryDetails($category_id,$category_status,$view_type)
	{
		$data=$this->common_data();	 

		if($view_type=="Category"){
		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"category_id:".$category_id,"category_status:".$category_status);

		 $data['categoryDetails']=$categoryDetails="";
		 
			  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/settings/category_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{
					 $categoryDetails=$result->data;
				}
			}
			return $data['categoryDetails']=$categoryDetails;
		}
		else if($view_type=="CategorySubCategroy"){
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"category_id:All","category_status:".$category_status);

			$data['categoryDetails']=$categoryDetails="";
			
				 $makecall = $this->common->callAPI('GET', apiendpoint . "v1/settings/category_details", array(), $login_access_token_header);
	
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   if($status==200)
			   {
				$output="";
				   if($result->data!="")
				   {
						$categoryDetails=$result->data;
						foreach($categoryDetails as $info)
						{ 
							$output=$output."<optgroup label=$info->category_name>";
							$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"sub_category_id:".$info->category_id,"sub_category_status:1","view_type:Category");
  							
								$makecall = $this->common->callAPI('GET', apiendpoint . "v1/settings/sub_category_details", array(), $login_access_token_header);
								$sub_category_id=$sub_category_name="";
								$result = json_decode($makecall);
								$status=$result->status;  
								if($status==200)
								{
								   if($result->data!="")
								   {
									   $i=1;
									   foreach($result->data as $info1)
									   { 
										   $sub_category_name=$info1->sub_category_name; 
										   $sub_category_id=$info1->sk_sub_category_id;
										    
										   $cat_id=explode(",",$category_id);
										  
										   if (in_array($sub_category_id, $cat_id))
										   {									   
											 $selected="selected";
										   }else{$selected="";}
										   

										   $output=$output."<option value='$sub_category_id' $selected >$sub_category_name</option>";
										}
								   }
								}
								$output=$output."</optgroup>";
									
						}
				   }
			   }
			   return $output;
		}
	}
	function continentDetails($continent_id,$continent_status)
	{
		$data=$this->common_data();	 

		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"continent_id:".$continent_id,"continent_status:".$continent_status);

		 $data['continentDetails']=$continentDetails="";
		 
			  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/continent_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{
					 $continentDetails=$result->data;
				}
			}
			return $data['continentDetails']=$continentDetails;
	}
	function countryDetails($country_id,$country_status)
	{
		$data=$this->common_data();	 

		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"country_id:".$country_id,"country_status:".$country_status,"view_type:Country");

		 $data['countryDetails']=$countryDetails="";
		 
			  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/country_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{
					 $countryDetails=$result->data;
				}
			}
			return $data['countryDetails']=$countryDetails;
	}

	function cityDetails($city_id,$city_status)

	{

		$data=$this->common_data();	 

		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"city_id:".$city_id,"city_status:".$city_status,"view_type:City");

		 $data['cityDetails']=$cityDetails="";
		 
			 $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/city_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{
					 $cityDetails=$result->data;
				}
			}
			return $data['cityDetails']=$cityDetails;

	}
	function locationDetails($location_id,$location_status)
	{
		$data=$this->common_data();	 

		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"location_id:".$location_id,"location_status:".$location_status,"view_type:location");

		 $data['locationDetails']=$locationDetails="";
		 
		 	 $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/location_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{
					 $locationDetails=$result->data;
				}
			}
			return $data['locationDetails']=$locationDetails;

	}
	/*************** Common Geo Methods ***********************/
	/***************Login***********************/
	
	public function login_check() {
		
		$data='';

		$access_token_header = array('Content-Type:application/json','Accesstoken:'.globalAccessToken);
		$email = $this->input->post('email');
		$password=$this->input->post('password');

		$data_array = array('email'=>$email,'password'=>$password,'user_type'=>'admin','deviceId'=>'');
		// echo apiendpoint;
		  $makecall = $this->common->callAPI('POST', apiendpoint.'v1/Auth/signin', json_encode($data_array), $access_token_header);
		 // echo apiendpoint;
		
		$result = json_decode($makecall);
		$status=$result->status;
		$message=$result->message;
		 if($status==200)
		 {
			 if($result->data!=""){
				$name=$result->data->name;
				$email=$result->data->email;
				$userid=$result->data->userid;
				$session_token=$result->data->Accesstoken;
			 
					$sess_array = array(
						'sk_employee_id' =>$userid,
						'fullname' => $name,
						'email' => $email,
						'session_token'=>$session_token
						);
						$this->session->set_userdata("admin_session_id", $userid);
						$this->session->set_userdata("admin_session_name", $name);
						$this->session->set_userdata("admin_session_email", $email);
						$this->session->set_userdata("admin_session_token", $session_token);
						$this->session->set_userdata('logged_in', $sess_array);
								
						} 
						
						redirect(base_url()."dashboard",$data);
		}
		else
		{
			$this->session->set_flashdata('message', 'Invalid Email or Password');
			redirect(base_url());
		} 
	}
	public function logout() { 
		$this->session->sess_destroy();
         $this->session->unset_userdata('logged_in');		
         redirect(base_url());
    }
	/***********************Login******************************/
	public function index() {

	 $this->load->view('admin/login');
	}
	public function dashboard() {
		$data=$this->common_data();
		$data_array=array();
		$access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],'userId:All','userStatus:All','userType:user');
		 $makecall = $this->common->callAPI('GET', apiendpoint.'v1/Auth/user_details', json_encode($data_array),$access_token_header);
		 $result = json_decode($makecall);
		$status=$result->status;
		$message=$result->message;
		$count_users=0;
		 if($status==200){
			if($result->data->user_details!=""){
				 $count_users=count($result->data->user_details);
			}
		 }

		 $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"inventory_id:All","inventory_status:All","view_type:Inventory");
		 //var_dump($login_access_token_header);exit();
		 $data['inventory_details']=$output="";
		 
		   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Inventory/inventory_details", array(), $login_access_token_header);
			 //$category_id=$category_name=$category_image="";
			 $result = json_decode($makecall);
			 $status=$result->status;
			 $message=$result->message;
			 $count_inventories=0;
			  if($status==200){
				 if($result->data->inventory_details!=""){
					  $count_inventories=count($result->data->inventory_details);
				 }
			  }
			  $count_partners=0;
			  $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"partners_status:All","partners_id:All");

			  $data['partner_details']=$output="";
			  
				 $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Partner/partner_details", array(), $login_access_token_header);
				  $sk_inventory_price_id=$callper=$qty=$price=$price_status='';
				 $result = json_decode($makecall);
				 $status=$result->status;  
				 if($status==200)
				 {
					if($result->data->partner_details!=""){
						$count_partners=count($result->data->partner_details);
				   }
				}
				$getTaggedDetails=$this->AdminModel->getTaggedDetails('Tagged');
				$data['getTaggedDetails']=0;
				if($getTaggedDetails!=false){
					$data['getTaggedDetails']=count($getTaggedDetails);
				}
				$projects=$this->AdminModel->getProjectDetails();
				$data['projects']=0;
				if($getTaggedDetails!=false){
					$data['projects']=count($projects);
				}
				$getSaveDetails=$this->AdminModel->getSavedDetails();
				$data['getSaveDetails']=0;
if($getSaveDetails!=false){
	$data['getSaveDetails']=count($getSaveDetails);
}
		  $data['count_users']=$count_users;
		  $data['count_inventories']=$count_inventories;
		  $data['count_partners']=$count_partners;


		$this->load->view("admin/dashboard",$data);
	}
	

	 /* ===================== continent ===================== */
	 public function continent()
	 {
		$data=$this->common_data();	 

		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"continent_id:All","continent_status:All");

		 $data['continent_details']=$output="";
		 
			  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/continent_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{
					$i=1;
					foreach($result->data as $info)
					{
						$continent_name=$info->continent_name;
						$sk_continent_id=$info->sk_continent_id;
						$edit_url="";
						if($info->continent_status==1){
							$edit_url1=base_url()."continent-details/Edit/".base64_encode($sk_continent_id);
							$inactivate_url=base_url()."continent-details/InActivate/".base64_encode($sk_continent_id);
							$edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
							<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
						}
						else {
							$activate_url=base_url()."continent-details/Activate/".base64_encode($sk_continent_id);
							$edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
						}

						$output=$output."<tr>
						<td>$i</td>
						<td>$continent_name</td>
						<td>$edit_url</td>
						</tr>";
						$i++;
					} 
				}
			}
			$data['continent_details']=$output;
		$this->load->view("admin/geo/continent",$data);
	 }

	 public function continent_details()
	 {
		$data=$this->common_data();	 
		$login_access_token_header=$data['login_access_token_header'];

		   $operation_type=$this->uri->segment(2);
		   $continent_id=$this->uri->segment(3);
		   $decrypt_continentId=base64_decode($continent_id);

		if($operation_type=="Add")
		{ 
			$continent_name=$this->input->post('continent_name');	

			$data_array = array('continent_name'=>$continent_name);
		 
			 $makecall = $this->common->callAPI('POST', apiendpoint . "v1/geo/continent_details", json_encode($data_array), $login_access_token_header);

			$result = json_decode($makecall);
			$status=$result->status; 
			$message=$result->message;
			if($status==200)
			{
				if($result->data!=""){
					$this->session->set_flashdata('message', 'Continent Details Saved Successfully');
				}else{
					$this->session->set_flashdata('message', $message);
				}	
						
			}else {$this->session->set_flashdata('message', $message);}
		redirect(base_url()."continent");
		}
		else if($operation_type=="Edit")
		{ 
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"continent_id:".$decrypt_continentId,"continent_status:All");
 		    $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/continent_details", array(), $login_access_token_header);
			$data['continent_name']=$data['sk_continent_id']="";
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   if($status==200)
			   {
				   if($result->data!="")
				   {
					   foreach($result->data as $info)
					   {
						   $data['continent_name']=$info->continent_name;
						   $data['sk_continent_id']=$info->sk_continent_id;
					   }
					}
				}  
				$this->load->view("admin/geo/continent-edit",$data);
		}
		else if($operation_type=="update")
		{ 
			$continent_name=$this->input->post('continent_name');
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			$data_array=array("update_type"=>"Edit","continent_name"=>$continent_name,"sk_continent_id"=>$decrypt_continentId);
			 
 		      $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/continent_details", json_encode($data_array), $login_access_token_header);
		 
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   $message=$result->message; 
			   if($status==200)
			   { 
				   $this->session->set_flashdata('message',$message);
				   redirect(base_url()."continent");
				}   
		}
		else if($operation_type=="Activate")
		{ 
			$continent_name=$this->input->post('continent_name');
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			$data_array=array("update_type"=>"Activate","sk_continent_id"=>$decrypt_continentId);
			 
 		        $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/continent_details", json_encode($data_array), $login_access_token_header);
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   $message=$result->message; 
			   if($status==200)
			   {  
				   $this->session->set_flashdata('message',$message);
				   redirect(base_url()."continent");
				}   
		}
		else if($operation_type=="InActivate")
		{ 
			$continent_name=$this->input->post('continent_name');
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			$data_array=array("update_type"=>"InActivate","sk_continent_id"=>$decrypt_continentId);
			 
 		      $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/continent_details", json_encode($data_array), $login_access_token_header);
		 
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   $message=$result->message; 
			   if($status==200)
			   {  
				   $this->session->set_flashdata('message',$message);
				   redirect(base_url()."continent");
				}   
		}
	
    }
	/* ===================== continent ===================== */


	/* ===================== Country ===================== */
	public function country()
	{
	   $data=$this->common_data();	 

	   $data['continentDetails']=$this->continentDetails("All",1);
	   
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"country_id:All","country_status:All","view_type:Country");

		$data['country_details']=$output="";
		$continent_name=$sk_country_id=$country_name=$country_status=$continent_id=""; 
			  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/country_details", array(), $login_access_token_header);
 
		   $result = json_decode($makecall);
		   $status=$result->status;  
		   if($status==200)
		   {
			   if($result->data!="")
			   {
				  
				   $i=1;
				   foreach($result->data as $info)
				   { 
				 
					    $continent_name=$info->continent_name;
					   $sk_country_id=$info->sk_country_id;
					   $country_name=$info->country_name;
					   $country_status=$info->country_status;
					   $continent_id=$info->continent_id;
					   $edit_url="";
					   if($info->country_status==1){
						   $edit_url1=base_url()."country-details/Edit/".base64_encode($sk_country_id);
						   $inactivate_url=base_url()."country-details/InActivate/".base64_encode($sk_country_id);
						   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
						   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
					   }
					   else {
						   $activate_url=base_url()."country-details/Activate/".base64_encode($sk_country_id);
						   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					   }

					   $output=$output."<tr>
					   <td>$i</td>
					   <td>$continent_name</td>
					   <td>$country_name</td> 
					   <td>$edit_url</td>
					   </tr>";
					   $i++;
				   }
				 
			   }
		   }
		   $data['country_details']=$output;
	   $this->load->view("admin/geo/country",$data);
	}

	public function country_details()
	{
	   $data=$this->common_data();	 
	   $login_access_token_header=$data['login_access_token_header'];

		  $operation_type=$this->uri->segment(2);
		  $sk_country_id=$this->uri->segment(3);
		  $decrypt_countryId=base64_decode($sk_country_id);

	   if($operation_type=="Add")
	   { 
		   $continent_id=$this->input->post('continent_id');
		   $country_name=$this->input->post('country_name');	

		   $data_array = array('country_name'=>$country_name,'continent_id'=>$continent_id);
		
		   $makecall = $this->common->callAPI('POST', apiendpoint . "v1/geo/country_details", json_encode($data_array), $login_access_token_header);

		   $result = json_decode($makecall);
		   $status=$result->status; 
		   $message=$result->message;
		   if($status==200)
		   {
			if($result->data!=""){
			   $this->session->set_flashdata('message', 'Country Details Saved Successfully');
			}else{
			   $this->session->set_flashdata('message', $message);
			}
			
	   }else{
		$this->session->set_flashdata('message', $message);
	   }
	   redirect(base_url()."country");
   }
	   else if($operation_type=="Edit")
	   { 	   
		  	 $data['continentDetails']=$this->continentDetails("All",1);
		   	$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"country_id:".$decrypt_countryId,"country_status:All","view_type:Country");
		   	$makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/country_details", array(), $login_access_token_header);
		   	$data['country_name']=$data['sk_country_id']=$data['coninent_id']="";
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  if($status==200)
			  {
				  if($result->data!="")
				  {
					  foreach($result->data as $info)
					  {
						  $data['country_name']=$info->country_name;
						  $data['sk_country_id']=$info->sk_country_id;
						  $data['continent_id']=$info->continent_id;
					  }
				   }
			   }  
			   $this->load->view("admin/geo/country-edit",$data);
	   }
	   else if($operation_type=="update")
	   { 
		$continent_id=$this->input->post('continent_id');
		$country_name=$this->input->post('country_name');	

			$data_array = array("update_type"=>"Edit",'country_name'=>$country_name,'continent_id'=>$continent_id,'sk_country_id'=>$decrypt_countryId);
		  	$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']); 
			
			    $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/country_details", json_encode($data_array), $login_access_token_header);
		
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==true)
			  { 
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."country");
			   }   
	   }
	   else if($operation_type=="Activate")
	   { 
		   
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Activate","sk_country_id"=>$decrypt_countryId);
			
				$makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/country_details", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."country");
			   }   
	   }
	   else if($operation_type=="InActivate")
	   { 
		   
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"InActivate","sk_country_id"=>$decrypt_countryId);
			
			  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/country_details", json_encode($data_array), $login_access_token_header);
		
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."country");
			   }   
	   }
   
   }
   /* ===================== Country ===================== */

   /* ===================== State  ===================== */
	public function state()
	{
	   $data=$this->common_data();	 

	   $data['continentDetails']=$this->continentDetails("All",1);
	   $data['countryDetails']=$this->countryDetails("All",1);
	   
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"state_id:All","state_status:All","view_type:States");

		$data['state_details']=$output="";
		$continent_name=$sk_state_id=$country_name=$country_status=$continent_id=$state_name=""; 
		$makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/state_details", array(), $login_access_token_header);
 
		   $result = json_decode($makecall);
		   $status=$result->status;  
		   if($status==200)
		   {
			   if($result->data!="")
			   {
				  
				   $i=1;
				   foreach($result->data as $info)
				   { 
				 
					    $continent_name=$info->continent_name; 
					   $country_name=$info->country_name;
					   $sk_state_id=$info->sk_state_id;
					   $state_name=$info->state_name;
					   $state_status=$info->state_status;
					   $continent_id=$info->continent_id;
					   $country_id=$info->country_id;
					   $edit_url="";
					   if($state_status==1){
						   $edit_url1=base_url()."state-details/Edit/".base64_encode($sk_state_id);
						   $inactivate_url=base_url()."state-details/InActivate/".base64_encode($sk_state_id);
						   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
						   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
					   }
					   else {
						   $activate_url=base_url()."state-details/Activate/".base64_encode($sk_state_id);
						   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					   }

					   $output=$output."<tr>
					   <td>$i</td>
					   <td>$continent_name</td>
					   <td>$country_name</td> 
					   <td>$state_name</td> 
					   <td>$edit_url</td>
					   </tr>";
					   $i++;
				   }
				 
			   }
		   }
		   $data['state_details']=$output;
	   $this->load->view("admin/geo/state",$data);
	}

	public function state_details()
	{
	   $data=$this->common_data();	 
	   $login_access_token_header=$data['login_access_token_header'];

		  $operation_type=$this->uri->segment(2);
		  $sk_state_id=$this->uri->segment(3);
		  $decrypt_stateId=base64_decode($sk_state_id);

	   if($operation_type=="Add")
	   { 
		   $continent_id=$this->input->post('continent_id');
		   $country_id=$this->input->post('country_id');
		   $state_name=$this->input->post('state_name');	

		   $data_array = array('state_name'=>$state_name,'continent_id'=>$continent_id,'country_id'=>$country_id);
		
		   $makecall = $this->common->callAPI('POST', apiendpoint . "v1/geo/state_details", json_encode($data_array), $login_access_token_header);

		   $result = json_decode($makecall);
		   $status=$result->status; 
		   $message=$result->message;
		   if($status==200)
		   {
			if($result->data!=""){
			   $this->session->set_flashdata('message', 'State Details Saved Successfully');
			}else{
			   $this->session->set_flashdata('message', $message);
			}
			redirect(base_url()."state");
	   }
   }
	   else if($operation_type=="Edit")
	   { 	   
		  	 $data['continentDetails']=$this->continentDetails("All",1);
			
		   	$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"state_id:".$decrypt_stateId,"state_status:All","view_type:States");
		   	$makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/state_details", array(), $login_access_token_header);
		   	$data['country_name']=$data['sk_country_id']=$data['coninent_id']="";
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  if($status==200)
			  {
				  if($result->data!="")
				  {
					  foreach($result->data as $info)
					  {
						$data['sk_state_id']=$info->sk_state_id;
						$data['state_name']=$info->state_name;
						$data['state_status']=$info->state_status;
						$data['continent_id']=$info->continent_id;
						$data['continent_name']=$info->continent_name;							
						$data['country_id']=$info->country_id;
						$data['country_name']=$info->country_name; 
					  }
				   }
			   }  
			   $data['countryDetails']=$this->getDetailsByType($data['continent_id'],'getCountry');
			 
			  $this->load->view("admin/geo/state-edit",$data);
	   }
	   else if($operation_type=="update")
	   { 
		   $continent_id=$this->input->post('continent_id');
		   $country_id=$this->input->post('country_id');
		   $state_name=$this->input->post('state_name');	

		   
			$data_array = array("update_type"=>"Edit",'state_name'=>$state_name,'country_id'=>$country_id,'continent_id'=>$continent_id,'sk_state_id'=>$decrypt_stateId);
		  	$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']); 
			
			$makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/state_details", json_encode($data_array), $login_access_token_header);
		
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==true)
			  { 
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."state");
			   }   
	   }
	   else if($operation_type=="Activate")
	   { 
		   
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Activate","sk_state_id"=>$decrypt_stateId);
			
		    $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/state_details", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."state");
			   }   
	   }
	   else if($operation_type=="InActivate")
	   { 
		   
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"InActivate","sk_state_id"=>$decrypt_stateId);
			
			  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/state_details", json_encode($data_array), $login_access_token_header);
		
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."state");
			   }   
	   }
   
   }
   /* ===================== State  ===================== */

  /* =====================  City  ===================== */
	public function city()
	{
	   $data=$this->common_data();	 

	   $data['continentDetails']=$this->continentDetails("All",1);
	   $data['countryDetails']=$this->countryDetails("All",1);
	   
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"city_id:All","city_status:All","view_type:City");
		
		$data['city_details']=$output="";
		$continent_name=$sk_state_id=$country_name=$country_status=$continent_id=$state_name=$state_id=$city_name=""; 
		$makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/city_details", array(), $login_access_token_header);
 
		   $result = json_decode($makecall);
		   $status=$result->status;  
		   if($status==200)
		   {
			   if($result->data!="")
			   {
				  
				   $i=1;
				   foreach($result->data as $info)
				   { 
				 
					    $continent_name=$info->continent_name; 
					   $country_name=$info->country_name;
					   $sk_city_id=$info->sk_city_id;
					   $state_name=$info->state_name;
					   $city_name=$info->city_name;
					   $city_status=$info->city_status;
					   $continent_id=$info->continent_id;
					   $country_id=$info->country_id;
					   $state_id=$info->state_id;
					   $edit_url="";
					   if($city_status==1){
						   $edit_url1=base_url()."city-details/Edit/".base64_encode($sk_city_id);
						   $inactivate_url=base_url()."city-details/InActivate/".base64_encode($sk_city_id);
						   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
						   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
					   }
					   else {
						   $activate_url=base_url()."city-details/Activate/".base64_encode($sk_city_id);
						   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					   }

					   $output=$output."<tr>
					   <td>$i</td>
					   <td>$continent_name</td>
					   <td>$country_name</td> 
					   <td>$state_name</td> 
					   <td>$city_name</td> 
					   <td>$edit_url</td>
					   </tr>";
					   $i++;
				   }
				 
			   }
		   }
		   $data['city_details']=$output;
	   $this->load->view("admin/geo/city",$data);
	}

	public function city_details()
	{
	   $data=$this->common_data();	 
	   $login_access_token_header=$data['login_access_token_header'];

		  $operation_type=$this->uri->segment(2);
		  $sk_city_id=$this->uri->segment(3);
		  $decrypt_CityId=base64_decode($sk_city_id);

	   if($operation_type=="Add")
	   { 
		   $continent_id=$this->input->post('continent_id');
		   $country_id=$this->input->post('country_id');
		   $state_id=$this->input->post('state_id');	
		   $city_name=$this->input->post('city_name');

		   $data_array = array('city_name'=>$city_name,'state_id'=>$state_id,'continent_id'=>$continent_id,'country_id'=>$country_id);
		
		    $makecall = $this->common->callAPI('POST', apiendpoint . "v1/geo/city_details", json_encode($data_array), $login_access_token_header);

		   $result = json_decode($makecall);
		   $status=$result->status; 
		   $message=$result->message;
		   if($status==200)
		   {
			if($result->data!=""){
			   $this->session->set_flashdata('message', 'City Details Saved Successfully');
			}else{
			   $this->session->set_flashdata('message', $message);
			}
			
	   }
	   else{ $this->session->set_flashdata('message', $message);}
	   redirect(base_url()."city");
   }
	   else if($operation_type=="Edit")
	   { 	   
		  	 $data['continentDetails']=$this->continentDetails("All",1);
			
		   	$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"city_id:".$decrypt_CityId,"city_status:All","view_type:City");
			$makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/city_details", array(), $login_access_token_header);
		 
		   	$data['country_name']=$data['sk_country_id']=$data['coninent_id']="";
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  if($status==200)
			  {
				  if($result->data!="")
				  {
					  foreach($result->data as $info)
					  {
						$data['sk_city_id']=$info->sk_city_id;
						$data['city_name']=$info->city_name;						
						$data['city_status']=$info->city_status;
						$data['state_id']=$info->state_id;
						$data['state_name']=$info->state_name;	
						$data['country_id']=$info->country_id;
						$data['country_name']=$info->country_name; 
						$data['continent_id']=$info->continent_id;
						$data['continent_name']=$info->continent_name;
					  }
				   }
			   }  
			   $data['continentDetails']=$this->continentDetails("All",1);
			   $data['countryDetails']=$this->getDetailsByType($data['continent_id'],'getCountry');
			   $data['stateDetails']=$this->getDetailsByType($data['country_id'],'getStates');
			 
			  $this->load->view("admin/geo/city-edit",$data);
	   }
	   else if($operation_type=="update")
	   { 
		   $continent_id=$this->input->post('continent_id');
		   $country_id=$this->input->post('country_id');
		   $state_id=$this->input->post('state_id');
		   $city_name=$this->input->post('city_name');	

		   
			$data_array = array("update_type"=>"Edit",'city_name'=>$city_name,'state_id'=>$state_id,'country_id'=>$country_id,'continent_id'=>$continent_id,'sk_city_id'=>$decrypt_CityId);
		  	$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']); 
			
		 	$makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/city_details", json_encode($data_array), $login_access_token_header);
		
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==true)
			  { 
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."city");
			   }   
	   }
	   else if($operation_type=="Activate")
	   { 
		   
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Activate","sk_city_id"=>$decrypt_CityId);
			
		    $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/city_details", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."city");
			   }   
	   }
	   else if($operation_type=="InActivate")
	   {  
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"InActivate","sk_city_id"=>$decrypt_CityId);
			
			   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/city_details", json_encode($data_array), $login_access_token_header);
		
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."city");
			   }   
	   }
   
   }
   /* =====================  City  ===================== */
public function location(){

	$data=$this->common_data();	 

	$data['continentDetails']=$this->continentDetails("All",1);
	$data['countryDetails']=$this->countryDetails("All",1);
	$data['cityDetails']=$this->cityDetails("All",1);
	
	$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"location_id:All","location_status:All","view_type:location");

	 $data['location_details']=$output="";
	 $sk_location_id=$location_name=$location_status=$city_id=$city_name=$state_name=$state_id=$country_id=$country_name="";
	  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/location_details", array(), $login_access_token_header);
 
		$result = json_decode($makecall);
		$status=$result->status;  
		if($status==200)
		{
			if($result->data!="")
			{
			   
				$i=1;
				foreach($result->data as $info)
				{ 
			  
					 $sk_location_id=$info->sk_location_id; 
					$location_name=$info->location_name;
					$location_status=$info->location_status;
					$pincode=$info->pincode;
					$city_id=$info->city_id;
					$city_name=$info->city_name;
					$state_id=$info->state_id;
					$state_name=$info->state_name;
					$country_id=$info->country_id;
					$country_name=$info->country_name;
					//$continent_id=$info->continent_id;
					$continent_name=$info->continent_name;



					$edit_url="";
					if($location_status==1){
						$edit_url1=base_url()."location-details/Edit/".base64_encode($sk_location_id);
						$inactivate_url=base_url()."location-details/InActivate/".base64_encode($sk_location_id);
						$edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
						<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
					}
					else {
						$activate_url=base_url()."location-details/Activate/".base64_encode($sk_location_id);
						$edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					}

					$output=$output."<tr>
					<td>$i</td>
					<td>$continent_name</td>
					<td>$country_name</td> 
					<td>$state_name</td> 
					<td>$city_name</td>
					<td>$location_name</td>
					<td>$pincode</td>
					<td>$edit_url</td>
					</tr>";
					$i++;
				}
			  
			}
		}
		$data['location_details']=$output;
	
		
		
	$this->load->view("admin/geo/location",$data);
}

public function location_details(){
	$data=$this->common_data();	 
	$login_access_token_header=$data['login_access_token_header'];

	   $operation_type=$this->uri->segment(2);
	   $sk_location_id=$this->uri->segment(3);
	   $decrypt_CityId=base64_decode($sk_location_id);

	if($operation_type=="Add")
	{  
		$continent_id=$this->input->post('continent_id');
		$country_id=$this->input->post('country_id');
		$state_id=$this->input->post('state_id');	
		$city_id=$this->input->post('city_id');
		$location_name=$this->input->post('location_name');
		$pincode=$this->input->post('pincode');

		$data_array = array('continent_id'=>$continent_id,'country_id'=>$country_id,'state_id'=>$state_id,'city_id'=>$city_id,'location_name'=>$location_name,'pincode'=>$pincode);
	 
		 $makecall = $this->common->callAPI('POST', apiendpoint . "v1/geo/location_details", json_encode($data_array), $login_access_token_header);

		$result = json_decode($makecall);
		$status=$result->status; 
		$message=$result->message;
		if($status==200)
		{
		 if($result->data!=""){
			$this->session->set_flashdata('message', 'location Details Saved Successfully');
		 }else{
			$this->session->set_flashdata('message', $message);
		 }
		 
	}
	else{ $this->session->set_flashdata('message', $message);}
	redirect(base_url()."location");
}
	else if($operation_type=="Edit")
	{ 	   
			$data['continentDetails']=$this->continentDetails("All",1);
		 
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"location_id:".$decrypt_CityId,"location_status:All","view_type:location");
		   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/geo/location_details", array(), $login_access_token_header);
		 
	  
		   $data['sk_location_id']=$data['location_name']=$data['location_status']=$data['continent_id']=$data['country_id']=$data['state_id']=$data['city_id']=$data['pincode']="";

		  
		   $result = json_decode($makecall);
		   $status=$result->status;  
		   if($status==200)
		   {
			   if($result->data!="")
			   {
				   foreach($result->data as $info)
				   {
					 $data['sk_location_id']=$info->sk_location_id;
					 $data['location_name']=$info->location_name;						
					 $data['location_status']=$info->location_status;
					 $data['continent_id']=$info->continent_id;
					 $data['country_id']=$info->country_id;	
					 $data['state_id']=$info->state_id;
					 $data['city_id']=$info->city_id; 
					 $data['pincode']=$info->pincode; 
				   }
				}
			}  
			$data['continentDetails']=$this->continentDetails("All",1);
			$data['countryDetails']=$this->getDetailsByType($data['continent_id'],'getCountry');
			$data['stateDetails']=$this->getDetailsByType($data['country_id'],'getStates');
			$data['cityDetails']=$this->getDetailsByType($data['state_id'],'getCity');
		  
		   $this->load->view("admin/geo/location-edit",$data);
	}
	else if($operation_type=="update")
	{ 
		$continent_id=$this->input->post('continent_id');
		$country_id=$this->input->post('country_id');
		$state_id=$this->input->post('state_id');
		$city_id=$this->input->post('city_id');	
		$location_name=$this->input->post('location_name');	
		$pincode=$this->input->post('pincode');	
		
		 $data_array = array("update_type"=>"Edit",'continent_id'=>$continent_id,'country_id'=>$country_id,'state_id'=>$state_id,'city_id'=>$city_id,'location_name'=>$location_name,'pincode'=>$pincode,'sk_location_id'=>$decrypt_CityId);
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']); 
		 
		  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/location_details", json_encode($data_array), $login_access_token_header);
	 
		   $result = json_decode($makecall);
		   $status=$result->status;  
		   $message=$result->message; 
		   if($status==true)
		   { 
			   $this->session->set_flashdata('message',$message);
			   redirect(base_url()."location");
			}   
	}
	else if($operation_type=="Activate")
	{ 
		
		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		$data_array=array("update_type"=>"Activate","sk_location_id"=>$decrypt_CityId);
		 
		 $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/location_details", json_encode($data_array), $login_access_token_header);
		   $result = json_decode($makecall);
		   $status=$result->status;  
		   $message=$result->message; 
		   if($status==200)
		   {  
			   $this->session->set_flashdata('message',$message);
			   redirect(base_url()."location");
			}   
	}
	else if($operation_type=="InActivate")
	{  
		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		$data_array=array("update_type"=>"InActivate","sk_location_id"=>$decrypt_CityId);
		 
			$makecall = $this->common->callAPI('PUT', apiendpoint . "v1/geo/location_details", json_encode($data_array), $login_access_token_header);
	 
		   $result = json_decode($makecall);
		   $status=$result->status;  
		   $message=$result->message; 
		   if($status==200)
		   {  
			   $this->session->set_flashdata('message',$message);
			   redirect(base_url()."location");
			}   
	}
}
	 /* ===================== Category ===================== */
	 public function category()
	 {
		$data=$this->common_data();	 

		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"category_id:All","category_status:1");

		 $data['category_details']=$output="";
		 
			$makecall = $this->common->callAPI('GET', apiendpoint . "v1/settings/category_details", array(), $login_access_token_header);
 			$category_id=$category_name=$category_image="";
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{
					$i=1;
					foreach($result->data as $info)
					{
						$category_name=$info->category_name;
						$category_img=$info->category_image;
						$category_id=$info->category_id;
						$category_image=apiendpoint."uploads/category/".$category_img;
						$edit_url="";
						if($info->category_status==1){
							$edit_url1=base_url()."category-details/Edit/".base64_encode($category_id);
							$inactivate_url=base_url()."category-details/InActivate/".base64_encode($category_id);
							$edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
							<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
						}
						else {
							$activate_url=base_url()."category-details/Activate/".base64_encode($category_id);
							$edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
						}

						$output=$output."<tr>
						<td>$i</td>
						<td>$category_name</td>
						<td><img src='$category_image' width='100px' height='100px'></td>
						<td>$edit_url</td>
						</tr>";
						$i++;
					} 
				}
			}
			$data['category_details']=$output;
		$this->load->view("admin/settings/category",$data);
	 }

	 public function category_details()
	 {
		$data=$this->common_data();	 
		$login_access_token_header=$data['login_access_token_header'];

		   $operation_type=$this->uri->segment(2);
		   $category_id=$this->uri->segment(3);
		   $decrypt_categoryId=base64_decode($category_id);

		if($operation_type=="Add")
		{ 
			 $category_name=$this->input->post('category_name');	
			 $category_image="";
			if($_FILES["category_image"]["tmp_name"]!="" ||  $_FILES["category_image"]["tmp_name"]!=NULL){$check = getimagesize($_FILES["category_image"]["tmp_name"]);}
 				if($check != false) {
					 $img_path = $_FILES["category_image"]["name"]; 
					$type = pathinfo($img_path, PATHINFO_EXTENSION);

					$img_data = @file_get_contents($_FILES["category_image"]["tmp_name"]); 
					$base64_code = base64_encode($img_data); 
					$category_image = 'data:image/' . $type . ';base64,' . $base64_code; 
				 }
 
			$data_array = array('category_name'=>$category_name,'category_image'=>$category_image);
		 
			  $makecall = $this->common->callAPI('POST', apiendpoint . "v1/settings/category_details", json_encode($data_array), $login_access_token_header);

			$result = json_decode($makecall);
			$status=$result->status; 
			$message=$result->message;
			if($status==200)
			{
				if($result->data!=""){
					$this->session->set_flashdata('message', 'Category Details Saved Successfully');
				}else{
					$this->session->set_flashdata('message', $message);
				}	
						
			}else {$this->session->set_flashdata('message', $message);}
			redirect(base_url()."category");
		}
		else if($operation_type=="Edit")
		{ 
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"category_id:".$decrypt_categoryId,"category_status:All");
 		    $makecall = $this->common->callAPI('GET', apiendpoint . "v1/settings/category_details", array(), $login_access_token_header);
			 
			$data['category_name']=$data['sk_category_id']="";
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   if($status==200)
			   {
				   if($result->data!="")
				   {
					   foreach($result->data as $info)
					   {
						   $data['category_name']=$info->category_name;
						   $category_img=$info->category_image;
						   $data['category_image']=apiendpoint."uploads/category/".$category_img;
						   $data['sk_category_id']=$info->category_id;
					   }
					}
				}  
				$this->load->view("admin/settings/category-edit",$data);
		}
		else if($operation_type=="update")
		{ 
			$category_name=$this->input->post('category_name');
			$category_image="";
			if($_FILES["category_image"]["tmp_name"]!="" ||  $_FILES["category_image"]["tmp_name"]!=NULL){$check = getimagesize($_FILES["category_image"]["tmp_name"]);}
 				if($check != false) {
					 $img_path = $_FILES["category_image"]["name"]; 
					$type = pathinfo($img_path, PATHINFO_EXTENSION);

					$img_data = @file_get_contents($_FILES["category_image"]["tmp_name"]); 
					$base64_code = base64_encode($img_data); 
					$category_image = 'data:image/' . $type . ';base64,' . $base64_code; 
				 }
 


			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			$data_array=array("update_type"=>"Edit","category_name"=>$category_name,"category_image"=>$category_image,"sk_category_id"=>$decrypt_categoryId);
			 
 		      $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/settings/category_details", json_encode($data_array), $login_access_token_header);
		 
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   $message=$result->message; 
			   if($status==200)
			   { 
				   $this->session->set_flashdata('message',$message);
				   redirect(base_url()."category");
				}   
		}
		else if($operation_type=="Activate")
		{  
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			$data_array=array("update_type"=>"Activate","sk_category_id"=>$decrypt_categoryId);
			 
 		        $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/settings/category_details", json_encode($data_array), $login_access_token_header);
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   $message=$result->message; 
			   if($status==200)
			   {  
				   $this->session->set_flashdata('message',$message);
				  redirect(base_url()."category");
				}   
		}
		else if($operation_type=="InActivate")
		{  
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			$data_array=array("update_type"=>"InActivate","sk_category_id"=>$decrypt_categoryId);
			 
 		      $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/settings/category_details", json_encode($data_array), $login_access_token_header);
		 
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   $message=$result->message; 
			   if($status==200)
			   {  
				   $this->session->set_flashdata('message',$message);
				  redirect(base_url()."category");
				}   
		}
	
    }
	/* ===================== Category ===================== */

	/* ===================== sub Category ===================== */
	public function sub_category()
	{
	   $data=$this->common_data();	 

	   $data['categoryDetails']=$this->categoryDetails("All",1,'Category'); 

	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"sub_category_id:All","sub_category_status:All","view_type:subcategory");

		$data['sub_category_details']=$output="";
		
			$makecall = $this->common->callAPI('GET', apiendpoint . "v1/settings/sub_category_details", array(), $login_access_token_header);
		    $sub_category_id=$sub_category_name=$category_id=$category_name="";
		   	$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
			   if($result->data!="")
			   {
				   $i=1;
				   foreach($result->data as $info)
				   {
					   $category_id=$info->category_id;
					   $sub_category_name=$info->sub_category_name;
					   $category_name=$info->category_name;
					   $sub_category_id=$info->sk_sub_category_id;
					   $edit_url="";
					   if($info->sub_category_status==1){
						   $edit_url1=base_url()."sub-category-details/Edit/".base64_encode($sub_category_id);
						   $inactivate_url=base_url()."sub-category-details/InActivate/".base64_encode($sub_category_id);
						   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
						   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
					   }
					   else {
						   $activate_url=base_url()."sub-category-details/Activate/".base64_encode($sub_category_id);
						   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					   }

					   $output=$output."<tr>
					   <td>$i</td>
					   <td>$category_name</td>
					   <td>$sub_category_name</td>
					   <td>$edit_url</td>
					   </tr>";
					   $i++;
				   } 
			   }
		   }
		   $data['sub_category_details']=$output;
	   $this->load->view("admin/settings/sub-category",$data);
	}

	public function sub_category_details()
	{
	   $data=$this->common_data();	 
	   $login_access_token_header=$data['login_access_token_header'];

		  $operation_type=$this->uri->segment(2);
		  $sk_sub_category_id=$this->uri->segment(3);
		  $decrypt_sub_categoryId=base64_decode($sk_sub_category_id);

	   if($operation_type=="Add")
	   { 
		   $category_id=$this->input->post('category_id');	
		   $sub_category_name=$this->input->post('sub_category_name'); 

		   $data_array = array('sub_category_name'=>$sub_category_name,'category_id'=>$category_id);
		
		    $makecall = $this->common->callAPI('POST', apiendpoint . "v1/settings/sub_category_details", json_encode($data_array), $login_access_token_header);

		   $result = json_decode($makecall);
		   $status=$result->status; 
		   $message=$result->message;
		   if($status==200)
		   {
			   if($result->data!=""){
				   $this->session->set_flashdata('message', 'Sub Category Details Saved Successfully');
			   }else{
				   $this->session->set_flashdata('message', $message);
			   }	
					   
		   }else {$this->session->set_flashdata('message', $message);}
		   redirect(base_url()."sub_category");
	   }
	   else if($operation_type=="Edit")
	   { 
		$data['categoryDetails']=$this->categoryDetails("All",1,'Category'); 
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"sub_category_id:".$decrypt_sub_categoryId,"sub_category_status:All","view_type:subcategory");
			  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/settings/sub_category_details", array(), $login_access_token_header);
			 
			$data['category_id']= $data['sub_category_name']=$data['sk_sub_category_id']="";
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  if($status==200)
			  {
				  if($result->data!="")
				  {
					  foreach($result->data as $info)
					  {
						  $data['sub_category_name']=$info->sub_category_name;
						  $data['category_id']=$info->category_id;
						  $data['sk_sub_category_id']=$info->sk_sub_category_id;
					  }
				   }
			   }  
			   $this->load->view("admin/settings/sub-category-edit",$data);
	   }
	   else if($operation_type=="update")
	   { 
		   $sub_category_name=$this->input->post('sub_category_name');
		   $category_id=$this->input->post('category_id');
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Edit","sub_category_name"=>$sub_category_name,'category_id'=>$category_id,"sk_sub_category_id"=>$decrypt_sub_categoryId);
			
			  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/settings/sub_category_details", json_encode($data_array), $login_access_token_header);
		
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  { 
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."sub_category");
			   }   
	   }
	   else if($operation_type=="Activate")
	   {  
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Activate","sk_sub_category_id"=>$decrypt_sub_categoryId);
			
				$makecall = $this->common->callAPI('PUT', apiendpoint . "v1/settings/sub_category_details", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."sub_category");
			   }   
	   }
	   else if($operation_type=="InActivate")
	   {  
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"InActivate","sk_sub_category_id"=>$decrypt_sub_categoryId);
			
			  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/settings/sub_category_details", json_encode($data_array), $login_access_token_header);
		
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."sub_category");
			   }   
	   }
   
   }
   /* ===================== sub Category ===================== */
/* ===================== Event ===================== */
public function getEventsView($location_id,$event_type)
{

	$data=$this->common_data();	 

	
	$data['locationDetails']=$this->locationDetails("All",1);
	$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"eventId:$location_id","event_status:All","event_type:".$event_type,"event_view:Location","userId:All");

	 $data['event_details']=$output="";
	 
		  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/event/event_details", array(), $login_access_token_header);

		$result = json_decode($makecall);
		$status=$result->status;  
		if($status==200)
		{
			if($result->data!="")
			{
				$i=1;
				foreach($result->data as $info)
				{
							$sk_event_id=$info->sk_event_id;
							$title=$info->title;
							$location_id=$info->location_id;
							$city_id=$info->city_id;
							$state_id=$info->state_id;
							$country_id=$info->country_id;
							$event_image=$info->event_image;
							$minimum_member=$info->minimum_member;
							$maximum_member=$info->maximum_member;
							$category_id=$info->category_id;
							$description=$info->description;
							$event_type=$info->event_type;
							$master_event_id=$info->master_event_id;
							$event_date=$info->event_date;
							$event_time=$info->event_time;
							$event_status=$info->event_status;
							$continent_name=$info->continent_name;
							$country_name=$info->country_name;
							$state_name=$info->state_name;
							$city_name=$info->city_name;
							$location_name=$info->location_name; 

					$edit_url="";
					if($info->event_status==1){
						$edit_url1=base_url()."event-details/Edit/".base64_encode($sk_event_id);
						$inactivate_url=base_url()."event-details/InActivate/".base64_encode($sk_event_id);
						$edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
						<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
					}
					else {
						$activate_url=base_url()."event-details/Activate/".base64_encode($sk_event_id);
						$edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					}

					$output=$output."<tr>
					<td>$i</td>
					<td>$title</td>
					<td>$location_name, $city_name,$state_name,$country_name,$continent_name</td>
					<td>$event_date</td>
					<td>$event_time</td>
					<td>$minimum_member - $maximum_member</td>
					<td>$description</td>
					<td>$edit_url</td>
					</tr>";
					$i++;
				} 
			}
		}
		return $data['event_details']=$output; 
}
public function events_add()
{
   $data=$this->common_data();	 
   //$data['continentDetails']=$this->continentDetails("All",1);
   $data['locationDetails']=$this->locationDetails("All",1);
   $data['CategorySubCategroyDetails']=$this->categoryDetails("All",1,'CategorySubCategroy');  
   $this->load->view("admin/event/events-add",$data);
}
public function events_view()
{
	$data=$this->common_data();	 

	
	$data['locationDetails']=$this->locationDetails("All",1);
	$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"eventId:All","event_status:All","event_type:Current Events","event_view:Location","userId:All");

	 $data['event_details']=$output="";
	 
		  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/event/event_details", array(), $login_access_token_header);

		$result = json_decode($makecall);
		$status=$result->status;  
		if($status==200)
		{
			if($result->data!="")
			{
				$i=1;
				foreach($result->data as $info)
				{
							$sk_event_id=$info->sk_event_id;
							$title=$info->title;
							$location_id=$info->location_id;
							$city_id=$info->city_id;
							$state_id=$info->state_id;
							$country_id=$info->country_id;
							$event_image=$info->event_image;
							$minimum_member=$info->minimum_member;
							$maximum_member=$info->maximum_member;
							$category_id=$info->category_id;
							$description=$info->description;
							$event_type=$info->event_type;
							$master_event_id=$info->master_event_id;
							$event_date=$info->event_date;
							$event_time=$info->event_time;
							$event_status=$info->event_status;
							$continent_name=$info->continent_name;
							$country_name=$info->country_name;
							$state_name=$info->state_name;
							$city_name=$info->city_name;
							$location_name=$info->location_name; 

					$edit_url="";
					if($info->event_status==1){
						$edit_url1=base_url()."event-details/Edit/".base64_encode($sk_event_id);
						$inactivate_url=base_url()."event-details/InActivate/".base64_encode($sk_event_id);
						$edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
						<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
					}
					else {
						$activate_url=base_url()."event-details/Activate/".base64_encode($sk_event_id);
						$edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					}

					$output=$output."<tr>
					<td>$i</td>
					<td>$title</td>
					<td>$location_name, $city_name,$state_name,$country_name,$continent_name</td>
					<td>$event_date</td>
					<td>$event_time</td>
					<td>$minimum_member - $maximum_member</td>
					<td>$description</td>
					<td>$edit_url</td>
					</tr>";
					$i++;
				} 
			}
		}
		$data['event_details']=$output; 	 
   $this->load->view("admin/event/events-view",$data);
}
public function event_details()
{
   $data=$this->common_data();	 
   $login_access_token_header=$data['login_access_token_header'];

	  $operation_type=$this->uri->segment(2);
	  $event_id=$this->uri->segment(3);
	  $decrypt_EventId=base64_decode($event_id);

   if($operation_type=="Add")
   { 
	    

		$title=$this->input->post('title');
	/* 	$continent_id=$this->input->post('continent_id');
		$country_id=$this->input->post('country_id');
		$state_id=$this->input->post('state_id');
		$city_id=$this->input->post('city_id'); */
		$location_id=$this->input->post('location_id');
		//$event_image=$this->input->post('event_image');
		$minimum_member=$this->input->post('minimum_member'); 
		$maximum_member=$this->input->post('maximum_member');
		$description=$this->input->post('description');
		$event_date=date('Y-m-d', strtotime($this->input->post('event_date')));
		$event_time=$this->input->post('event_time');
		$category=$this->input->post('category');
		$category_id=implode(',',$category);
		$event_type="MasterEvents";
 
		
		$event_image="";
			if($_FILES["event_image"]["tmp_name"]!="" ||  $_FILES["event_image"]["tmp_name"]!=NULL){$check = getimagesize($_FILES["event_image"]["tmp_name"]);}
 				if($check != false) {
					 $img_path = $_FILES["event_image"]["name"]; 
					$type = pathinfo($img_path, PATHINFO_EXTENSION);
					$img_data = @file_get_contents($_FILES["event_image"]["tmp_name"]); 
					$base64_code = base64_encode($img_data); 
					$event_image = 'data:image/' . $type . ';base64,' . $base64_code; 
				 }

				 

	  // $data_array = array('title'=>$title,'category_id'=>$category_id,'continent_id'=>$continent_id,'country_id'=>$country_id,'state_id'=>$state_id,'city_id'=>$city_id,'location_id'=>$location_id,'event_image'=>$event_image,'minimum_member'=>$minimum_member,'maximum_member'=>$maximum_member,'description'=>$description,'event_date'=>$event_date,'event_time'=>$event_time,'event_type'=>$event_type);
	  $data_array = array('title'=>$title,'category_id'=>$category_id,'location_id'=>$location_id,'event_image'=>$event_image,'minimum_member'=>$minimum_member,'maximum_member'=>$maximum_member,'description'=>$description,'event_date'=>$event_date,'event_time'=>$event_time,'event_type'=>$event_type);
	
	     $makecall = $this->common->callAPI('POST', apiendpoint . "v1/event/event_details", json_encode($data_array), $login_access_token_header);

	   $result = json_decode($makecall);
	   $status=$result->status; 
	   $message=$result->message;
	   if($status==200)
	   {
		   if($result->data!=""){
			   $this->session->set_flashdata('message', 'Event Details Saved Successfully');
		   }else{
			   $this->session->set_flashdata('message', $message);
		   }	
				   
	   }else {$this->session->set_flashdata('message', $message);}
   redirect(base_url()."events_add");
   }
   else if($operation_type=="Edit")
   { 
		$data['locationDetails']=$this->locationDetails("All",1);
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"eventId:".$decrypt_EventId,"event_status:All","event_type:Current Events","event_view:EVENT_VIEW","userId:All");
		  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/event/event_details", array(), $login_access_token_header);
		  $data['sk_event_id']=$data['title']=$data['location_id']=$data['city_id']=$data['state_id']=$data['country_id']=$data['event_image']=$data['minimum_member']=$data['maximum_member']=$data['category_id']=$data['description']=$data['event_type']=$data['master_event_id']=$data['master_event_id']=$data['event_date']=$data['event_time']="";
		  
		  $result = json_decode($makecall);
		  $status=$result->status;  
		  if($status==200)
		  {
			  if($result->data!="")
			  {
				  foreach($result->data as $info)
				  { 
					  $data['sk_event_id']=$info->sk_event_id;
					  $data['title']=$info->title;
					  $data['location_id']=$info->location_id;
					  $data['city_id']=$info->city_id;
					  $data['state_id']=$info->state_id;
					  $data['country_id']=$info->country_id;
					  $data['event_img']=$info->event_image;
					  
					  $data['event_image']=apiendpoint."uploads/events/".$data['event_img'];

					  $data['minimum_member']=$info->minimum_member;
					  $data['maximum_member']=$info->maximum_member;
					  $data['category_id']=$info->category_id;
					  $data['description']=$info->description;
					  $data['event_type']=$info->event_type;
					  $data['master_event_id']=$info->master_event_id;
					  $data['event_date']=date('m/d/Y', strtotime($info->event_date));
					  $data['event_time']=$info->event_time;
					  $data['event_status']=$info->event_status;						
				  }
			   }
		   }  
		   $data['CategorySubCategroyDetails']=$this->categoryDetails($data['category_id'],1,'CategorySubCategroy'); 
		   $this->load->view("admin/event/events-edit",$data);
   }
   else if($operation_type=="update")
   { 
	   
	$title=$this->input->post('title');
		$continent_id=$this->input->post('continent_id');
		$country_id=$this->input->post('country_id');
		$state_id=$this->input->post('state_id');
		$city_id=$this->input->post('city_id');
		$location_id=$this->input->post('location_id'); 
		$minimum_member=$this->input->post('minimum_member'); 
		$maximum_member=$this->input->post('maximum_member');
		$description=$this->input->post('description');
		$event_date=date('Y-m-d', strtotime($this->input->post('event_date')));
		$event_time=$this->input->post('event_time');
		$category=$this->input->post('category');
		$category_id=implode(',',$category);
		$event_type="MasterEvents";
 
		
		$event_image="";$check=false;
			if($_FILES["event_image"]["tmp_name"]!="" ||  $_FILES["event_image"]["tmp_name"]!=NULL){
				$check = getimagesize($_FILES["event_image"]["tmp_name"]);}
 				if($check != false) {
					 $img_path = $_FILES["event_image"]["name"]; 
					$type = pathinfo($img_path, PATHINFO_EXTENSION);
					$img_data = @file_get_contents($_FILES["event_image"]["tmp_name"]); 
					$base64_code = base64_encode($img_data); 
					$event_image = 'data:image/' . $type . ';base64,' . $base64_code; 
				 }

				 

	   $data_array = array("update_type"=>"Edit","sk_event_id"=>$decrypt_EventId,'title'=>$title,'category_id'=>$category_id,'continent_id'=>$continent_id,'country_id'=>$country_id,'state_id'=>$state_id,'city_id'=>$city_id,'location_id'=>$location_id,'event_image'=>$event_image,'minimum_member'=>$minimum_member,'maximum_member'=>$maximum_member,'description'=>$description,'event_date'=>$event_date,'event_time'=>$event_time,'event_type'=>$event_type);
	


	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']); 
		
		   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/event/event_details", json_encode($data_array), $login_access_token_header);
	
		  $result = json_decode($makecall);
		  $status=$result->status;  
		  $message=$result->message; 
		  if($status==200)
		  { 
			  $this->session->set_flashdata('message',$message);
			  redirect(base_url()."events_view");
		   }   
   }
   else if($operation_type=="Activate")
   { 
	   $continent_name=$this->input->post('continent_name');
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
	   $data_array=array("update_type"=>"Activate","sk_event_id"=>$decrypt_EventId);
		
			$makecall = $this->common->callAPI('PUT', apiendpoint . "v1/event/event_details", json_encode($data_array), $login_access_token_header);
		  $result = json_decode($makecall);
		  $status=$result->status;  
		  $message=$result->message; 
		  if($status==200)
		  {  
			  $this->session->set_flashdata('message',$message);
			  redirect(base_url()."events_view");
		   }   
   }
   else if($operation_type=="InActivate")
   { 
	   $continent_name=$this->input->post('continent_name');
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
	   $data_array=array("update_type"=>"InActivate","sk_event_id"=>$decrypt_EventId);
		
		   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/event/event_details", json_encode($data_array), $login_access_token_header);
	
		  $result = json_decode($makecall);
		  $status=$result->status;  
		  $message=$result->message; 
		  if($status==200)
		  {  
			  $this->session->set_flashdata('message',$message);
			  redirect(base_url()."events_view");
		   }   
   }

}
/* ===================== Event ===================== */
	/* ===================== Users ===================== */
	 public function users_view()
	 {
		$data=$this->common_data();	 
		$data_array=array();
		$access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],'userId:All','userStatus:1','userType:user');
		$makecall = $this->common->callAPI('GET', apiendpoint.'v1/Auth/user_details', json_encode($data_array),$access_token_header);
		$result = json_decode($makecall);
		$status=$result->status;
		$message=$result->message;
		$output='';
			if($status==200)
			{
				if($result->data!="")
				{

					$i=1;
					foreach($result->data->user_details as $info)
					{

						$name=$info->name;
						$company_name=$info->company_name;
						$role=$info->role;
						$company_address=$info->company_address;
						$city=$info->city;
						$mobile=$info->mobile;
						$email=$info->email;
						$zipcode=$info->zipcode;
						
				
						$edit_url="";
						if($info->user_status==1){
							$edit_url1=base_url()."user-details/Edit/".base64_encode($info->userid);
							$inactivate_url=base_url()."user-details/InActivate/".base64_encode($info->userid);
							//$edit_url="<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
							$edit_url="<a href='$inactivate_url'>Reject</a>";
						}
						else {
							$activate_url=base_url()."user-details/Activate/".base64_encode($info->userid);
							//$edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
							$edit_url="<a href='$activate_url'>Approve</a>";
						}
						$output=$output."<tr>
						<td>$i</td>
						<td>$name</td>
						<td>$company_name</td>
						<td>$company_address</td>
						<td>$mobile</td>
						<td>$email</td>
						<td>$city</td>
						<td>$zipcode</td>
						<td>$role</td>
						<td>$edit_url</td>
						</tr>";
						$i++;
					}
					} 
					$data['continent_details']=$output;
					$this->load->view("admin/users/users-view",$data);
				}
	 }
	 
	 public function new_user()
	 {
		$data=$this->common_data();	 
		$data_array=array();
		$access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],'userId:All','userStatus:0','userType:user');
		$makecall = $this->common->callAPI('GET', apiendpoint.'v1/Auth/user_details', json_encode($data_array),$access_token_header);
		$result = json_decode($makecall);
		$status=$result->status;
		$message=$result->message;
		$output='';
			if($status==200)
			{
				if($result->data!="")
				{

					$i=1;
					foreach($result->data->user_details as $info)
					{

						$name=$info->name;
						$company_name=$info->company_name;
						$role=$info->role;
						$company_address=$info->company_address;
						$city=$info->city;
						$mobile=$info->mobile;
						$email=$info->email;
						$zipcode=$info->zipcode;
						
				
						$edit_url="";
						if($info->user_status==1){
							$edit_url1=base_url()."user-details/Edit/".base64_encode($info->userid);
							$inactivate_url=base_url()."user-details/InActivate/".base64_encode($info->userid);
							//$edit_url="<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
							$edit_url="<a href='$inactivate_url'>Reject</a>";
						}
						else {
							$activate_url=base_url()."user-details/Activate/".base64_encode($info->userid);
							//$edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
							$edit_url="<a href='$activate_url'>Approve</a>";
						}
						$output=$output."<tr>
						<td>$i</td>
						<td>$name</td>
						<td>$company_name</td>
						<td>$company_address</td>
						<td>$mobile</td>
						<td>$email</td>
						<td>$city</td>
						<td>$zipcode</td>
						<td>$role</td>
						<td>$edit_url</td>
						</tr>";
						$i++;
					}
					} 
					$data['continent_details']=$output;
					$this->load->view("admin/users/new-view",$data);
				}
	 }
	
	 public function user_deposits()
	 {
	     $data=$this->common_data();
	     $data_array=array();
	     $access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);//,'userId:All','userStatus:All','userType:user'
	     $makecall = $this->common->callAPI('GET', apiendpoint.'v1/Auth/user_deposits', json_encode($data_array),$access_token_header);
	     $result = json_decode($makecall);
	     $status=$result->status;
	     $message=$result->message;
	     $output='';
	     if($status==200)
	     {
	         if($result->data!="")
	         {
	             
	             $i=1;
	             foreach($result->data as $info)
	             {
	                 /* $name=$info->name; */
	                 $deposit_contanct_no=$info->deposit_contanct_no;
	                 $company_name=$info->company_name;
	                 $role=$info->role;
	                 $company_address=$info->company_address;
	                 $city=$info->city;
	                 $mobile=$info->mobile;
	                 $email=$info->email;
	                 $zipcode=$info->zipcode;
	                 
	                 
	                 /* $edit_url="";
	                 if($info->deposite_status==1){
	                     $edit_url1=base_url()."user-details/Edit/".base64_encode($info->userid);
	                     $inactivate_url=base_url()."user-details/InActivate/".base64_encode($info->userid);
	                     $edit_url="<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
	                 }
	                 else {
	                     $activate_url=base_url()."user-details/Activate/".base64_encode($info->userid);
	                     $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
	                 } */
	                 $output=$output."<tr>
						<td>$i</td>
                        <td>$deposit_contanct_no</td>
						<td>$company_name</td>
						<td>$company_address</td>
						<td>$mobile</td>
						<td>$email</td>
						<td>$city</td>
						<td>$zipcode</td>
						<td>$role</td>
						</tr>";
	                 $i++;
	             }
	         }
	         $data['deposit_details']=$output;
	         $this->load->view("admin/users/user-deposits",$data);
	     }
	 }

	 public function user_details()
	{
	   $data=$this->common_data();	 
	   $login_access_token_header=$data['login_access_token_header'];

		   $operation_type=$this->uri->segment(2);
		   $user_id=$this->uri->segment(3);
		   $decrypt_user_id=base64_decode($user_id);
	    if($operation_type=="Edit")
	   { 
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"userId:".$decrypt_user_id,"userStatus:1");
		      $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Auth/user_details", array(), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;   
	     if($status==200)
			  {
				  if($result->data!="")
				  {
					 // echo "Hi";
					  foreach($result->data as $info)
					  {
						  $data['name']=$info->name;
						  $data['company_name']=$info->company_name;
						  $data['company_address']=$info->company_address;
						  $data['city']=$info->city;
						  $data['role']=$info->role;
						  $data['mobile']=$info->mobile;
						  $data['email']=$info->email;
						  $data['zipcode']=$info->zipcode; 
						  $data['sk_user_id']=$info->sk_user_id;
						  //$data['password']=$info->password;

						  

					  }
				   }
			   }  
			   $this->load->view("admin/users/users-edit",$data);
	   }
	   else if($operation_type=="update")
	   { 
	    $username=$this->input->post('Username');
		$company_name=$this->input->post('company_name');	
		$company_address=$this->input->post('company_address');	
		$role=$this->input->post('role');	
		$city=$this->input->post('city');	
		$mobile=$this->input->post('mobile');	
		$email=$this->input->post('email');
		$zipcode=$this->input->post('zipcode');
		 $data_array = array(
					"name"=>$username,
					"sk_user_id"=>$decrypt_user_id,
					"company_name"=>$company_name,
					"role"=>$role,
					"company_address"=>$company_address,
					"city"=>$city,
					'email'=>$email,
					"mobile"=>$mobile,
					"zipcode"=>$zipcode,
					"update_type"=>"Edit");
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);			
		          $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Profile/profile_details", json_encode($data_array), $login_access_token_header);
			   $result = json_decode($makecall);
			   $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  { 
			   }
			   else{
				$this->session->set_flashdata('message',$message);
				redirect(base_url()."users-view"); 
			   }  
			   
	   }
	   else if($operation_type=="Activate")
	   {  
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Activate","sk_user_id"=>$decrypt_user_id);
			   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Profile/profile_details", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			   $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."users-view");
				}   
				else{
					$this->session->set_flashdata('message',$message);
					redirect(base_url()."users-view"); 
				   }  
	   }
	   else if($operation_type=="InActivate")
	   { // var_dump($data);
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"InActivate","sk_user_id"=>$decrypt_user_id);
		 //  var_dump($data_array);exit();

		      $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Profile/profile_details", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			   $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."users-view");
			   }  
			   else{
				$this->session->set_flashdata('message',$message);
				redirect(base_url()."users-view"); 
			   }   
	   }
}




	 
	/* ===================== Users ===================== */
	
		/*====================Category_type=============*/

		public function category_type()
		{
		   $data=$this->common_data();	 
   
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"category_id:All","category_type_status:1");
   
			$data['category_details']=$output="";
			
			 $makecall = $this->common->callAPI('GET', apiendpoint . "v1/settings/category_type_details", array(), $login_access_token_header);
				$category_id=$category_name=$category_image="";
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   if($status==200)
			   {
				   if($result->data!="")
				   {
					   $i=1;
					   foreach($result->data as $info)
					   {
						   $category_name=$info->category_type;
						  // $category_img=$info->category_image;
						   $category_id=$info->category_id;
						//    $category_image=apiendpoint."uploads/category/".$category_img;
						   $edit_url="";$inactive='';
						   if($info->category_type_status==1){
							   $edit_url1=base_url()."category-type-details/Edit/".base64_encode($category_id);
							   $inactivate_url=base_url()."category-type-details/InActivate/".base64_encode($category_id);
							   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
							   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
						   }
						   else {
							   $activate_url=base_url()."category-type-details/Activate/".base64_encode($category_id);
							   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
						   }
   
						   $output=$output."<tr>
						   <td>$i</td>
						   <td>$category_name</td>
						   <td>$edit_url</td>
						   </tr>";
						   $i++;
					   } 
				   }
			   }
			   $data['category_details']=$output;
		   $this->load->view("admin/settings/category_type",$data);
		}


		public function category_type_details()
		{
		   $data=$this->common_data();	 
		   $login_access_token_header=$data['login_access_token_header'];
   
			  $operation_type=$this->uri->segment(2);
			  $category_id=$this->uri->segment(3);
			  $decrypt_categoryId=base64_decode($category_id);
   
		   if($operation_type=="Add")
		   { 
				$category_name=$this->input->post('category_name');	
			   $data_array = array('category_type'=>$category_name);
		//	var_dump($data_array);exit();
			  $makecall = $this->common->callAPI('POST', apiendpoint . "v1/settings/category_type_details", json_encode($data_array), $login_access_token_header);
			   $result = json_decode($makecall);
			   $status=$result->status; 
			   $message=$result->message;
			   if($status==200)
			   {
				   if($result->data!=""){
					   $this->session->set_flashdata('message', 'Category Details Saved Successfully');
				   }else{
					   $this->session->set_flashdata('message', $message);
				   }	
						   
			   }else {$this->session->set_flashdata('message', $message);}
			   redirect(base_url()."category_type");
		   }
		   else if($operation_type=="Edit")
		   { 
			   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"category_id:".$decrypt_categoryId,"category_type_status:All");
			   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/settings/category_type_details", array(), $login_access_token_header);
			   $data['category_name']=$data['sk_category_id']="";
				  $result = json_decode($makecall);
				  $status=$result->status;  
				  if($status==200)
				  {
					  if($result->data!="")
					  {
						  foreach($result->data as $info)
						  {
							  $data['category_name']=$info->category_type;
							  $data['sk_category_id']=$info->category_id;
						  }
					   }
				   }  
				   $this->load->view("admin/settings/category_type_edit",$data);
		   }
		   else if($operation_type=="update")
		   { 
			   $category_name=$this->input->post('category_name');
			   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			   $data_array=array("update_type"=>"Edit","category_type"=>$category_name,"sk_category_id"=>$decrypt_categoryId);
				
				  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/settings/category_type_details", json_encode($data_array), $login_access_token_header);
				  $result = json_decode($makecall);
				  $status=$result->status;  
				  $message=$result->message; 
				  if($status==200)
				  { 
					  $this->session->set_flashdata('message',$message);
					  redirect(base_url()."category_type");
				   }   
		   }
		   else if($operation_type=="Activate")
		   {  
			   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			   $data_array=array("update_type"=>"Activate","sk_category_id"=>$decrypt_categoryId);
				
				 $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/settings/category_type_details", json_encode($data_array), $login_access_token_header);
				  $result = json_decode($makecall);
				  $status=$result->status;  
				  $message=$result->message; 
				  if($status==200)
				  {  
					  $this->session->set_flashdata('message',$message);
					 redirect(base_url()."category_type");
				   }   
		   }
		   else if($operation_type=="InActivate")
		   {  
			   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
			   $data_array=array("update_type"=>"InActivate","sk_category_id"=>$decrypt_categoryId);
				
			   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/settings/category_type_details", json_encode($data_array), $login_access_token_header);
				  $result = json_decode($makecall);
				  $status=$result->status;  
				  $message=$result->message; 
				  if($status==200)
				  {  
					  $this->session->set_flashdata('message',$message);
					 redirect(base_url()."category_type");
				   }   
		   }
	   
	   }

	/*====================Category_type=============*/
	/*====================Inventory*****************/
	public function inventory()
	{
	   $data=$this->common_data();	 

	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"inventory_id:All","inventory_status:1","view_type:Inventory");
		//var_dump($login_access_token_header);exit();
		$data['inventory_details']=$output="";
		
		   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Inventory/inventory_details", array(), $login_access_token_header);
			//$category_id=$category_name=$category_image="";
		    $result = json_decode($makecall);
		   $status=$result->status;  
		   if($status==200)
		   {
			   if($result->data->inventory_details!="")
			   {
				   $i=1;
				   foreach($result->data->inventory_details as $info)
				   {
					   $title=$info->title;
					    $category_id=$info->category_id;
					   $inventory_id=$info->inventory_id;
					   $inventory_image=$info->photo_video;
					   $available=$info->available;
					   $matuare_size=$info->matuare_size;

					 // var_dump($inventory_image);
					  
					 // $location_id=$info->location_id;
					  $location_name=$info->location_name;
					  $description=$info->description;
					  $zone=$info->zone;
					  $category_type=$info->category_type;
					  $inventory_date=$info->inventory_date;
					   $edit_url="";$active='';
					   if($info->inventory_status==1){
						   $edit_url1=base_url()."inventory-details/Edit/".base64_encode($inventory_id);
						   $tag_url=base_url()."price-details/tag/".base64_encode($inventory_id);
						   $inactivate_url=base_url()."inventory-details/InActivate/".base64_encode($inventory_id);
						   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
						   <a href='$tag_url'><i class='fa fa-eye'></i></a>|
						   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";					   }
					   else {
						   $activate_url=base_url()."inventory-details/Activate/".base64_encode($inventory_id);
						   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					   }

                    //$ext = pathinfo($filename, PATHINFO_EXTENSION);


					   foreach($inventory_image as $info){
					   	$ext = pathinfo($info, PATHINFO_EXTENSION);
                        //echo $ext; exit;
                        if($ext=='mp4'){
					   	 //$ext = pathinfo($info, PATHINFO_EXTENSION);
						   
						    $inventory="<video width='100' height='100' controls>
                                          <source src='$info' type='video/mp4'>
                                          </video>";
						}else{
							$inventory="<img src='$info' height='100' width='100'>";
							
						}
					   }
					   $zones= implode(",",$zone);
					   $output=$output."<tr>
					   <td>$i</td>
					   <td>$title</td>
					   <td>$category_type</td>
					   <td>$inventory</td>
                       <td>$matuare_size</td>
					   <td>$location_name</td>
					   <td>$description</td>
					   <td>$zones</td>
					   <td>$inventory_date</td>
					   <td>$edit_url</td>
					   </tr>";
					   $i++;
				   } 
			   }
		   }
		   $data['inventory_details']=$output;
	   $this->load->view("admin/inventory/inventory_view",$data);
	}

	public function inventoryAll()
	{
	   $data=$this->common_data();	
	  $type=$this->uri->segment(2);
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"inventory_id:All","inventory_status:1","view_type:Inventory");
		//var_dump($login_access_token_header);exit();
		$data['inventory_ddtails']='';
		
		    $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Inventory/inventory_details", array(), $login_access_token_header);
			//$category_id=$category_name=$category_image="";
		    $result = json_decode($makecall);
		   $status=$result->status;  
		   if($status==200)
		   {$output=$output1='';
			   if($result->data->inventory_details!="")
			   {
				   $i=1;
				   foreach($result->data->inventory_details as $info)
				   {
				   	$inventory1='';$inventory='';
					//    $title=$info->title;
					//     $category_id=$info->category_id;
					    $inventory_id=$info->inventory_id;
					    $inventory_image=$info->photo_video;
					//  // var_dump($inventory_image);
					  
					//   $location_id=$info->location_id;
					//   $location_name=$info->location_name;
					//   $description=$info->description;
					//   $zone=$info->zone;
					//   $category_type=$info->category_type;
					//   $inventory_date=$info->inventory_date;
					    
					foreach($inventory_image as $info){


							$ext = pathinfo($info, PATHINFO_EXTENSION);
                        //echo $ext; exit;
                        if($ext=='mp4'){
					   	 //$ext = pathinfo($info, PATHINFO_EXTENSION);
						   
						    $inventory1="<label class='custom-control-label ' for='$inventory_id'>
						    

                                         <video width='200' height='200'><source src='$info' type='video/mp4'></video>

                                          </label>";
						}else{
							$inventory="<label class='custom-control-label' for='$inventory_id'>  <img src=$info></label>";
							
						}
						
					if($type=='photo'){
					$inventories=$inventory_id.'_dev_'.$info;
					$output=$output."<div class='custom-control custom-radio col-md-4 mb-2'>
					<input type='radio' id='$inventory_id' value='$inventories' name='customRadio' class='custom-control-input'>$inventory</div>";
				}else if($type=="video"){
					//echo "video"; 
					$inventories=$inventory_id.'_dev_'.$info;
					$output1=$output1."<div class='custom-control custom-radio col-md-4 mb-2'>
					<input type='radio' id='$inventory_id' value='$inventories' name='customRadio' class='custom-control-input'>$inventory1</div>";

				   }
					}
					$i++;
					
				}
				}
				if($type=='photo'){
				echo $output;			
			}else if($type=='video'){
				echo $output1;

			}
			}
			
		}

	
	public function inventory_details()
	{
	   $data=$this->common_data();	 
	   $login_access_token_header=$data['login_access_token_header'];

		    $operation_type=$this->uri->segment(2);
		   $inventory_id=$this->uri->segment(3);
		   $decrypt_inventory_id=base64_decode($inventory_id);

	   if($operation_type=="Add")
	   { 
			$category_type=$this->input->post('category_type');	
			$title=$this->input->post('title');	
			 $mature_size=$this->input->post('mature_size');	
			$inventory=$this->input->post('inventory');
			$zone=$this->input->post('zone');
			$available=$this->input->post('available');

			$zone=explode(",",$zone);
			$location=$this->input->post('location');	
			$description=$this->input->post('description');	

			$inventory_date=$this->input->post('inventory_date');
			$count=0;
			 $count=count($_FILES["inventory_image"]["name"]);
			$inventory_image=$inventory_images=array();
			if($count!=0){
				for($i=0;$i<$count;$i++){
		   if($_FILES["inventory_image"]["name"][$i]!="" ||  $_FILES["inventory_image"]["name"][$i]!=NULL){
				
					 $img_path = $_FILES["inventory_image"]["name"][$i]; 
				    $type = pathinfo($img_path, PATHINFO_EXTENSION);
					if($type=="png" || $type=="jpg" || $type=="jpeg" || $type=="webp"){
						$detail_title="image";
					}
					else if($type=="mp4"){
						$detail_title='video';
					}				  
					  $img_data = @file_get_contents($_FILES["inventory_image"]["tmp_name"][$i]); 
				    $base64_code = base64_encode($img_data);
				   $inventory_image = 'data:'.$detail_title.'/' . $type . ';base64,' . $base64_code; 
			}
			$inventory_images[]=$inventory_image;
		}
		$data_array = array('category_type'=>$category_type,
		"title"=>$title,
		"matuare_size"=>$mature_size,
		"zone"=>$zone,
		"available"=>$available,
		"location_id"=>$location,
		"description"=>$description,
		"photo_video"=>$inventory_images,
		"inventory_date"=>$inventory_date,
		 "inventory"=>$inventory);
		}else{
			$data_array = array('category_type'=>$category_type,
			"title"=>$title,
			"matuare_size"=>$mature_size,
			"zone"=>$zone,
			"available"=>$available,
			"location_id"=>$location,
			"description"=>$description,
			"photo_video"=>$inventory_images,
			"inventory_date"=>$inventory_date,
			 "inventory"=>$inventory);
		}
		 

		   //var_dump($data_array); exit;
		   $makecall = $this->common->callAPI('POST', apiendpoint . "v1/Inventory/inventory_details", json_encode($data_array), $login_access_token_header);
		   $result = json_decode($makecall);
		   $status=$result->status; 
		   $message=$result->message;
		   if($status==200)
		   {
			   if($result->data!=""){
				   $this->session->set_flashdata('message', 'Inventory Details Saved Successfully');
			   }else{
				   $this->session->set_flashdata('message', $message);
			   }	
					   
		   }else {$this->session->set_flashdata('message', $message);}
		   redirect(base_url()."Inventory");
	   }
	   else if($operation_type=="Edit")
	   { 
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"inventory_id:".$decrypt_inventory_id,"inventory_status:All","view_type:Inventory");
		   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Inventory/inventory_details", array(), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $data['locationDetails']=$this->locationDetails("All",1);
			  $data['categoryDetails']=$this->category_type_Detail("All",1);  
			 // var_dump($data);exit();
			 if($status==true)
			 {
				  if($result->data->inventory_details!="")
				  {
					  foreach($result->data->inventory_details as $info)
					  {
						  $data['category_type']=$info->category_id;
						  $data['title']=$info->title;
						  $data['matuare_size']=$info->matuare_size;
						  $data['inventory_date']=date('m/d/Y', strtotime($info->inventory_date));
						    $data['location_name']=$info->location_name;
						  $data['available']=$info->available;
						  $data['description']=$info->description;
							$zones= implode(",",$info->zone);
							$data['zone']=$zones;
							 $data['image']=$info->photo_video;
							 $data['available']=$info->available;

							 
						  $data['sk_inventory_id']=$info->inventory_id;
						  $data['inventory']=$info->inventory;

					  }
				   }
			   }  
			   $this->load->view("admin/inventory/inventory_edit",$data);
	   }
	   else if($operation_type=="update")
	   { 
		$category_type=$this->input->post('category_type');	
		$title=$this->input->post('title');	
		$inventory=$this->input->post('inventory');	
		$mature_size=$this->input->post('mature_size');	
		$zone=$this->input->post('zone');	
		$available=$this->input->post('available');

		$zone=explode(",",$zone);
		 $location=$this->input->post('location');
		$description=$this->input->post('description');	
		 $inventory_date=$this->input->post('inventory_date');
			
		$inventory_image="";
		$check='false';

		$inventory_images=array();
		 $count=null;
		if(isset($_FILES["inventory_image"]["name"])){
			 $count=count($_FILES["inventory_image"]["name"]);
			
			$inventory_images=null;
			if($count!=0){
				for($i=0;$i<$count;$i++){
		   if($_FILES["inventory_image"]["name"][$i]!="" ||  $_FILES["inventory_image"]["name"][$i]!=NULL){
				
					 $img_path = $_FILES["inventory_image"]["name"][$i]; 
				    $type = pathinfo($img_path, PATHINFO_EXTENSION);
					if($type=="png" || $type=="jpg" || $type=="jpeg" || $type=="webp"){
						$detail_title="image";
					}
					else if($type=="mp4"){
						$detail_title='video';
					}				  
					  $img_data = @file_get_contents($_FILES["inventory_image"]["tmp_name"][$i]); 
				    $base64_code = base64_encode($img_data);
				   $inventory_image = 'data:'.$detail_title.'/' . $type . ';base64,' . $base64_code; 
			}
			$inventory_images[]=$inventory_image;
		}
	}
		$data_array = array(
			"photo_video"=>$inventory_images,
			"sk_inventory_id"=>$decrypt_inventory_id,
			"category_type"=>$category_type,
			"title"=>$title,
			"matuare_size"=>$mature_size,
			"zone"=>$zone,
			"available"=>$available,
			"location_id"=>$location,
			"description"=>$description,
			"inventory_date"=>$inventory_date,
			"inventory"=>$inventory,
			"update_type"=>"Edit");
	}

	
	   else{
		$data_array = array(
			"photo_video"=>array(),
			"sk_inventory_id"=>$decrypt_inventory_id,
			"category_type"=>$category_type,
			"title"=>$title,
			"matuare_size"=>$mature_size,
			"zone"=>$zone,
			"available"=>$available,
			"location_id"=>$location,
			"description"=>$description,
			"inventory_date"=>$inventory_date,
			"inventory"=>$inventory,
			"update_type"=>"Edit");
	   }

		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);			
		            $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Inventory/inventory_details", json_encode($data_array), $login_access_token_header);
			   $result = json_decode($makecall);
			   $status=$result->status;  
			  $message=$result->message; 
			  if($status==true)
			  { 
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."inventory");
			   }   
	   }
	   else if($operation_type=="Activate")
	   {  
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Activate","sk_inventory_id"=>$decrypt_inventory_id);
			  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Inventory/inventory_details", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==true)
			  {  
				  $this->session->set_flashdata('message',$message);
				 redirect(base_url()."inventory");
			   }   
	   }
	   else if($operation_type=="InActivate")
	   { // var_dump($data);
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"InActivate","sk_inventory_id"=>$decrypt_inventory_id);
		 //  var_dump($data_array);exit();

		   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Inventory/inventory_details", json_encode($data_array), $login_access_token_header); 
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==true)
			  {  
				  $this->session->set_flashdata('message',$message);
				 redirect(base_url()."inventory");
			   }   
	   }
}
	public function add_inventory()
	{
			$data=$this->common_data();	 
			//$data['continentDetails']=$this->continentDetails("All",1);
			$data['locationDetails']=$this->locationDetails("All",1);
			$data['categoryDetails']=$this->category_type_Detail("All",1);  
			$this->load->view("admin/inventory/inventory_add",$data);
	}
	function category_type_Detail($category_id,$category_status)
	{
		$data=$this->common_data();	 
		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"category_id:".$category_id,"category_type_status:".$category_status);

		 $data['categoryDetails']=$categoryDetails="";
		 
		  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Settings/category_type_details", array(), $login_access_token_header);
 
			$result = json_decode($makecall);
			$status=$result->status;  
			if($status==200)
			{
				if($result->data!="")
				{
					 $categoryDetails=$result->data;
				}
			}
					return $data['categoryDetails']=$categoryDetails ;
}
/******************************************price and availability******************************/


	public function price_details()
	{
		   $data=$this->common_data();	 
		 	 $id= $this->uri->segment(3);
			 $inventory_id= base64_decode($id);
   
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"inventory_id:$inventory_id","price_status:All","view_type:Inventory");
   
			$data['price_details']=$output="";
			
			 $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Inventory/price_availability", array(), $login_access_token_header);
				$sk_inventory_price_id=$callper=$qty=$price=$price_status='';
			   $result = json_decode($makecall);
			   $status=$result->status;  
			   if($status==200)
			   {
				   if($result->data!="")
				   {
					   $i=1;
					   foreach($result->data as $info)
					   {
						   $callper=$info->callper;
						   $qty=$info->qty;
						   $sk_inventory_price_id=$info->sk_inventory_price_id;
						   $inventoryName=$info->inventory_name;
						   $inventory_id=$info->inventory_id;
						   $price=$info->price;
						   $edit_url="";
						   if($info->price_status==1){
							   $edit_url1=base_url()."inventory-price-details/Edit/".base64_encode($sk_inventory_price_id);
							   $inactivate_url=base_url()."inventory-price-details/InActivate/".base64_encode($sk_inventory_price_id);
							   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
							   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
						   }
						   else {
							   $activate_url=base_url()."inventory-price-details/Activate/".base64_encode($sk_inventory_price_id);
							   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
						   }
   
						   $output=$output."<tr>
						   <td>$i</td>
						   <td>$callper</td>
						   <td>$inventoryName</td>
						   <td>$price</td>
						   <td>$qty</td>
						   <td>$edit_url</td>
						   </tr>";
						   $i++;
					   } 
				   }
			   }
			   $data['inventory_id']=$inventory_id;
			  //var_dump($data);exit();
			   $data['price_details']=$output;
		   $this->load->view("admin/inventory/price_view",$data);
	}
	public function inventory_price_details()
	{
	   $data=$this->common_data();	 
	   $login_access_token_header=$data['login_access_token_header'];

		   $operation_type=$this->uri->segment(2);
		  $inventory_id=$this->uri->segment(3);
		  $decrypt_inventory_id=base64_decode($inventory_id);

	   if($operation_type=="Add")
	   { 
			$callper=$this->input->post('callper');	
			$price=$this->input->post('price');	
			$quantity=$this->input->post('quantity');	
			$inventory_id=$decrypt_inventory_id;
		   $data_array = array('callper'=>$callper,
							   "price"=>$price,
							   "qty"=>$quantity,
							"inventory_id"=>$inventory_id);
		   $makecall = $this->common->callAPI('POST', apiendpoint . "v1/Inventory/price_availability", json_encode($data_array), $login_access_token_header);
		   $result = json_decode($makecall);
		   $status=$result->status; 
		   $message=$result->message;
		   if($status==200)
		   {
			   if($result->data!=""){
				   $this->session->set_flashdata('message', 'Inventory Details Saved Successfully');
			   }else{
				   $this->session->set_flashdata('message', $message);
			   }	
					   
		   }else {$this->session->set_flashdata('message', $message);}
		   redirect(base_url()."price-details/tag/".base64_encode($inventory_id));
	   }
	   else if($operation_type=="Edit")
	   { 
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"priceId:".$decrypt_inventory_id,"price_status:All","view_type:Price");
		    $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Inventory/price_availability", array(), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $data['locationDetails']=$this->locationDetails("All",1);
			  $data['categoryDetails']=$this->category_type_Detail("All",1);  
			 // var_dump($data);exit();
	     if($status==200)
			  {
				  if($result->data!="")
				  {
					  foreach($result->data as $info)
					  {
						  $data['sk_inventory_price_id']=$info->sk_inventory_price_id;
						  $data['callper']=$info->callper;
						  $data['qty']=$info->qty;
						  $data['price']=$info->price;
						  $data['price_status']=$info->price_status;
						  $data['inventory_id']=$info->inventory_id;
					  }
				   }
			   }  
			   $this->load->view("admin/inventory/price_edit",$data);
	   }
	   else if($operation_type=="update")
	   { 
		
		$callper=$this->input->post('callper');	
			$price=$this->input->post('price');	
			$quantity=$this->input->post('quantity');	
			$inventory_id=$this->input->post('inventory_id');
			$sk_inventory_price_id=$decrypt_inventory_id;
		   $data_array = array('callper'=>$callper,
		   						'inventory_id'=>$inventory_id,
							   "price"=>$price,
							   "qty"=>$quantity,
							"sk_inventory_price_id"=>$sk_inventory_price_id,
						'update_type'=>"Edit");
		   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Inventory/price_availability", json_encode($data_array), $login_access_token_header);
		   $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  { 
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."price-details/tag/".base64_encode($inventory_id));
				}   
	   }
	   else if($operation_type=="Activate")
	   {  
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Activate","sk_inventory_price_id"=>$decrypt_inventory_id);
			  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Inventory/price_availability", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  $inventory_id=$result->data->inventory_id;
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."price-details/tag/".base64_encode($inventory_id));
			   }   
	   }
	   else if($operation_type=="InActivate")
	   { // var_dump($data);
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"InActivate","sk_inventory_price_id"=>$decrypt_inventory_id);
		 //  var_dump($data_array);exit();
		 // $inventory_id;
		      $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Inventory/price_availability", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  $inventory_id=$result->data->inventory_id;
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."price-details/tag/".base64_encode($inventory_id));
			   }   
	   }
}

public function partner_view()
{
	   $data=$this->common_data();	
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"partners_status:1","partners_id:All");

		$data['partner_details']=$output="";
		
		   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Partner/partner_details", array(), $login_access_token_header);
			$sk_inventory_price_id=$callper=$qty=$price=$price_status='';
		   $result = json_decode($makecall);
		   $status=$result->status;  
		   if($status==200)
		   {
			   if($result->data!="")
			   {
				   $i=1;
				   foreach($result->data->partner_details as $info)
				   {
					   $partner_name=$info->partner_name;
					   $phone_number=$info->phone_number;
					   $website=$info->website;
					   $address=$info->address;
					   $about=$info->about;
					   $services=$info->services;
					   $partner_image=$info->partner_image;
					   $edit_url="";
					   if($info->partner_status==1){
						   $edit_url1=base_url()."partners-details/Edit/".base64_encode($info->sk_partners_id);
						   $inactivate_url=base_url()."partners-details/InActivate/".base64_encode($info->sk_partners_id);
						   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
						   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";

					   }
					   else {
						   $activate_url=base_url()."partners-details/Activate/".base64_encode($info->sk_partners_id);
						   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					   }
					   $image="<img src=$partner_image height='100' width='100'>";
					   $output=$output."<tr>
					   <td>$i</td>
					   <td>$partner_name</td>
					   <td>$phone_number</td>
					   <td>$website</td>
					   <td>$address</td>
					   <td>$image</td>
					   <td>$services</td>
					   <td>$about</td>
					   <td>$edit_url</td>
					   </tr>";
					   $i++;
				   } 
			   }
		   }
		   $data['partner_details']=$output;
	   $this->load->view("admin/partner/partner-view",$data);
}
public function partners_details()
{

   $data=$this->common_data();	 
  // var_dump($data);
   $login_access_token_header=$data['login_access_token_header'];

	 $operation_type=$this->uri->segment(2);
	  $partner_id=$this->uri->segment(3);
	  $decrypt_partner_id=base64_decode($partner_id);

   if($operation_type=="Add")
   { 
		$partner_name=$this->input->post('partner_name');	
		$address=$this->input->post('address');	
		$website=$this->input->post('website');
		$phone_number=$this->input->post('phone_number');	
		 $about=$this->input->post('about');
		$services=$this->input->post('services');	
		$partner_image="";
			if($_FILES["partner_image"]["tmp_name"]!="" ||  $_FILES["partner_image"]["tmp_name"]!=NULL){
					 $img_path = $_FILES["partner_image"]["name"]; 
					$type = pathinfo($img_path, PATHINFO_EXTENSION);

					$img_data = @file_get_contents($_FILES["partner_image"]["tmp_name"]); 
					$base64_code = base64_encode($img_data); 
					$partner_image = 'data:image/' . $type . ';base64,' . $base64_code; 
				 }
	   $data_array = array("partner_name"=>$partner_name,
						   "address"=>$address,
						   "website"=>$website,
						   "phone_number"=>$phone_number,
							"about"=>$about,
						"services"=>$services,
					"partner_image"=>$partner_image);
	    $makecall = $this->common->callAPI('POST', apiendpoint . "v1/Partner/partner_details", json_encode($data_array), $login_access_token_header);
	   $result = json_decode($makecall);
	   $status=$result->status; 
	   $message=$result->message;
	   if($status==200)
	   {
		   if($result->data!=""){
			   $this->session->set_flashdata('message', 'Inventory Details Saved Successfully');
		   }else{
			   $this->session->set_flashdata('message', $message);
		   }	
				   
	   }else {$this->session->set_flashdata('message', $message);}
	   redirect(base_url().'partner-view');
   }
   else if($operation_type=="Edit")
   { 

	  // echo $decrypt_partner_id;
	    $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"partners_id:".$decrypt_partner_id,"partners_status:1");
		 $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Partner/partner_details", array(), $login_access_token_header);
		  $result = json_decode($makecall);
		  $status=$result->status;   
	 if($status==200)
		  {
			  if($result->data->partner_details!="")
			  {
				  foreach($result->data->partner_details as $info)
				  {
					  $data['partner_name']=$info->partner_name;
					  $data['phone_number']=$info->phone_number;
					  $data['website']=$info->website;
					  $data['address']=$info->address;
					  $data['services']=$info->services;
					  $data['about']=$info->about;
					  $data['sk_partners_id']=$info->sk_partners_id;
					  $data['partner_image']=$info->partner_image;
					 // $data['partner_status']=$info->partner_status;

				  }
			   }
		   }  
		   $this->load->view("admin/partner/edit-partner",$data);
   }
   else if($operation_type=="update")
   { 
	
	$partner_name=$this->input->post('partner_name');	
		$address=$this->input->post('address');	
		$website=$this->input->post('website');
		$phone_number=$this->input->post('phone_number');	
		 $about=$this->input->post('about');
		$services=$this->input->post('services');	
		$partner_image="";
			if($_FILES["partner_image"]["tmp_name"]!="" ||  $_FILES["partner_image"]["tmp_name"]!=NULL){
					 $img_path = $_FILES["partner_image"]["name"]; 
					$type = pathinfo($img_path, PATHINFO_EXTENSION);

					$img_data = @file_get_contents($_FILES["partner_image"]["tmp_name"]); 
					$base64_code = base64_encode($img_data); 
					$partner_image = 'data:image/' . $type . ';base64,' . $base64_code; 
				 }
	   $data_array = array("sk_partners_id"=>$decrypt_partner_id,
	  						 "partner_name"=>$partner_name,
						   "address"=>$address,
						   "website"=>$website,
						   "phone_number"=>$phone_number,
							"about"=>$about,
						"services"=>$services,
					"partner_image"=>$partner_image,
				"update_type"=>'Edit');
	     $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Partner/partner_details", json_encode($data_array), $login_access_token_header);
	   $result = json_decode($makecall);
	   $status=$result->status; 
	   $message=$result->message;
	   if($status==200)
	   {
		   if($result->data!=""){
			   $this->session->set_flashdata('message', 'Inventory Details Saved Successfully');
		   }else{
			   $this->session->set_flashdata('message', $message);
		   }	
				   
	   }else {$this->session->set_flashdata('message', $message);}
	   redirect(base_url().'partner-view');
	}
   else if($operation_type=="Activate")
   {  
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
	   $data_array=array("update_type"=>"Activate","sk_partners_id"=>$decrypt_partner_id);
		 echo  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Partner/partner_details", json_encode($data_array), $login_access_token_header);
		  $result = json_decode($makecall);
		  $status=$result->status;  
		  $message=$result->message; 
		  if($status==200)
		  {  
			  $this->session->set_flashdata('message',$message);
			  redirect(base_url()."partner-view/");
		   }   
   }
   else if($operation_type=="InActivate")
   { // var_dump($data);
	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
	   $data_array=array("update_type"=>"InActivate","sk_partners_id"=>$decrypt_partner_id);
	 //  var_dump($data_array);exit();
	 // $inventory_id;
	   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Partner/partner_details", json_encode($data_array), $login_access_token_header);
	 $result = json_decode($makecall);
		  $status=$result->status;  
		  $message=$result->message; 
		  if($status==200)
		  {  
			  $this->session->set_flashdata('message',$message);
			  redirect(base_url()."partner-view/");
		   }   
   }
}
public function add_partner()
	{
			$data=$this->common_data();	
			$this->load->view("admin/partner/add-partners",$data);
	}
public function chat()
	{
		$data=$this->common_data();
		 if($this->session->userdata("admin_session_token")=="" || $this->session->userdata("admin_session_token")==null){redirect(base_url());}

		$header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],'userId:All','userStatus:All','userType:user');
  
 		 $makecall = $this->common->callAPI('GET', apiendpoint . "v1/auth/user_details", array(), $header);
		  $status="";
	   $result = json_decode($makecall);
	   $status=$result->status;  
	   $data['ChatUsers']="";
		if($status==true)
		{
			if($result->data->user_details!="")
			{				  
				 $data['ChatUsers']=$result->data->user_details;
			}
	   }	    
	   $unique_request_id= $data['ChatDetails']="";
		if($data['ChatUsers'])
		{
			foreach($data['ChatUsers'] as $chat_info){
				 $unique_request_id=$chat_info->userid;
			}
		}
		$user_id=$data['admin_session_id'];
		// 	if($unique_request_id!="")
		// {
		// 		$firebase = $this->firebase->init();
		// 		$db = $firebase->getDatabase();
		// 		$firebase = $this->firebase->init();
		// 		$reference = $db->getReference("USERS/Chats/$unique_request_id/$user_id");
		// 		$snapshot = $reference->getSnapshot();
		
		// 		$value = $snapshot->getValue();
		// 		$data['ChatDetails']=$value;
				
		// 		}
				$this->load->view('admin/chat/newchat',$data);
	}




	// function utctime($date,$time){
	// //	date_default_timezone_set("Asia/Kolkata");     
	// 	$datetime = $date.' '.$time;
	// 	$event_date=date('Y-m-d H:i:s', strtotime($datetime));
	// 	  $datetime = gmdate('Y-m-d\TH:i:s.000', strtotime($event_date)).'Z';
	// 	  $datetime1='"'.$datetime.'"';
	// 	  return $datetime1;
	//   }
	
function chat_action()
{
	$data=$this->common_data();
	$post_date=$data["post_date"];
	$post_time=$data["post_time"]; 
	$user_id=$data['admin_session_id']; 
	if($this->session->userdata("admin_session_token")=="" || $this->session->userdata("admin_session_token")==null){redirect(base_url());}
	$action=$this->input->post('action');
	$inventory_id='';$image_path='';
	$unique_request_id=$this->input->post('to_user_id');
	$user_detailsName=$this->CommonModel->getRecords(array('sk_user_id'=>$unique_request_id),'mst_user');
	$name='';
if($user_detailsName!=false){
	foreach($user_detailsName as $info){
		$fullname=$info->name;
	}
}
	$name=substr($fullname, 0, 1);
	if($action=="insert_chat")
	{
		if (!file_exists("uploads/gallery/")) {
			mkdir("uploads/gallery/", 0777, true);
		}           
		 $upload_folder = "uploads/gallery/";
		
		 $inventory_id=$this->input->post('inventory_id');
		 $imageUrl=$this->input->post('imageUrl');
		if($imageUrl==''){
	     $imageUrl=$this->input->post('inventory_image_path');
		}else{
			
			//$count=count($_FILES["imageUrl"]["name"]);
			
			//$inventory_image="";
		   
	
			  /*****for first documement**********/
			  $image_parts = explode(";base64,", $imageUrl);
			$image_type_aux = explode("/", $image_parts[0]);
			  $image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$admin_url=base_url();
			$imageUrl=uniqid().'.'.$image_type;
			$event_image_name_with_path = $upload_folder . $imageUrl;
			file_put_contents($event_image_name_with_path, $image_base64);
		}
		$videoUrl=$this->input->post('videoUrl');

		if($videoUrl!=''){
		$image_parts = explode(";base64,", $videoUrl);
		$image_type_aux = explode("/", $image_parts[0]);
		  $image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);
		$admin_url=base_url();
		$videoUrl=uniqid().'.'.$image_type;
		$event_image_name_with_path = $upload_folder . $videoUrl;
		file_put_contents($event_image_name_with_path, $image_base64);
		}
        $deviceId=$this->input->post('device_id');
	    $chat_message=$this->input->post('chat_message');	
		// $firebase = $this->firebase->init();
		// $db = $firebase->getDatabase();

		// $date = date_create();
		// $timeStamp = round(microtime(true) * 1000); 
		// $db->getReference("USERS/Chats/$unique_request_id/$user_id")
		// ->push([
			//$created_date=date()
			  $datetime=$this->utctime( date('Y-m-d'),date('H:i:s'));
			// $datetime=explode('T',$datetime);
			// $time44=explode('.',$datetime[1]);
			//echo $datetime[1];
			$data_array=array(
			'inventory_id'=>"$inventory_id",
			'imageUrl' => "$imageUrl",
			'message' => "$chat_message",
			//'created_date' => $datetime,
			'created_time' => $datetime,
			'user1'=>$user_id,
			'user2' => "$unique_request_id",
			'videoUrl' => "$videoUrl"
			);
		//	var_dump($datetime);
			$this->CommonModel->save($data_array,'mst_chat');
		
						$res = array();
						$res['data']['status']=$user_id;
								$notification = [
									'title' => $data['admin_session_name']." has sent you a message",
									'body' => $chat_message,
									'admin_id' => $user_id, 
									'sound' => 'default'
								];
								$fields = array(
									'to' => $deviceId,
									'notification' => $notification,
									'data' => $res,

								);			
						$this->sendPushNotification($fields); 
						$chat_list=$this->CommonModel->getRecords(array(),'mst_chat');
		$conversation="";
		if($chat_list!=false){

			foreach($chat_list as $user_info)
			{
		$file_icon="";
		$msg=$user_info->message;
		$imageUrl=$user_info->imageUrl;
		 $videoUrl=$user_info->videoUrl;
		$senderUserProfileImage="";
		// $seconds = ceil($user_info['timestamp'] / 1000); 
	// $user_info->created_time;
	 //$user_info->created_time;
	 $dt = new DateTime($user_info->created_time);
	 $tz = new DateTimeZone($this->session->userdata('time_zone')); // or whatever zone you're after
	 $dt->setTimezone($tz);
	 $v = explode(" ",$dt->format('Y-m-d H:i'));
 //	var_dump($v);
	  $chat_date =date('Y-m-d',strtotime($v[0])); 
	  $chat_time = date('h:i A',strtotime($v[1]));    
		//echo $user_info->admin_id==$user_id;
			if($user_info->user1==$user_id && $user_info->user2==$unique_request_id) {   
				             
				 if($msg!=""){
					$outdata="<p class='msg-text'>$msg</p>
					</div>
					<div class='ml-5 pl-4'>$file_icon</div>
					<p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";
				 }
				 else{
				 	$ext = pathinfo($imageUrl, PATHINFO_EXTENSION);
				 	if($videoUrl!=''){
						 $videoUrl=base_url().'uploads/gallery/'.$videoUrl;
						 $outdata="<a data-fancybox href='$videoUrl'><video width='100' height='100' controls><source src='$videoUrl' type='video/mp4'></video></a>

					</div>
					<div class='ml-5 pl-4'>$file_icon</div>
					<p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";
				}
				else if($ext=='mp4'){
					$outdata="<a data-fancybox href='$imageUrl'><video width='100' height='100' controls><source src='$videoUrl' type='video/mp4'></video></a>

			  </div>
			  <div class='ml-5 pl-4'>$file_icon</div>
			  <p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";
				}
				else{
					if($user_info->inventory_id!=''){
						$outdata="<a data-fancybox href='$imageUrl'><img src='$imageUrl' width='100' height='100' class='ml-4'></a>
					</div>
					<div class='ml-5 pl-4'>$file_icon</div>
					<p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";

					}else{
						$imageUrl=base_url().'uploads/gallery/'.$imageUrl;
						$outdata="<a data-fancybox href='$imageUrl'><img src='$imageUrl' width='100' height='100' class='ml-4'></a>
					</div>
					<div class='ml-5 pl-4'>$file_icon</div>
					<p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";
					}
				}
				}
				$conversation=$conversation."<div class='me'>
				  <div class='d-flex justify-content-end'>
					$outdata
				</div>";
				 } else
				 if($user_info->user1==$unique_request_id && $user_info->user2==$user_id) {

					$conversation=$conversation."<div class='sender'>
					<div class='d-flex justify-content-end'>
					  <p class='msg-text'>$msg</p>
					  </div>
					<div>$file_icon</div>
					<p class='date--time mt-2'>$chat_date, $chat_time</p>
				  </div>";
				} 
			}
		}


			  $data = array(
				"conversation" => $conversation/* ,
				"userSection" => $userSection,  */		
			 );
	 
	 
			  echo json_encode($data);	   
	
		//}

	}
	else if($action=="show_chat")
	{
		// $firebase = $this->firebase->init();
		// $db = $firebase->getDatabase();
		// $firebase = $this->firebase->init();
		// $reference = $db->getReference("USERS/Chats/$unique_request_id/$user_id");
		// $snapshot = $reference->getSnapshot();

		// $value = $snapshot->getValue();
		 $conversation="";
		
		//var_dump($value);exit();
		$chat_list=$this->CommonModel->getRecords(array(),'mst_chat');
		$conversation="";
		if($chat_list!=false){

			foreach($chat_list as $user_info)
			{
		$file_icon="";
		$msg=$user_info->message;
		$imageUrl=$user_info->imageUrl;
		$videoUrl=$user_info->videoUrl;
		$senderUserProfileImage="";
		// $seconds = ceil($user_info['timestamp'] / 1000); 
		$dt = new DateTime($user_info->created_time);
		$tz = new DateTimeZone($this->session->userdata('time_zone')); // or whatever zone you're after
		$dt->setTimezone($tz);
		$v = explode(" ",$dt->format('y-m-d H:i'));
	//	var_dump($v);
	$chat_date =date('Y-m-d',strtotime($v[0])); 
	$chat_time = date('h:i A',strtotime($v[1]));  
		//echo $user_info->admin_id==$user_id;
			if($user_info->user1==$user_id && $user_info->user2==$unique_request_id) {   
				             
				 if($msg!=""){
					$outdata="<p class='msg-text'>$msg</p>
					</div>
					<div class='ml-5 pl-4'>$file_icon</div>
					<p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";
				 }
				 else{
				 	$ext = pathinfo($imageUrl, PATHINFO_EXTENSION);
				 	if($videoUrl!=''){
						$videoUrl=base_url().'uploads/gallery/'.$videoUrl;
					$outdata="<a data-fancybox href='$videoUrl'><video width='100' height='100' controls><source src='$videoUrl' type='video/mp4'></video></a>
				 		
					</div>
					<div class='ml-5 pl-4'>$file_icon</div>
					<p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";
				}
				else if($ext=='mp4'){
					$outdata="<a data-fancybox href='$imageUrl'><video width='100' height='100' controls><source src='$videoUrl' type='video/mp4'></video></a>

			  </div>
			  <div class='ml-5 pl-4'>$file_icon</div>
			  <p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";
				}
				else{
					if($user_info->inventory_id!=''){
						//$outdata="<img src='$imageUrl' width='100' height='100' class='ml-4'>
						$outdata="<a data-fancybox href='$imageUrl'><img src='$imageUrl' width='100' height='100' class='ml-4'></a>
						</div>
						<div class='ml-5 pl-4'>$file_icon</div>
						<p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";
	
						}else{
							$imageUrl=base_url().'uploads/gallery/'.$imageUrl;
							$outdata="<a data-fancybox href='$imageUrl'><img src='$imageUrl' width='100' height='100' class='ml-4'></a>
						</div>
						<div class='ml-5 pl-4'>$file_icon</div>
						<p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>";
						}
					
				 
				}
				}
				$conversation=$conversation."<div class='me'>
				  <div class='d-flex justify-content-end'>
					$outdata
				</div>";
				 } else
				 if($user_info->user1==$unique_request_id && $user_info->user2==$user_id) {

					$conversation=$conversation."<div class='sender'>
					<div class='d-flex justify-content-end'>
					  <p class='msg-text'>$msg</p>
					  </div>
					<div>$file_icon</div>
					<p class='date--time mt-2'>$chat_date, $chat_time</p>
				  </div>";
				} 
			}
		}


			  $data = array(
				"conversation" => $conversation/* ,
				"userSection" => $userSection,  */		
			 );
	 
			  echo json_encode($data);
		
	}
	else if($action=="update_user_chat"){
		//echo $recieverId;exit();
		$firebase = $this->firebase->init();
		$db = $firebase->getDatabase();
		$firebase = $this->firebase->init();
		$reference = $db->getReference("USERS/Chats/$unique_request_id/$user_id");
		$snapshot = $reference->getSnapshot();

		$value = $snapshot->getValue();
		$conversation="";
	//	var_dump($value);
		if(!empty($value)){

			foreach ($value as $key => $user_info)
			{
			//	var_dump($val);
		$file_icon="";
		$msg=$user_info['message'];
		$senderUserProfileImage="";
		/* $chat_time=$user_info['timestamp'];
		$chat_date=$user_info['timestamp']; */
		$seconds = ceil($user_info['timestamp'] / 1000); 
		$chat_date =date("d M", $seconds); 
		$chat_time = date('h:i a', $seconds); 

			if($user_info['userid']==$user_id) {                
						 
				$conversation=$conversation."<div class='sender'>
				  <div class='d-flex justify-content-end'>
					<div class='flex--end'><p class='chat-bg-text red mr-0 msg-text-person'>$name</p></div>
					<p class='msg-text'>$msg</p>
				  </div>
				  <div class='ml-5 pl-4'>$file_icon</div>
				  <p class='date--time mt-2 text-right'>$chat_date, $chat_time</p>
				</div>";
				 } else {
					$conversation=$conversation."<div class='me'>
				  <div class='d-flex justify-content-end'>
					<p class='msg-text'>$msg</p>
					<!-- <div class='flex--end'><img class='profile--pic' src='$senderUserProfileImage'></div> -->
				  </div>
				  <div>$file_icon</div>
				  <p class='date--time mt-2'>$chat_date, $chat_time</p>
				</div>";
				  }  
			}
		}



		
			  $data = array(
				"conversation" => $conversation/* ,
				"userSection" => $userSection,  */		
			 );
	 
			  echo json_encode($data); 

	}

}


function utctime($date,$time){
   // date_default_timezone_set("Asia/Kolkata");     
    $datetime = $date.' '.$time;
    $event_date=date('Y-m-d H:i:s', strtotime($datetime));
      $datetime = gmdate('Y-m-d\TH:i:s.000', strtotime($event_date)).'Z';
     
      return $datetime;
  }
		private function sendPushNotification($fields) {
 
			$url = 'https://fcm.googleapis.com/fcm/send';
			$headers = array(
					'Authorization: key=' . FIREBASE_API_KEY,
					'Content-Type: application/json'
			);
			// Open connection
			$ch = curl_init();
		 
			// Set the url, number of POST vars, POST data
			curl_setopt($ch, CURLOPT_URL, $url);
		 
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 
			// Disabling SSL Certificate support temporarly
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		 
			// Execute post
			$result = curl_exec($ch);
			if ($result === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}
			// Close connection
			curl_close($ch);
		}


		public function notifications()
	{
	   $data=$this->common_data();	 

	   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"notification_id:All","notification_status:All");
		//var_dump($login_access_token_header);exit();
		$data['notifications']=$output="";
		  $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Notifications/notifications", array(), $login_access_token_header);
			//$category_id=$category_name=$category_image="";
			 $result = json_decode($makecall);
		 $status=$result->status;  
		   if($status==200)
		   {
			   if($result->data->notification_details!="")
			   {
				   $i=1; 
				   foreach($result->data->notification_details as $info)
				   {
					   $notifications_title=$info->notification_title;
					   $sk_notifications_id=$info->notification_id;
					   $user_id=$info->user_id;
					   $notifications_status=$info->notifications_status;
					   $edit_url="";
					   if($info->notifications_status==1){
	// $edit_url1=base_url()."notification-details/Edit/".base64_encode($sk_notifications_id);
						   $inactivate_url=base_url()."notification-details/InActivate/".base64_encode($sk_notifications_id);
						   $edit_url="<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
					   }
					   else {
						   $activate_url=base_url()."notification-details/Activate/".base64_encode($sk_notifications_id);
						   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
					   }
					    
					   $access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],'userId:'.$user_id,'userStatus:1','userType:user');
					   $makecall = $this->common->callAPI('GET', apiendpoint.'v1/Auth/userDetails', array(),$access_token_header);
					   $result = json_decode($makecall);
					   $status=$result->status;  
					   if($status==200)
					   {
						   if($result->data->user_details!="")
						   {
							   //$i=1;
							   foreach($result->data->user_details as $info)
							   {
								   $user_name=ltrim($info->name,',');
							   }
							}
						}
					
					   $output=$output."<tr>
					   <td>$i</td>
					   <td>$notifications_title</td>
					   <td>$user_name</td>
					   <td>$edit_url</td>
					   </tr>";
					   $i++;
				   } 
			   }
		   }
		   $data['notifications']=$output;
	   $this->load->view("admin/notifications/notification-view",$data);
	}


	public function add_notifications()
	{
			$data=$this->common_data();
			$data_array=array();
			$access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],'userId:All','userStatus:1','userType:user');
			$makecall = $this->common->callAPI('GET', apiendpoint.'v1/Auth/user_details', json_encode($data_array),$access_token_header);
			$result = json_decode($makecall);
			$status=$result->status; 
			$user['name']=$user['user_id']='';
 			$output='';
			if($status==200)
			{
				if($result->data->user_details!="")
				{
					$output=$output."<option value='ALL'>ALL</option>";
					$i=1;
					foreach($result->data->user_details as $info)
					{
						$output=$output."<option value='$info->userid'>$info->name</option>";

					}
				 }
			 }
			 $data['user_details']=$output;
			 

	$this->load->view("admin/notifications/add-notifications",$data);	 

	}

	public function notification_details()
	{
	   $data=$this->common_data();	 
	   $login_access_token_header=$data['login_access_token_header'];
$inventory_id='';$videoUrl='';$imageUrl='';
		     $operation_type=$this->uri->segment(2);
		   $notification_id=$this->uri->segment(3);
		   $decrypt_notification_id=base64_decode($notification_id);

	   if($operation_type=="Add")
	   { 
			  $user_id=$this->input->post('user');
			//   var_dump($user_id);

			 $userId="";
			foreach ($user_id as $a){
				$userId=$userId.",".$a;
			} 
		// echo 	ltrim($userId,",");exit();
			$datetime=$this->utctime( date('Y-m-d'),date('H:i:s'));

			$notification_title=$this->input->post('title');	
			
			$data_array=array(
				'inventory_id'=>"$inventory_id",
				'imageUrl' => "$imageUrl",
				'user_id'=>ltrim($userId,","),
				'notification_title'=>$notification_title,
				'date'=>$datetime,
				'videoUrl' => "$videoUrl"

			);
			   $makecall = $this->common->callAPI('POST', apiendpoint . "v1/Notifications/notifications", json_encode($data_array), $login_access_token_header);
		   $result = json_decode($makecall);
		   $status=$result->status; 
		   $message=$result->message;
		   if($status==200)
		   {
			   if($result->data!=""){
				   $this->session->set_flashdata('message', 'Notification Sent Successfully');
			   }else{
				   $this->session->set_flashdata('message', $message);
			   }	
					   
		   }else {$this->session->set_flashdata('message', $message);}
		   redirect(base_url()."add_notifications");  
	   }
		 else if($operation_type=="Activate")
	   {  
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Activate","sk_notifications_id"=>$decrypt_notification_id);
			 $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Notifications/notifications", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				 redirect(base_url()."notifications");
			   }   
	   }
	   else if($operation_type=="InActivate")
	   { // var_dump($data);
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"InActivate","sk_notifications_id"=>$decrypt_notification_id);
		 //  var_dump($data_array);exit();

		  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Notifications/notifications", json_encode($data_array), $login_access_token_header);
		 $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  {  
				  $this->session->set_flashdata('message',$message);
				 redirect(base_url()."notifications");
			   }   
	   }
}

public function library_view(){
	$data=$this->common_data();
    $operation_type=$this->uri->segment(2);$output='';$nn='';$tt='';

	if($operation_type=='Tagged'){
		$data['getTaggedDetails']=$this->AdminModel->getTaggedDetails($operation_type);
		$this->load->view("admin/library/view-tagged",$data);
		
	}else if($operation_type=='Project'){
		
		//$where=array('project_status'=>1);
        $projects=$this->AdminModel->getProjectDetails();
		$i=1;
		if($projects)
		foreach($projects as $ing){
			 $project_name=$ing->project_name;
			 $user_name=$ing->name;
			 $inventory_id=$ing->inventory_id;
			 $inventory_name=$inventory_name1="";
			 $getInveDetails=$this->AdminModel->getInveDetails($inventory_id);
		  	
			if($getInveDetails)
			foreach($getInveDetails as $rru){ 
			 	$inventory_name=$inventory_name.",".$rru->title;   
			}
            $inventory_name=ltrim($inventory_name,',');
			$output=$output."<tr><td>$i</td><td>$project_name</td><td>$user_name</td><td>$inventory_name</td>";
            $tt=$tt."</tr>";

		$i++;
	    }
		
		 $data['getProhee']=$output.$tt;
		 
		$this->load->view("admin/library/view-projects",$data);
	}else if($operation_type=='Saved'){
		$data['getSaveDetails']=$this->AdminModel->getSavedDetails();
		$this->load->view("admin/library/view-save",$data);
	
	}


}


		public function home_Screen(){
			$data=$this->common_data();	 
			$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"home_banner_id:All","home_banner_status:1");
			//var_dump($login_access_token_header);exit();
			$data['home_banners']=$output="";
			    $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Banner/home_banner", array(), $login_access_token_header);
				//$category_id=$category_name=$category_image="";
				$result = json_decode($makecall);
			   $status=$result->status;  
			   if($status==200)
			   {
				   if($result->data->home_banners!="")
				   {
					   $i=1;
					   foreach($result->data->home_banners as $info)
					   {
						  $banner_id=$info->banner_id;
						  $inventory_name=$info->inventory_name;

						 $banner_image=$info->banner_image;
						   $edit_url="";$active='';
						   if($info->banner_status==1){
							   $edit_url1=base_url()."banner-details/Edit/".base64_encode($banner_id);
							   $inactivate_url=base_url()."banner-details/InActivate/".base64_encode($banner_id);
							   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
							   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
						   }
						   else {
							   $activate_url=base_url()."banner-details/Activate/".base64_encode($banner_id);
							   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
						   }
	
						//$ext = pathinfo($filename, PATHINFO_EXTENSION);
	
	
							  // $ext = pathinfo($info, PATHINFO_EXTENSION);
							//echo $ext; exit;
							// if($ext=='mp4'){
							// 	//$ext = pathinfo($info, PATHINFO_EXTENSION);
							   
							// 	$inventory="<video width='100' height='100' controls>
							// 				  <source src='$info' type='video/mp4'>
							// 				  </video>";
							// }else{
								$ext = pathinfo($banner_image, PATHINFO_EXTENSION);
								if($ext=='mp4'){
									$banners="<video width='100px' height='100px' controls>
									  <source src='$banner_image' type='video/mp4'>
								   </video>";                       
								 }else{
									$banners="<img src='$banner_image' width='100px' height='100px'>";
								 }
							
								$output=$output."<tr>
								<td>$i</td>
								<td>$inventory_name</td>
								<td>$banners</td>
								<td>$edit_url</td>
								</tr>";
								$i++;
							}
						   
						  
					   } 
				}
				//var_dump($output);
					
				$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"inventory_id:All","inventory_status:1","view_type:Inventory");
		//var_dump($login_access_token_header);exit();
		$data['inventory_details']='';
		
		      $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Inventory/inventory_details", array(), $login_access_token_header);
			//$category_id=$category_name=$category_image="";
		    $result = json_decode($makecall);
		   $status=$result->status; 
		   $output2=''; 
		   if($status==200)
		   {
			   if($result->data->inventory_details!="")
			   {
				   $i=1;
				   foreach($result->data->inventory_details as $info)
				   {
				   	$inventory1='';$inventory='';
					     $inventory_id=$info->inventory_id;
					    $title=$info->title;
						 $output2=$output2."<option value='$inventory_id'>$title</otptin>";
				   }
				}
			}
			   $data['banner_details']=$output;
			   $data['inventory_details']=$output2;

		   $this->load->view("admin/home-banner/home-banner",$data);
	}




	public function banner_details()
	{
	   $data=$this->common_data();	 
	   $login_access_token_header=$data['login_access_token_header'];

		    $operation_type=$this->uri->segment(2);
		   $banner_id=$this->uri->segment(3);
		   $decrypt_banner_id=base64_decode($banner_id);

	   if($operation_type=="Add")
	   { 
		
			$inventory_id=$this->input->post('inventory_id');
			
		   if($_FILES["banner_image"]["name"]!="" ||  $_FILES["banner_image"]["name"]!=NULL){
				
					 $img_path = $_FILES["banner_image"]["name"]; 
				    $type = pathinfo($img_path, PATHINFO_EXTENSION);
					if($type=="png" || $type=="jpg" || $type=="jpeg" || $type=="webp"){
						$detail_title="image";
					}
					else if($type=="mp4"){
						$detail_title='video';
					}				  
					 
				    $img_data = @file_get_contents($_FILES["banner_image"]["tmp_name"]); 
				    $base64_code = base64_encode($img_data);
				   $banner_image = 'data:'.$detail_title.'/' . $type . ';base64,' . $base64_code; 
			}
		
		   $data_array = array("banner_image"=>$banner_image,'inventory_id'=>$inventory_id);

		   //var_dump($data_array); exit;
		  $makecall = $this->common->callAPI('POST', apiendpoint . "v1/Banner/home_banner", json_encode($data_array), $login_access_token_header);
		  $result = json_decode($makecall);
		   $status=$result->status; 
		   $message=$result->message;
		   if($status==200)
		   {
			   if($result->data!=""){
				   $this->session->set_flashdata('message', 'Banner Image Saved Successfully');
			   }else{
				   $this->session->set_flashdata('message', $message);
			   }	
					   
		   }else {$this->session->set_flashdata('message', $message);}
		redirect(base_url()."home-screen");
	   }
	   else if($operation_type=="Edit")
	   { 
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"home_banner_id:".$decrypt_banner_id,"home_banner_status:All");
		   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Banner/home_banner", array(), $login_access_token_header);
		   $result = json_decode($makecall);
			  $status=$result->status;  
			 	     if($status==200)
			  {
				  if($result->data->home_banners!="")
				  {
					  foreach($result->data->home_banners as $info)
					  {
						  $data['banner_id']=$info->banner_id;
						 
						  $data['banner_image']=$info->banner_image;
						  $data['inventory_id']=$info->inventory_id;
						  $data['title']=$info->inventory_name;


						  

					  }
				   }
			   }  
			  
			   $this->load->view("admin/home-banner/home-banner-edit",$data);
	   }
	   else if($operation_type=="update")
	   { 
		$inventory_id=$this->input->post('inventory_id');
			$banner_image='';
		if($_FILES["banner_image"]["name"]!="" ||  $_FILES["banner_image"]["name"]!=NULL){
				
			$img_path = $_FILES["banner_image"]["name"]; 
		   $type = pathinfo($img_path, PATHINFO_EXTENSION);
		   if($type=="png" || $type=="jpg" || $type=="jpeg" || $type=="webp"){
			$detail_title="image";
		}
		else if($type=="mp4"){
			$detail_title='video';
		}	
		   $img_data = @file_get_contents($_FILES["banner_image"]["tmp_name"]); 
		   $base64_code = base64_encode($img_data);
		  $banner_image = 'data:'.$detail_title.'/' . $type . ';base64,' . $base64_code; 
   }
		//var_dump($inventory_images);exit();
					$data_array = array(
					"banner_id"=>$decrypt_banner_id,
					"banner_image"=>$banner_image,
					"inventory_id"=>$inventory_id,
					"update_type"=>"Edit");
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);			
		         $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Banner/home_banner", json_encode($data_array), $login_access_token_header);
				 $result = json_decode($makecall);
			   $status=$result->status;  
			  $message=$result->message; 
			  if($status==200)
			  { 
				  $this->session->set_flashdata('message',$message);
			   } 
			   redirect(base_url()."home-screen");
  
	   }
	   else if($operation_type=="Activate")
	   {  
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"Activate","banner_id"=>$decrypt_banner_id);
			  $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Banner/home_banner", json_encode($data_array), $login_access_token_header);
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==true)
			  {  
				  $this->session->set_flashdata('message',$message);
				 redirect(base_url()."home-screen");
			   }   
	   }
	   else if($operation_type=="InActivate")
	   { // var_dump($data);
		   $login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		   $data_array=array("update_type"=>"InActivate","banner_id"=>$decrypt_banner_id);
		 //  var_dump($data_array);exit();

		   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Banner/home_banner", json_encode($data_array), $login_access_token_header); 
			  $result = json_decode($makecall);
			  $status=$result->status;  
			  $message=$result->message; 
			  if($status==true)
			  {  
				  $this->session->set_flashdata('message',$message);
				  redirect(base_url()."home-screen");
				}   
	   }
}

	function removetag(){
		 $data=$this->common_data();	 
		$login_access_token_header=$data['login_access_token_header'];
		$tag_id=$this->uri->segment(3);
		$decrypt_tag_id=base64_decode($tag_id);
		$getRecords=$this->CommonModel->getRecords(array('sk_tag_id'=>$decrypt_tag_id),'mst_inventory_tag');
		if($getRecords!=false){
			foreach($getRecords as $info){
				$user_id=$info->user_id;
				$inventory_id=$info->inventory_id;
			}
			$getRecords=$this->CommonModel->getRecords(array('sk_user_id'=>$user_id),'mst_user');
				if($getRecords!=false){
					foreach($getRecords as $info){
						$name=$info->name;
						$deviceId=$info->deviceId;
					}
					$res['data']['status']=$user_id;
					$notification = [
						'title' => $data['admin_session_name']." has sent you a message",
						'body' => 'Your Tagged Item was Removed',
						'admin_id' => $data['admin_session_id'], 
						'sound' => 'default'
					];
					$fields = array(
						'to' => $deviceId,
						'notification' => $notification,
						'data' => $res,

					);			
			 $this->sendPushNotification($fields); 
		   
				}
		}
		$imageUrl='';$videoUrl='';
		$datetime=$this->utctime( date('Y-m-d'),date('H:i:s'));
        $getrecords=$this->CommonModel->getRecords(array('sk_inventory_id'=>$inventory_id),'mst_inventory');
		 $image=$getrecords[0]->photo_video;
	 	$ext = pathinfo($image, PATHINFO_EXTENSION);
         if($ext=='mp4'){
            $videoUrl=apiendpoint.$image;
		 }else{
            $imageUrl=apiendpoint.$image;
		 }
		$data_array=array(
			'inventory_id'=>"$inventory_id",
			'imageUrl' => "$imageUrl",
			'message' => "Your Tagged Item was Removed",
			//'created_date' => $datetime,
			'created_time' => $datetime,
			'user1'=>$data['admin_session_id'],
			'user2' => "$user_id",
			'videoUrl' => "$videoUrl"
			);
			$id=$this->CommonModel->save($data_array,'mst_chat');
		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		$data_array=array("sk_tag_id"=>$decrypt_tag_id);
		$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token']);
		$data_array=array("sk_tag_id"=>$decrypt_tag_id,"update_type"=>"Delete");

		   $makecall = $this->common->callAPI('PUT', apiendpoint . "v1/Inventory/removetag", json_encode($data_array), $login_access_token_header);
	  $result = json_decode($makecall);
		   $status=$result->status;  
		   $message=$result->message; 
		   if($status==true)
		   {  
			   $this->session->set_flashdata('message',$message);
			   redirect(base_url()."library-view/Tagged");
			 }   
	}
	
	
	function user_filter(){
		$data=$this->common_data();	 
		$access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],'userId:All','userStatus:1','userType:user');
		 $makecall = $this->common->callAPI('GET', apiendpoint.'v1/Auth/user_details', json_encode(array()),$access_token_header);
		$result = json_decode($makecall);
		$status=$result->status; 
		$user['name']=$user['user_id']='';
		 $output='';
		if($status==200)
		{
			if($result->data->user_details!="")
			{
				$i=1;
				foreach($result->data->user_details as $info)
				{
					$output=$output."<option value='$info->userid'>$info->name</option>";

				}
			 }
		 }
		 $data['user_details']=$output;

	   $this->load->view("admin/userfilter/user-details",$data);
}

public function filters(){
	$data=$this->common_data();	 
	$user_id=$this->input->post('user_id');
	 $select_filter=$this->input->post('select_filter');
	$login_access_token_header=$data['login_access_token_header'];
	$saved='';

	if($select_filter=='Saved'){
		$getSaveDetails=$this->AdminModel->getSavedDetails10($user_id);

			$output='';

			if($getSaveDetails){
				$i=1;
			foreach($getSaveDetails as $getTagged){
			$output="<tr>
			<td>$i</td>
			<td>$getTagged->name</td>
			<td>$getTagged->title</td>
		   
			</tr>";
			 $i++;}

					$saved=$saved.'
					<div class="col-md-12">

					<div class="card">
					  <div class="card-header">
						<h3 class="card-title">View Saved</h3>
					  </div>
					  <div class="card-body"> 
				 
					  <table id="example1" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
					  <thead>
						<tr>
						<th>Sl.No</th>
                       <th>User Name</th>
                        <th>Inventory Name</th>
					  </thead>
					  <tbody>		
					  											'.$output.'</tbody>
							</table></div>';
							
							
					
					
					}
						  
		}else if($select_filter=='Project'){
			$projects=$this->AdminModel->getProjectDetails10($user_id);
			$i=1;
			$output='';
			if($projects){
			foreach($projects as $ing){
				 $project_name=$ing->project_name;
				 $user_name=$ing->name;
				 $inventory_id=$ing->inventory_id;
				 $inventory_name=$inventory_name1="";
				 $getInveDetails=$this->AdminModel->getInveDetails($inventory_id);
				  
				if($getInveDetails)
				foreach($getInveDetails as $rru){ 
					 $inventory_name=$inventory_name.",".$rru->title;   
				}
				$inventory_name=ltrim($inventory_name,',');
				$output=$output."<tr><td>$i</td><td>$project_name</td><td>$inventory_name</td></tr>";
	
			$i++;
			}
			
		
			
						$saved=$saved.'
						<div class="card">
						<div class="card-header">
						  <h3 class="card-title">View Projects</h3>
						</div>
						<div class="card-body">
						<table id="example1" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
						<thead>
						  <tr>
						  <th>Sl.No</th>
						  <th>Project Name</th>
						  <th>Title</th>
						  </tr>
						</thead>
						<tbody>'.$output.'

						</tbody>
						</table>
					  </div>
	  
					</div>';
					   }
					   
			
		}else{
			$getTaggedDetails=$this->AdminModel->getTaggedDetails10($select_filter,$user_id);
						$i=1;
			$output='';
			if($getTaggedDetails){
				$i=1;
			foreach($getTaggedDetails as $getTagged){
			  $sk_tag_id=$getTagged->sk_tag_id;
			$output=$output."<tr>
			<td>$i</td>
			<td>$getTagged->name</td>
			<td>$getTagged->title</td>
			<td>$getTagged->price</td>
			<td>$getTagged->total_amount</td>
			<td>$getTagged->no_of_tagged</td>
			<td>$getTagged->inventory_tag_status</td>

			</td> 
			  
			</tr>";
			 $i++;}
		  
			
		
			
						$saved=$saved.'
						<div class="card">
						<div class="card-header">
						  <h3 class="card-title">View Tagged</h3>
						</div>
						<div class="card-body">
						<table id="example1" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
						<thead>
						  <tr>
						  <th>Sl.No</th>
						   <th>User Name</th>
							<th>Inventory Name</th>
							<th>Inventory price</th> 
							<th>Total Amount</th> 
							<th>No.Of Tagged</th>
							<th>Inventory Status</th>
						  </tr>
						</thead>
						<tbody>'.$output.'

						</tbody>
						</table>
					  </div>
	  
					</div>';
					   }
					   
			
		}
		echo $saved;
}
		function active(){
			$data=$this->common_data();	 
			$value=$this->input->post('value');
			  $type=$this->input->post('type');
			$login_access_token_header=$data['login_access_token_header'];
			$saved='';$activated='';
			if($type=='category'){
				$where=array('category_type_status'=>$value);
				$getCategory=$this->CommonModel->getRecords($where,'mst_category_type');
					$output='';
					if($getCategory){
						$i=1;
					foreach($getCategory as $info){
						$edit_url="";$inactive='';
						if($info->category_type_status==1){
							$edit_url1=base_url()."category-type-details/Edit/".base64_encode($info->sk_category_id);
							$inactivate_url=base_url()."category-type-details/InActivate/".base64_encode($info->sk_category_id);
							$edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
							<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
						}
						else {
							$activate_url=base_url()."category-type-details/Activate/".base64_encode($info->sk_category_id);
							$edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
						}

						$saved=$saved."<tr>
						<td>$i</td>
						<td>$info->category_type</td>
						<td>$edit_url</td>
						</tr>";
						$i++;
					}
							}
								  
				}else if($type=='inventory'){
					$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"inventory_id:All","inventory_status:".$value,"view_type:Inventory");
					//var_dump($login_access_token_header);exit();
					$data['inventory_details']=$output="";
					
					   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Inventory/inventory_details", array(), $login_access_token_header);
						//$category_id=$category_name=$category_image="";
						$result = json_decode($makecall);
					   $status=$result->status;  
					   if($status==200)
					   {
						   if($result->data->inventory_details!="")
						   {
							   $i=1;
							   foreach($result->data->inventory_details as $info)
							   {
								   $title=$info->title;
									$category_id=$info->category_id;
								   $inventory_id=$info->inventory_id;
								   $inventory_image=$info->photo_video;
								   $available=$info->available;
								   $matuare_size=$info->matuare_size;
			
								 // var_dump($inventory_image);
								  
								 // $location_id=$info->location_id;
								  $location_name=$info->location_name;
								  $description=$info->description;
								  $zone=$info->zone;
								  $category_type=$info->category_type;
								  $inventory_date=$info->inventory_date;
								   $edit_url="";$active='';
								   if($info->inventory_status==1){
									   $edit_url1=base_url()."inventory-details/Edit/".base64_encode($inventory_id);
									   $tag_url=base_url()."price-details/tag/".base64_encode($inventory_id);
									   $inactivate_url=base_url()."inventory-details/InActivate/".base64_encode($inventory_id);
									   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
									   <a href='$tag_url'><i class='fa fa-eye'></i></a>|
									   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";					   }
								   else {
									   $activate_url=base_url()."inventory-details/Activate/".base64_encode($inventory_id);
									   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
								   }
			
								//$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			
								   foreach($inventory_image as $info){
									   $ext = pathinfo($info, PATHINFO_EXTENSION);
									//echo $ext; exit;
									if($ext=='mp4'){
										//$ext = pathinfo($info, PATHINFO_EXTENSION);
									   
										$inventory="<video width='100' height='100' controls>
													  <source src='$info' type='video/mp4'>
													  </video>";
									}else{
										$inventory="<img src='$info' height='100' width='100'>";
										
									}
								   }
								   $zones= implode(",",$zone);
								   $saved=$saved."<tr>
								   <td>$i</td>
								   <td>$title</td>
								   <td>$category_type</td>
								   <td>$inventory</td>
								   <td>$matuare_size</td>
								   <td>$location_name</td>
								   <td>$description</td>
								   <td>$zones</td>
								   <td>$inventory_date</td>
								   <td>$edit_url</td>
								   </tr>";
								   $i++;
							   } 
						   }
					   }
				
					}else if($type=='partner'){
						$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"partners_status:".$value,"partners_id:All");

						$data['partner_details']=$output="";
					
					   $makecall = $this->common->callAPI('GET', apiendpoint . "v1/Partner/partner_details", array(), $login_access_token_header);
						$sk_inventory_price_id=$callper=$qty=$price=$price_status='';
					   $result = json_decode($makecall);
					   $status=$result->status;  
					   if($status==200)
					   {
						   if($result->data!="")
						   {
							   $i=1;
							   foreach($result->data->partner_details as $info)
							   {
								   $partner_name=$info->partner_name;
								   $phone_number=$info->phone_number;
								   $website=$info->website;
								   $address=$info->address;
								   $about=$info->about;
								   $services=$info->services;
								   $partner_image=$info->partner_image;
								   $edit_url="";
								   if($info->partner_status==1){
									   $edit_url1=base_url()."partners-details/Edit/".base64_encode($info->sk_partners_id);
									   $inactivate_url=base_url()."partners-details/InActivate/".base64_encode($info->sk_partners_id);
									   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
									   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
			
								   }
								   else {
									   $activate_url=base_url()."partners-details/Activate/".base64_encode($info->sk_partners_id);
									   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
								   }
								   $image="<img src=$partner_image height='100' width='100'>";
								   $saved=$saved."<tr>
								   <td>$i</td>
								   <td>$partner_name</td>
								   <td>$phone_number</td>
								   <td>$website</td>
								   <td>$address</td>
								   <td>$image</td>
								   <td>$services</td>
								   <td>$about</td>
								   <td>$edit_url</td>
								   </tr>";
								   $i++;
							   } 
							}
						}
					}
					else if($type=='banner'){
						$login_access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],"home_banner_id:All","home_banner_status:".$value);
						//var_dump($login_access_token_header);exit();
						$data['home_banners']=$output="";
							$makecall = $this->common->callAPI('GET', apiendpoint . "v1/Banner/home_banner", array(), $login_access_token_header);
							//$category_id=$category_name=$category_image="";
							$result = json_decode($makecall);
						   $status=$result->status;  
						   if($status==200)
						   {
							   if($result->data->home_banners!="")
							   {
								   $i=1;
								   foreach($result->data->home_banners as $info)
								   {
									  $banner_id=$info->banner_id;
									  $inventory_name=$info->inventory_name;
			
									 $banner_image=$info->banner_image;
									   $edit_url="";$active='';
									   if($info->banner_status==1){
										   $edit_url1=base_url()."banner-details/Edit/".base64_encode($banner_id);
										   $inactivate_url=base_url()."banner-details/InActivate/".base64_encode($banner_id);
										   $edit_url="<a href='$edit_url1'><i class='fa fa-edit'></i></a>|
										   <a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
									   }
									   else {
										   $activate_url=base_url()."banner-details/Activate/".base64_encode($banner_id);
										   $edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
									   }
				
									//$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				
										  // $ext = pathinfo($info, PATHINFO_EXTENSION);
										//echo $ext; exit;
										// if($ext=='mp4'){
										// 	//$ext = pathinfo($info, PATHINFO_EXTENSION);
										   
										// 	$inventory="<video width='100' height='100' controls>
										// 				  <source src='$info' type='video/mp4'>
										// 				  </video>";
										// }else{
											$ext = pathinfo($banner_image, PATHINFO_EXTENSION);
											if($ext=='mp4'){
												$banners="<video width='100px' height='100px' controls>
												  <source src='$banner_image' type='video/mp4'>
											   </video>";                       
											 }else{
												$banners="<img src='$banner_image' width='100px' height='100px'>";
											 }
										
											$saved=$saved."<tr>
											<td>$i</td>
											<td>$inventory_name</td>
											<td>$banners</td>
											<td>$edit_url</td>
											</tr>";
											$i++;
										}
									   
									  
								   } 
							}
					}else{
						$access_token_header = array('Content-Type:application/json','Accesstoken:'.$data['admin_session_token'],'userId:All','userStatus:'.$value,'userType:user');
						$makecall = $this->common->callAPI('GET', apiendpoint.'v1/Auth/user_details', json_encode(array()),$access_token_header);
						$result = json_decode($makecall);
						$status=$result->status;
						$message=$result->message;
						$output='';
							if($status==200)
							{
								if($result->data!="")
								{

							$i=1;
							foreach($result->data->user_details as $info)
							{

								$name=$info->name;
								$company_name=$info->company_name;
								$role=$info->role;
								$company_address=$info->company_address;
								$city=$info->city;
								$mobile=$info->mobile;
								$email=$info->email;
								$zipcode=$info->zipcode;
								
						
								$edit_url="";
								if($info->user_status==1){
									$edit_url1=base_url()."user-details/Edit/".base64_encode($info->userid);
									$inactivate_url=base_url()."user-details/InActivate/".base64_encode($info->userid);
									//$edit_url="<a href='$inactivate_url'><i class='fa fa-trash'></i></a>";
									$edit_url="<a href='$inactivate_url'>Reject</a>";
								}
								else {
									$activate_url=base_url()."user-details/Activate/".base64_encode($info->userid);
									//$edit_url="<a href='$activate_url'><i class='fa fa-check'></i></a>";
									$edit_url="<a href='$activate_url'>Approve</a>";
								}
								$saved=$saved."<tr>
								<td>$i</td>
								<td>$name</td>
								<td>$company_name</td>
								<td>$company_address</td>
								<td>$mobile</td>
								<td>$email</td>
								<td>$city</td>
								<td>$zipcode</td>
								<td>$role</td>
								<td>$edit_url</td>
								</tr>";
								$i++;
							}
							} 
				
							}

						}
				
								echo $saved;
			
						
		}
}

?>