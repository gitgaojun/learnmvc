/**
 * Created by jun90610@gmail.com on 2015/7/15.
 */
/******************验证码************************************/
function getCodeImage(){
    $('#codeImage').attr("src","/user/adCode.html?num="+Math.random());
}
$(document).ready(function() {//利用jquery在写在里面

    $('#sub_btn').bind('click', function () {

        /**************设置ajax同步*************************************************/
        $.ajaxSetup({
            async : false
        });
        var user_name = $('#user_name').val(),
            user_pwd = $('#user_pwd').val(),
            user_code = $('#user_code').val(),
            is_ajax = 0,
            is_sign = 0;
        /************去空格处理***********************************************/
        user_name = user_name.replace(/\s+/g, "");
        user_pwd = user_pwd.replace(/\s+/g, "");
        user_code = user_code.replace(/\s+/g, "");
        if (user_name === '') {
            $('.name_msg').text('请输入a-z或字母下滑线格式');
        }else{
            $('.name_msg').text('');
            is_ajax = 1;
        }
        if (user_pwd === '') {
            $('.pwd_msg').text('请输入密码');
            is_ajax = 0;
        }else{
            $('.pwd_msg').text('');
            is_ajax = 1;
        }
        if (user_code === '') {
            $('.code_msg').text('验证码有误');
            is_ajax = 0;
        }else{
            $('.code_msg').text('');
            is_ajax = 1;
        }

        /*************判断是否能被提交***********************************************/
        if(is_ajax === 0){
            return false;
        }
        $.ajax({
            url: "/user/signCode.html",
            type: "post",
            dataType: "json",
            data: "code="+user_code,
            success: function (data) {
                if (data.status) {
                    is_sign = 1;
                } else {
                    $('.code_msg').text('验证码有误');
                }
            }
        });
        /**************ajax注册用户*************************************************/
        if(is_sign === 0){
            return false;
        }
        $.ajax({
            url: "/user/sign.html",
            type: "post",
            dataType: "json",
            data: "user_name="+user_name+"&user_pwd="+user_pwd,
            success: function (data) {
                if (data.status) {
                    /******************5s 的跳转时间*******************************************/
                    var intervalid;
                    var i=5;
                    intervalid = setInterval(function(){
                        if(i===0){
                            clearInterval(intervalid);
                            window.location.href='/user/index.html';
                        }else{
                            $(".msg").attr("class","h");
                            $(".h > span").text("注册成功，系统会自动跳转登录页面("+i+"s)");
                        }
                        i--;
                    }, 1000);
                    return false;
                } else {
                    alert('false');return false;
                }

            }
        });
    });



});