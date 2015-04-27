/**
 * Created by jun90610@gmail.com on 2015/4/25.
 */

$(document).ready(function(){
    $("login-sub").bind("click", function(){
        var $uName = $(".uName").val();
        var $uPwd = $(".uPwd").val();
        var $uCode = $(".uCode").val();

        $("#uName").focus();

    });
});
