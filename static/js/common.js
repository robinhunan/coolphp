
function getQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}
String.prototype.trim = function(){ return this.replace(/(^\s+)|(\s+$)/g, "");}
function ask(url) {
        if (confirm('你确定要删除?')) {
                location.href = url;
        }
};


