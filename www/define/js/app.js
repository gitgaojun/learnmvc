/**
 * Created by jun90610@gmail.com on 2015/4/24.
 */

$(document).ready(function(){
    //alert("reaewewer");return false;
    $(".account-a").bind("click",function(){

        //单击的时候先检查用户是否登录
        //如果没有登录那么跳转登录注册页面
        var $cookie = document.cookie;
        if($cookie["uName"] == undefined){
            window.location.href="/login/index";
        }
    });
});

