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
        if($uName === null)
        {
            $("#uName-msg").text("用户名不能为空").css("color","red");
            return false;
        }
        if($uPwd === null)
        {
            $("#uPwd-msg").text("密码不能为空").css("color","red");
            return false;
        }
        if($uCode === null)
        {
            $("#uCode-msg").text("验证码不能为空").css("color","red");
            return false;
        }
        $.ajax({
            url:"/login/isUser",
            type:"post",
            dataType:"json",
            data:$formData,
            success:function(data){
                if(data.status)
                {
                    window.location.href="/";
                }else{
                    $("#uName-msg").html(data.msg);
                }
            }

        });




    });

    function getCodeImage(){
        $('#codeImage').attr("src","/login/adCode?num="+Math.random());
    }
});
