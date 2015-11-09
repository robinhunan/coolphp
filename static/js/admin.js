
 //左右菜单折叠
 jQuery(function($) {
        $(".secondary-list li").on("click", function(event) {
               event.stopPropagation();
        })
 
        $(".list-type").on("click", function() {

               if ($(this).find(".secondary-list").is(":hidden")) {
                      $(this).find(".secondary-list").slideDown();
                      $(this).find("i").html('&#xe611;');

               } else {
                      $(this).find(".secondary-list").slideUp();
                      $(this).find("i").html('&#xe610;');
               }
        })
       var con = getQueryString('c');
       if ( con!=null) {
              var id='#c_'+con;
              //console.log(id);
              $(id).css('color','#4CB74C');
              $(id).parents('li.list-type').click();
       }

 });