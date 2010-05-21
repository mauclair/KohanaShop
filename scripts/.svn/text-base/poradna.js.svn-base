var hidden = true;
function deleteRecord(url){
			if (confirm('Are you sure you want to delete this record(s)?\nThis operation cannot be undone.'))
			document.location.href=url;
}	

$(document).ready( function (){
		$("#poradna_form").css('display','none');
		$("#formToggle").click(function(){
			if ( hidden ) { 
				$("#poradna_form").slideDown("normal");
				$("#formToggle").text(hide);
				hidden = false;
			} 
			else { 
				$("#poradna_form").slideUp("normal");
				$("#formToggle").text(show);
				hidden = true;
			}
			
		});
});