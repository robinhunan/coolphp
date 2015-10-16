
function loadjs(fn) { 
        document.write('<' + 'script language="javascript" type="text/javascript"'); 
        document.write(' src="' + fn + '">'); 
        document.write('<'+'/script'+'>'); 
}
window.onload=loadjs("//libs.baidu.com/jquery/1.10.2/jquery.min.js");

function ask(url) {
        if (confirm('你确定要删除?')) {
                location.href = url;
        }
}

function empty(v) {
        if (v == '' || v == undefined || v == null) {
                return true;
        } else {
                return false;
        }
}