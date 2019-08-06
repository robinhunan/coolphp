function Validate(){

      //表单校验控件初始化函数
      //返回：void
       this.init =function(){
		$("[check]").click(function(){
            var flag =true;
            $("#"+$(this).attr("check")).find("[rule]").each(function(){
                var ret =checkField($(this));
                if(!ret) {//对每一个控件校验
                   flag =false;
                }                  
               handleMethod(ret,$(this));
             });
             return flag;
          });
         //为控件注册焦点离开事件，焦点离开时出发校验
         $("[rule]").blur(function(){
             var flag =checkField($(this));
             handleMethod(flag,$(this));
          });
       }
      
      
       //校验函数
       //参数ctl类型object 控件对象
      //返回：bool
       var checkField= function(ctl){         
          try{
            eval("(oRule="+ctl.attr("rule")+")");
          }catch(err){
            alert(ctl.attr("rule")+ "\n"+ err);
          }
          var flag =true;
          if($.trim(ctl.val())==""){ //非空校验
             flag =!oRule.required ? true : false;
             if(!flag)
                return false;
          }
         
         if(oRule.type=="int") { //检查是否是整形
			// console.log(ctl.val());
             if ( !/^[0-9]*$/.test(ctl.val()) )
                return false;            
          }
          if(oRule.type=="float") { //浮点数
             if ( /^[0-9]+\.{0,1}[0-9]{0,2}$/.test(ctl.val())== false )
                return false;
          }
          if(oRule.type=="select") {
             if(ctl.val() == "0")
                return false;
          }
          if(oRule.type=="checkbox") { //检查选择框
             if($("input[type='checkbox'][name='" + ctl.attr('name') +"']:checked").length < 1)
                return false;
          }
          if(oRule.type=="radio") { //检查单选框
             if($("input[type='radio'][name='" + ctl.attr('name') +"']:checked").length < 1)
                   return false;
          }
          if(oRule.type=="email") { //检查email 地址
            if(!/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/.test(ctl.val())){
                return false;
             }
          }

          if(oRule.type=="gbk") { //检查是否是中文
             if(!/[\u4e00-\u9fa5]+$/.test(ctl.val())) {
                return false;
             }
          }

         if(oRule.equal)   {   //比较值是否相同
             if (ctl.val() != $("#"+oRule.equal).val() ) {
                return false;
             }
          }
         if(oRule.regular) {//使用自定义正则表达式校验
             if (ctl.val().match(oRule.regular.toString()) ==false ) { return false;}
          }
         if(oRule.min) //数值不能小于特定值校验
          {
             if (parseFloat(ctl.val()) < parseFloat(oRule.min) ) {return false; }
          }
         if(oRule.max)//数值不能大于特定值校验
          {
             if (parseFloat(ctl.val()) > parseFloat(oRule.max) ) {return false; }
          }
         if(oRule.minLength)//字符长度不能小于特定值校验
          {
             if(!isNaN(oRule.minLength)){   
                if(ctl.val().length < parseInt(oRule.minLength) ) {return false; }
             }
          }
         if(oRule.maxLength)//字符长度不能大于特定值校验
          {
             if(!isNaN(oRule.maxLength)) {
                if(ctl.val().length > parseInt(oRule.maxLength) ) {return false; }
             }
          }
         if($.trim(oRule.fn)!='') { //自定义函数校验
            eval("(flag="+oRule.fn+"(ctl,oRule))");
             if(!flag)   {
                return false;
             }
          }
          return flag;
       }
      
	   //错误信息提示控制函数
      //参数：ctl类型object 控件对象
      //     参数：flag类型bool，true为校验成功，false为校验失败
      //返回：void
       var changeMsg=function(ctl,flag){
			if(ctl.next("label[ext]").length==0){
				ctl.after('<label ext="msg" class="icon"></label>');
			}
			if(!flag){//显示错误信息
				if(oRule.msg== undefined){oRule.msg="格式错误！";}
			    ctl.next("label[ext]").removeClass("right").addClass("error").html(oRule.msg).show();
			} else {
			   oRule.msg="";
			   ctl.next("label[ext]").removeClass("error").addClass("right").html(oRule.msg).show();
			}
       }

       //处理函数
      //对校验成功的控件和失败的控件进行默认和自定义操作
      //参数：flag类型bool，true为校验成功，false为校验失败
      //     ctl类型object 控件对象
      //返回：bool
       var handleMethod=function(flag,ctl){
          if(!flag){ //校验失败
            if(oRule.clear == "true") {//清空非法输入
               ctl.val("");
             }
          }
          changeMsg(ctl,flag);
          return flag;
       }
}
jQuery(function($){
	var _obj=new Validate();
	_obj.init();

});