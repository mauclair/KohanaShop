/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var keypressTimeout;

function refresh_items(data){
    var item = $("#caj_ingredience_items");    
    item.empty(); // clean the objects        
    item.append(data);
    $(".caj_item").draggable({ opacity: 0.7,helper:'clone' ,revert: 'invalid' });
}

function reload_items(){
   var filter = $("#caj_ingredience_search").val();
   $.post("index.php?page=shop/tea", {ajax:true,query:filter,action:'refresh'}, 
    function(data){
        $("#caj_slozeni").empty().append(data.slozeni);
        $("#caj_ingredience_items").empty().append(data.ingredience);
        $(".caj_item").draggable({ opacity: 0.7,helper:'clone' ,revert: 'invalid' });
        $(".delete").click(ingredience_delete);
    },'json'
    );
   
}

function refresh_tea_items(data){
    var item =  $("#caj_slozeni");
    item.empty();        
    item.append(data);
    $(".delete").click(ingredience_delete);    
}

function addToTea(object_id){
   $.post("index.php?page=shop/tea", {ajax:true,id:object_id,action:'add'}, refresh_tea_items);
}

function ingredience_delete(){
    var object_id = $(this).parents(".ingredience_item").attr("id");
   $.post("index.php?page=shop/tea", {ajax:true,id:object_id,action:'delete'}, function(data){reload_items();});
}




jQuery(document).ready(function(){
    reload_items();
    $("#caj_ingredience_search").keypress(function(){
       clearTimeout(keypressTimeout);
       keypressTimeout = setTimeout(reload_items, 300);
    });
    $("#caj_slozeni_drop").droppable({activeClass: 'ui-state-hover',
			hoverClass: 'ui-state-active',
			 drop: function(element, ui) {
				addToTea(ui.draggable.attr("id"));
                                ui.draggable.fadeOut(function(){
                                        $(this).remove();
                                });
                            
                                //("#caj_ingredience_items").remove();
			}});
    
    
});
