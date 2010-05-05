var timer;
function render(){
	var res='';	
	res = $("#mailBody").val(); 
	$.post('index.php?page=product/renderEmail',{ajax:1,text:res},function(data){		
		$("#preview").html(data);
	});		
}

function addOnCursor(){
  var obj = $("#mailBody");
  var pos_s = obj.attr('selectionStart');
  var pos_e = obj.attr('selectionEnd');
  var text =  obj.val();  
  text = text.substr(0,pos_e) +" ::"+this.value+":: "+text.substr(pos_e);
  obj.val(text);
  render();
  
  
}

$(document).ready(function(){
	$("#render").click(render);
	$("#mailBody").keyup(function() { 
   		if (timer) 	window.clearTimeout(timer);
		timer = window.setTimeout('render()',1000);		
	});
	$("option").dblclick(addOnCursor);
});