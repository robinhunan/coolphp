;!window.jQuery && document.write('<script src="//libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>');

//获取get变量值
function getQueryString(name){
	 var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return '';
}
regexp = new Object();
//检查用户名
regexp.name=function(str){
	return /^[a-z0-9\_\-\.]{5,20}$/.test(str);;
}
//检查密码
regexp.pwd=function(str){
	return /^\S{6,20}$/.test(str);
}

// 检查输入的一串字符是否全部是数字
regexp.num=function(str){
    return /^\d+$/.test(str);
}

// 检查输入的一串字符是否为小数
regexp.decimal=function(str){
    return /^\d+\.\d+$/.test(str);
}


// 检查输入的一串字符是否包含汉字
regexp.chinese=function(str){
   return  /^[\u4E00-\u9FA5]+$/.test(str);
}


// 检查输入的邮箱格式是否正确
regexp.email=function(str){
    return /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(str);
}



// 检查输入的手机号码格式是否正确
regexp.mobile=function(str){
    return /^1[0-9]{10}$/.test(str);
}



// 检查输入的固定电话号码是否正确
regexp.tel=function(str){
    return /^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/.test(str);
}


// 检查QQ的格式是否正确
regexp.qq=function(str){
    return /^\d{5,10}$/.test(str);
}


// 检查输入的身份证号是否正确
//  返回:true 或 flase; true表示格式正确
regexp.idcard=function(str){
    return /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[A-Z])$/.test(str);
}


// 检查输入的IP地址是否正确
regexp.ip=function(str){
    return  /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/.test(str);
}


// 检查输入的URL地址是否正确
regexp.url=function(str){
    return /(http[s]?|ftp):\/\/[^\/\.]+?\..+\w$/i.test(str);
}


// 检查日期格式是否正确
// 验证短日期（2007-06-05）
regexp.date=function(str){
    var value = str.match(/^(\d{1,4})(-|\/|\.)(\d{1,2})\2(\d{1,2})$/);
    if (value == null) {
        return false;
    }
    else {
        var date = new Date(value[1], value[3] - 1, value[4]);
        return (date.getFullYear() == value[1] && (date.getMonth() + 1) == value[3] && date.getDate() == value[4]);
    }
}


// 检查时间格式是否正确
// 验证时间(10:11) 或者 10:11:12
regexp.time=function(str){
   return /^(?:(?:0?|1)\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/.test(str);
}


// 检查日期时间格式是否正确
// (2007-05-05 10:11:12)
regexp.dateTime=function(str){
	return /(\d{1,4})(\.|-|\/)(\d{1,2})\2(\d{1,2})\s(\d+):[0-5]\d(:[0-5]\d)?$/.test(str);
}


function ask(url) {
        if (confirm('你确定要删除?')) {
                location.href = url;
        }
}
//判断是否需要跳转到手机站
function toMobile(url) {
    if( window['localStorage'] !== null && localStorage.getItem('vistPC')==1 ){
        return true;
    }
     if(window.location.href.indexOf('#PC')!=-1 ){
         localStorage.setItem('vistPC', 1)
         return true;
     }
     var mobileAgent = new Array("iphone", "ipod", "ipad", "android", "mobile", "blackberry", "webos", "incognito", "webmate", "bada", "nokia", "lg", "ucweb", "skyfire");
       var browser = navigator.userAgent.toLowerCase();
       for (var i = 0; i < mobileAgent.length; i++) 
       {
           if (browser.indexOf(mobileAgent[i]) != -1) 
           {
               location.href = url;
               return true;
            }
        }
}

//unix时间戳字符串转换成时间格式
//"1403058804".date('yyyy年mm月dd日 hh:ii:ss');
String.prototype.date = function(fmt) {
	var newDate = new Date();
	newDate.setTime(this * 1000);
	var o = {   
		"m+" : newDate.getMonth()+1,                 //月份   
		"d+" : newDate.getDate(),                    //日   
		"h+" : newDate.getHours(),                   //小时   
		"i+" : newDate.getMinutes(),                 //分   
		"s+" : newDate.getSeconds(),                 //秒
	};
	if(/(y+)/.test(fmt))   
		fmt=fmt.replace(RegExp.$1, (newDate.getFullYear()+"").substr(4 - RegExp.$1.length));   
	for(var k in o)   
		if(new RegExp("("+ k +")").test(fmt))   
		fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));   
	return fmt;   
}



//在元素旁边显示提示信息
jQuery.fn.extend({
	//表单控件提示信息，msg提示文字，right 显示正确或者错误信息
	msg : function(msg,right){
		if(msg==''){ msg='&nbsp;'};
		var oMsg = $(this).parent().find(".msg");
		if(oMsg.length<1){
			oMsg = $('<span class="msg"></span>');
			$(this).parent().append(oMsg);
		}
        if (typeof right=="undefined") { //显示错误信息
            oMsg.removeClass('right').addClass('error').html(msg).show();
        } else { //验证通过提示
			oMsg.removeClass('error').addClass('right').html(msg).show();
        }
	}
});
 //带进度条提交数据
function ajaxData(url,data,func){
	var load=layer.load(2);
	$.post(url,data,func).complete(function(){layer.close(load)});
}
//加载js或者css文件
function include(fn) {
	var files = typeof file == "string" ? [fn]:fn;
	var head = document.getElementsByTagName('head')[0];
	$.each(files,function(k,name){
		if(/\.css/i.test(name)!==true){
			var script = document.createElement('script');
			script.type = 'text/javascript';
			script.src = name;
			head.appendChild(script);
		}else {
			var link = document.createElement('link');
			link.rel = 'stylesheet';
			link.href = name;;
			head.appendChild(link);
		}
	})
}
jQuery(document).ready(function(){
	$.ajaxSetup({cache:false});
	$('<link id="layui_layer_skinlayercss" rel="stylesheet" type="text/css" href="//cdn.bootcss.com/layer/2.3/skin/layer.css" />').appendTo("head");
	include(["//cdn.bootcss.com/layer/2.3/layer.js"]);
})	
