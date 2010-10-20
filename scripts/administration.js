$(function(){

        $('.toggler').click(function(event){
            var obj = $(this);
            var field = obj.attr('rel');
            obj.append('<img class="loader" src="imgs/ajax-loader.gif" />')
            function updateObject(data){
                if(data[field]!=undefined){
                    obj.removeClass('button-on');
                    obj.children('.loader').remove();
                    if(data[field]=='Y') obj.addClass('button-on');
                }
            }

            $.post(obj.attr('href'), {}, updateObject, 'json')
            event.preventDefault();
        });

           $('.confirm').click(function(){
                    return(confirm($(this).attr('title')));
           });

           
           
});