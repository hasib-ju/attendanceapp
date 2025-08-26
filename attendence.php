<?php 
session_start();
if(isset($_SESSION["current_user"]))
{

}
else{
    header("location:"."/attendenceapp/login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/attendence.css">
    <title>Document</title>
</head>
<body>
   <!-- <h1>Hello</h1>
    <button id="btnLogout">LOGOUT</button>-->

    <div class="page">
        <div class="header-area">
            <div class="logo-area"><h1 class="logo">ATTENDANCE APP</h1></div>
            <div class="logout-area"><button class="btnlogout">LOGOUT</button></div>
        </div>
        <div class="session-area">
            <div class="label-area"><label>SESSION</label></div>
            <div class="dropdown-area">
                <select class="ddlclass">
                    <option>SELECT ONE</option>
                    <option>2025 AUTUMN</option>
                    <option>2025 SPRING</option>
                </select>
            </div>
        </div>
        <div class="classlist-area">3</div>
        <div class="classdetails-area">4</div>
        <div class="studentlist-area">5</div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/logout.js"></script>
</body>
</html>