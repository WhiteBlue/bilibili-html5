/**
 * Created by WhiteBlue on 16/1/11.
 */


var serviceUrl = 'http://bilibili-service.daoapp.io';

//修改URL指定参数
function changeURLParam(old, par, par_value) {
    var pattern = par + '=([^&]*)';
    var replaceText = par + '=' + par_value;
    if (old.match(pattern)) {
        var re = eval('/(' + par + '=)([^&]*)/gi');
        return old.replace(re, replaceText);
    } else {
        if (old.match('[\?]')) {
            return old + '&' + replaceText;
        }
        else {
            return old + '?' + replaceText;
        }
    }
}


function getUrlParam(url, name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = url.match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}


function pageChange(page) {
    window.location = changeURLParam(window.location.href, 'page', page)
}