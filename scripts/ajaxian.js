/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
   $("a").click(function(){
       var href = this.href+"&ajax";
       $("#content").load(href);
       return false;
   });
});

