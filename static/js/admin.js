
 //左右菜单折叠
 ;jQuery(function($) {
        $(".secondary-list li").click(function(event) {
               event.stopPropagation();
        })
 
        $(".list-type").click(function() {

               if ($(this).find(".secondary-list").is(":hidden")) {
                      $(this).find(".secondary-list").slideDown();
                      $(this).find("span").removeClass('fa-angle-double-down').addClass('fa-angle-double-up');

               } else {
                      $(this).find(".secondary-list").slideUp();
                      $(this).find("span").removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
               }
        })
        //设置左侧菜单选中状态
       var curMenu=$('.admin-left').find("a[href='"+window.location.search+"']");
       if(curMenu.length<1){
            var con = getQueryString('c');
            curMenu=$('.admin-left').find("a[href='?c="+con+"']");
       }
       curMenu.length ==1 && curMenu.css('color','#4CB74C');
       curMenu.parents('li.list-type').click();
      

 })
 ;