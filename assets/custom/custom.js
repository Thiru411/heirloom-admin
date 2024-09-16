function getCountry(continent_id)
{  	 
	$.ajax({
        method:'post',
        url:AJAX_URL+"getDetails",
        data:{continent_id:continent_id,view_type:'getCountry'},
        success:function(response) {  
            $("#country_id :selected").remove();  
           $('#country_id').find('option').remove().end().append(response);
            
        }
    });      
} 
function getState(country_id)
{  	 
	$.ajax({
        method:'post',
        url:AJAX_URL+"getDetails",
        data:{country_id:country_id,view_type:'getStates'},
        success:function(response) {  
            $("#state_id :selected").remove();  
           $('#state_id').find('option').remove().end().append(response);
            
        }
    });    

} 
function getCity(state_id)
{  	 
	$.ajax({
        method:'post',
        url:AJAX_URL+"getDetails",
        data:{state_id:state_id,view_type:'getCity'},
        success:function(response) {  
            $("#city_id :selected").remove();  
           $('#city_id').find('option').remove().end().append(response);
            
        }
    });      
} 
function getLocation(city_id)
{  	 
	$.ajax({
        method:'post',
        url:AJAX_URL+"getDetails",
        data:{city_id:city_id,view_type:'getLocation'},
        success:function(response) {  
            $("#location_id :selected").remove();  
           $('#location_id').find('option').remove().end().append(response);
            
        }
    });      
} 

