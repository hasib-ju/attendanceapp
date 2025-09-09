<?php 
session_start();
if(isset($_SESSION["current_user"]))
{
    $facid=$_SESSION["current_user"];
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
            <div class="logo-area"><h2 class="logo">ATTENDANCE APP</h2></div>
            <div class="logout-area"><button class="btnlogout" id="btnLogout">LOGOUT</button></div>
        </div>
        <div class="session-area">
            <div class="label-area"><label>SESSION</label></div>
            <div class="dropdown-area">
                <select class="ddlclass" id="ddlclass">
                    <!-- <option>SELECT ONE</option>
                    <option>2025 AUTUMN</option>
                    <option>2025 SPRING</option> -->
                </select>
            </div>
        </div>
        <div class="classlist-area" id="classlistarea">
            <!-- <div class="classcard">CSE321</div>
            <div class="classcard">CSE321</div>
            <div class="classcard">CSE321</div>
            <div class="classcard">CSE321</div>
            <div class="classcard">CSE321</div>
            <div class="classcard">CSE321</div> -->
        </div>
        <div class="classdetails-area" id="classdetailsarea">
            <!-- <div class="classdetails">
                <div class="code-area">CSE321</div>
                <div class="title-area">Software Development</div>
                <div class="ondate-area">
                    <input type="date">
                </div>
            </div> -->
        </div>
        <div class="studentlist-area" id=studentlistarea>
            <!-- <div class="studentlist"><label>STUDENT LIST</label></div>
            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">42230100561</div>
                <div class="name-area">Md Emdadul Haque</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>
            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">42230100561</div>
                <div class="name-area">Md Emdadul Haque</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>
            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">42230100561</div>
                <div class="name-area">Md Emdadul Haque</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>
            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">42230100561</div>
                <div class="name-area">Md Emdadul Haque</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>
            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">42230100561</div>
                <div class="name-area">Md Emdadul Haque</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>
            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">42230100561</div>
                <div class="name-area">Md Emdadul Haque</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div> -->

            
        </div> 
    </div>
    <input type="hidden" id="hiddenFacID" value=<?php echo($facid)?>>
    <input type="hidden" id="hiddenSelectedCourseID" value=-1>
    <script src="js/jquery.js"></script>
    <script src="js/attendence.js"></script>

    <!-- renamed the files just to keep the filenames similar nothing more than that -->
</body>
</html>