var notemptyRes = true;


function captchaValid(){
	var  val=$("#kontrola").val();
   	val = hex_md5(val.toUpperCase());        
    if (captcha ==val.toString()) {
    	$("#kontrolaCheck").attr("src","img/success.gif");
    	return true; 
    } else {
    	$("#kontrolaCheck").attr("src","img/failed.gif");        	
    	return false;
    }	
    
}

function emailValid(){
	var  val=$("#email").attr('value');
   	var rexp = new RegExp("^[_a-z0-9A-Z+-]+(\.[_a-z0-9A-Z+-]+)*@[a-z0-9A-Z-]+(\.[a-z0-9A-Z-]{2,4})+$");//("[A-Z0-9._%+-]@[A-Z0-9.-]\.[A-Z]{2,4}");   	
   	if ( rexp.test(val) ) {
   		$("#emailCheck").attr("src","img/success.gif");
   		return true; 
   	  } else{
   	   	$("#emailCheck").attr("src","img/failed.gif");
   	   	return false;
   	  } 
}

function loginValid(){ 		
 		if ($("#login").attr('value').length<1) return false;
	    $.post("index.php?page=shop/isFreeLogin",{login:$("#login").attr('value'),ajax:1},function(data){	    
		if (data==0) {
    		$("#loginCheck").attr("src","img/success.gif");
    		$("#loginMessage").text('');
    		res = true; 
    	} else {
    		$("#loginCheck").attr("src","img/failed.gif");
    		$("#loginMessage").html(unameExists); 
    		res =  false;
    	}    			
	});
	return($("#loginMessage").text() == '');
	
		
}

function passwordValid(){
	var v1 = 	$("input[name='password_1']").attr("value");
	var v2 =   	$("input[name='password_2']").attr('value');
	
	if (v1.length == 0 || v2.length ==0) return false; 	
   	if ( v1 == v2 ) {
   		$("#passwordCheck").attr("src","img/success.gif");
   		$("#passwordMessage").html('');
   		return true;   		 
   	  } else{
   	   	$("#passwordCheck").attr("src","img/failed.gif");
   	   	$("#passwordMessage").html(pwdMatch);
   	   	return false;
	  }
}

function notempty(){
    var name = this.name;    
    var str = "input[name='"+name+"']";
	var val = this.value;//$(str).attr('value');
	
	//alert(val+ ' ' + str);
	if (val.length < 1) {
		$("#"+name+"Check").attr("src","img/failed.gif");
		notemptyRes = false;		 
		return false;
	} else {		
		$("#"+name+"Check").attr("src","img/success.gif");		
		return true;
	} 	
}

function checkAll(showbox){
  res = true;  
  if (!passwordValid() ) res = false;
  
  if (!emailValid() ) res = false;
  
  if (!captchaValid() ) res = false;
  var t = loginValid();
  if (!t ) res = false;  
  notemptyRes = true;  
  $(".requied input").each(notempty)
  if (!notemptyRes) res=false;
  if (showbox && !res) alert(formNotValid)  
  return res;
  
}
 
$(document).ready( function(){
   $(".requied input").keyup(notempty);
   $("#kontrola").keyup( captchaValid );   
   $("#email").keyup(emailValid);   		
   $("#login").keyup(function() { 
   		if (timer) 	window.clearTimeout(timer);
		timer = window.setTimeout(loginValid,250);
	});
	$("#password_2").keyup(passwordValid);
	$("#password_1").keyup(passwordValid);	
	checkAll(false);
   
  
    
});