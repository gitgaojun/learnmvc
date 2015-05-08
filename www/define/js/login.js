/**
 * Created by jun90610@gmail.com on 2015/4/25.
 */

$(document).ready(function(){
    $(".login-sub").bind("click", function(){
        var $uName = $("#uName").val();
        var $uPwd = $("#uPwd").val();
        var $uCode = $("#uCode").val();
        var $isSub = 1;
        var $formData = $("#loginForm").serialize();


        $("#uName").focus();
        if($uName == null)
        {
            $("#uName-msg").html("用户名不能为空").css("color","red");
            return false;
        }
        if($uPwd == null)
        {
            $("#uPwd-msg").html("密码不能为空").css("color","red");
            return false;
        }
        if($uCode == null)
        {
            $("#uCode-msg").html("验证码不能为空").css("color","red");
            return false;
        }
        $.ajax({
            url:"/login/isUser",
            type:"post",
            dataType:"json",
            data:$formData,
            success:function(data){
                if(data.code = 1000)
                {
                    alert("你未注册，现在去注册");
                    window.location.href="/register/index";
                    return false;
                }
                if(data.status)
                {
                    window.location.href="/"
                }else{
                    $("#uName-msg").html(data.msg);
                }
            }

        });




    });

    function getCodeImage(){alert(23);
        $('#codeImage').attr("src","/login/adCode?num="+Math.random());
    }
});
