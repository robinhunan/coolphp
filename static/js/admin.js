 //左右菜单折叠
 ;jQuery(function($){
	$(".secondary-list li").on("click", function(event){
         event.stopPropagation();  
    })

    $(".companyInfo-con-left li.cur").find(".secondary-list").show();
    $(".companyInfo-con-left li.cur").find("img").attr("src","/static/images/up.png");
    $(".list-type").on("click",function(){
   	 if($(this).find(".secondary-list").is(":hidden")){
       $(this).find(".secondary-list").slideToggle();
       $(this).siblings().find(".secondary-list").slideUp();
       $(this).siblings().find("img").attr("src","/static/images/down.png");
       $(this).find("img").attr("src","/static/images/up.png");
   	 }else{
       $(this).find(".secondary-list").slideUp();
       $(this).find("img").attr("src","/static/images/down.png");
   	 }
   })

})