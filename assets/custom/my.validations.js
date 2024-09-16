function isNumberKeyevent(evt) //onkeypress="return isNumberKeyevent(event)"
{
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
return true;
}

//GLobal Scripts
function isNumberKey(evt)		// onkeypress="return isNumberKey(event)"
{
	  if ([e.keyCode||e.which]==9) //this is to allow backspace
		    return true;
	  
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
   return true;
}

function AllowAlphabet(e)		// onkeypress="return AllowAlphabet(event)"
{
	  if ([e.keyCode||e.which]==8) //this is to allow backspace
		    return true;
	  if ([e.keyCode||e.which]==9) //this is to allow backspace
		    return true;
	isIE=document.all? 1:0
	keyEntry = !isIE? e.which:event.keyCode;
	if(((keyEntry >= '65') && (keyEntry <= '90')) || ((keyEntry >= '97') && (keyEntry <= '122')) || (keyEntry=='46') || (keyEntry=='32') || keyEntry=='45' ) 
		return true;  
	else
		return false;
}

function IntegerAndDecimal(e,obj,isDecimal)		// onkeypress=' IntegerAndDecimal(event,this,true)'
{
	  if ([e.keyCode||e.which]==9) //this is to allow backspace
		    return true;
	  
    if ([e.keyCode||e.which]==8) //this is to allow backspace
    return true;

    if ([e.keyCode||e.which]==46) //this is to allow decimal point
    {
      if(isDecimal=='true')
      {
        var val = obj.value;
 
        if(val.indexOf(".") > -1)
        {
            e.returnValue = false;
            return false;
        }
        return true;
      }
      else
      {
        e.returnValue = false;
        return false;
      }
    }

    if ([e.keyCode||e.which] < 48 || [e.keyCode||e.which] > 57)
    e.preventDefault? e.preventDefault() : e.returnValue = false; 
}

function blockNonNumbers(obj, e, allowDecimal, allowNegative)  //onkeypress="return blockNonNumbers(this, event, true, true);" 
{
	var key;
	var isCtrl = false;
	var keychar;
	var reg;
		
	if(window.event) {
		key = e.keyCode;
		isCtrl = window.event.ctrlKey
	}
	else if(e.which) {
		key = e.which;
		isCtrl = e.ctrlKey;
	}
	
	if (isNaN(key)) return true;
	
	keychar = String.fromCharCode(key);
	
	// check for backspace or delete, or if Ctrl was pressed
	if (key == 8 || isCtrl)
	{
		return true;
	}

	reg = /\d/;
	var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
	var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
	
	return isFirstN || isFirstD || reg.test(keychar);
}

function isDecimalKey(evt, obj) // onkeypress="return isDecimalKey(event,this)"
{
	var charCode = (evt.which) ? evt.which : event.keyCode
    var value = obj.value;
    var dotcontains = value.indexOf(".") != -1;
    
    if (dotcontains)
    {
    	$(this).val('');
        if (charCode == 46) return false;
    }
    if (charCode == 46) return true;
    
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
    	$(this).val('');
        return false;
    }
    return true;
}

function validateFloatKeyPress(e){
	console.log(e.value);
	e.value = e.value
  .replace(/[^\d.]/g, '')             // numbers and decimals only
  .replace(/(^[\d]{7})[\d]/g, '$1')   // not more than 6 digits at the beginning
  .replace(/(\.[\d]{2})./g, '$1');    // not more than 2 digits after decimal
  }

  
  
//thanks: http://javascript.nwbox.com/cursor_position/
function getSelectionStart(o) {
	if (o.createTextRange) {
		var r = document.selection.createRange().duplicate()
		r.moveEnd('character', o.value.length)
		if (r.text == '') return o.value.length
		return o.value.lastIndexOf(r.text)
	} else return o.selectionStart
}

function net_worth_check(e) {
    
    e.value = e.value
      .replace(/[^-?\d.]/g, '')             // numbers and decimals only
      .replace(/(^-?[\d]{7})[\d]/g, '$1')   // not more than 6 digits at the beginning
      .replace(/(\.[\d]{2})./g, '$1');    // not more than 2 digits after decimal
  }
function isDecimalKeyPercentage(evt, obj) // onkeypress="return isDecimalKeyPercentage(event,this)"
{
	var charCode = (evt.which) ? evt.which : event.keyCode
    var value = obj.value;
    var dotcontains = value.indexOf(".") != -1;
    var percentage = value.indexOf("%") != -1;
    if (dotcontains)
        if (charCode == 46) return false;
    if (percentage)
        if (charCode == 37) return false;
    if (charCode == 46) return true;
    if (charCode == 37) return true;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function checkMoblieLength(id) {
	
	var mobile=document.getElementById(id).value;
	
	if(mobile.length<10){
		if(id=="office_mobile" || id=="off_number"){
			$("#msg").html("<br/><center>Mobile number must be 10 digits.</center>");
			document.getElementById(id).value="";
			document.getElementById(id).focus();
		}
		else if(id=="warehouse_mobile"){
			$("#msg1").html("<br/><center>Mobile number must be 10 digits.</center>");
			document.getElementById(id).value="";
			document.getElementById(id).focus();
		}
		
	}
	else{
		$("#msg").html("");
		$("#msg1").html("");
	}
}
function checkPincodeLength(id) {
	
	var pincode=document.getElementById(id).value;
	if(pincode.length<6){
		if(id=="pincode"){
			$("#pincode_msg").html("<br/><center>Pincode must be 6 digits.</center>");
			document.getElementById(id).value="";
			document.getElementById(id).focus();
		}
	}
	else{
		$("#pincode_msg").html("");
	}
}

function checkYear(id,i) {
	var year=document.getElementById(id+i).value;
	if(year.length<4){
		
			$("#year_msg"+i).html("<br/><center>Year must be 4 digits.</center>");
			document.getElementById(id+i).value="";
			document.getElementById(id+i).focus();
		
	}
	else{
		$("#year_msg"+i).html("");
	}
}

$(function(){
	$("#pancard,#gst_no").keypress(function (e) {
		var regex = new RegExp("^[a-zA-Z0-9]+$");
	    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
	    if (regex.test(str)) {
	        return true;
	    }
	
	    e.preventDefault();
	    return false;
	});
	
	$("#off_land_num,#pincode,#off_number").bind('cut copy paste', function (e) {
		e.preventDefault();
	});
	
});

function checkPancardLength(id) {
	var pancard=document.getElementById(id).value;
	if(pancard.length<10){
		
			$("#pancard_msg").html("<br/><center>Pancard must be 10 digits.</center>");
			document.getElementById(id).value="";
			document.getElementById(id).focus();
		
	}
	else{
		$("#pancard_msg").html("");
	}
}
function checkGSTINLength(id) {
	var gstin=document.getElementById(id).value;
	if(gstin.length<15){
		
			$("#gstin_msg").html("<br/><center>GSTIN must be 15 digits.</center>");
			document.getElementById(id).value="";
			document.getElementById(id).focus();
		
	}
	else{
		$("#gstin_msg").html("");
	}
}

/*
  function mask(textbox, e) {
	var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode == 46 || charCode > 31&& (charCode < 48 || charCode > 57)) 
    {
      return false;
    }
   else
   {
      return true;
   }
}
function numberMobile(e){
    e.target.value = e.target.value.replace(/[^\d]/g,'');
    return false;
}
*/



