//document.write("<script type=\"text\/javascript\" src=\"http:\/\/lib.sinaapp.com\/js\/jquery\/1.7\/jquery.min.js\"><\/script>");
function checkField(re, sender, msg) {
    //var re =  ^\s*$;
    if (new RegExp(re).test(sender.value)){
        return true;
    }  else {
		alert(msg);
        sender.focus();
	}
    return false;
}
function setStatus(idName, allName) {
        var elts = document.getElementsByName(idName);
        if (!empty(elts) && elts.length > 0) {
                for (var i = 0; i < elts.length; i++) {
                        if (!elts[i].checked) {
                                document.getElementById(allName).checked = false;
                                return;
                        }
                }
        }
        document.getElementById(allName).checked = true;
}

function checkAll(obj, str) {
        var elts = document.getElementsByName(str);
        if (!empty(elts) && elts.length > 0) {
                for (var i = 0; i < elts.length; i++) {
                        elts[i].checked = obj.checked;
                } // end for
        }
}

function ask(url) {
        if (confirm('你确实要删除?')) {
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
String.prototype.trim = function() {
        return this.replace(/(^\s+)|(\s+$)/g, "");
}