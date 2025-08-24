
function tryLogin()
{
    let un =$("#txtUsername").val();
    let pw =$("#txtPassword").val();
    if(un.trim()!=="" && pw.trim()!=="")
    {
        //make an ajax call
        $.ajax({
            url:"ajaxhandler/loginAjax.php",
            type:"POST",
            dataType:"json",
            data:{user_name:un,password:pw,action:"verifyUser"},
            beforeSend:function(){
                //if you want to do something just
                //before making the call
                // alert("HELLO");
            },
            success:function(rv){
                //if the ajax call was successful 
                //result will be rv
                // alert(JSON.stringify(rv));
                if(rv['status']=="ALL OK")
                {
                    document.location.replace("attendence.php");
                }
                else{
                    // alert(rv['status']);
                    $("#diverror").addClass("applyerrordiv");
                    $("#errormessage").addClass("errormessage");
                }
            },
            error:function(){
                alert("opps something went wrong");
            },
        });
    }

}


//do everything only when the document is loaded


$(function(e){
    //capture the keyupp event
    $(document).on("keyup","input",function(e){
        let un = $("#txtUsername").val();
        let pw = $("#txtPassword").val();

        if(un.trim()!=="" && pw.trim()!==""){
                $("#btnLogin").removeClass("inactivecolor");
                $("#btnLogin").addClass("activecolor");
        }
        else{
                $("#btnLogin").removeClass("activecolor");
                $("#btnLogin").addClass("inactivecolor");
        }
    });

    $(document).on("click","#btnLogin",function(e){
        tryLogin();
    })
});
