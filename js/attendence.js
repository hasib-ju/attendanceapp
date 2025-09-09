
/*I will need this templete many times

$.ajax({
        url:"ajaxhandler/attendenceAjax.php",
        type:"POST",
        dataType:"json",
        data:{},
        beforeSend:function(e)
        {
        
        },
        success:function(rv)
        {

        },
        error:function(e)
        {

        }
    });

*/
function getSessionHTML(rv){
    let x= ``;
    x= `<option value=-1>SELECT ONE</option>`;
    let i =0;
    for(i=0;i<rv.length;i++){
        let cs =rv[i];
        x=x+`<option value=${cs['id']}>${cs['year']+" "+cs['term']}</option>`;
    }
    return x;
}

function loadSession(){
    // make an ajax call and load the session from DB
    $.ajax({
        url:"ajaxhandler/attendenceAjax.php",
        type:"POST",
        dataType:"json",
        data:{action:"getSession"},
        beforeSend:function(e)
        {

        },
        success:function(rv)
        {
            //alert(JSON.stringify(rv));
            //lets create html from rv dynamically
            let x=getSessionHTML(rv);
            $("#ddlclass").html(x);
        },
        error:function(e)
        {
            alert("OPPS!");
        }
    });
}

function getCourseCardHTML(classlist){
    let x=``;
    x=``;
    let i=0;
    for(i=0;i<classlist.length;i++){
        let cc=classlist[i];
        x=x+` <div class="classcard" data-classobject='${JSON.stringify(cc)}'>${cc['code']}</div>`;
    }
    return x;
}
function fetchFacultyCourses(facid,sessionid){
    //get all the courses taken by the faculty
    //for the selected session from DB by an ajax call
    $.ajax({
        url:"ajaxhandler/attendenceAjax.php",
        type:"POST",
        dataType:"json",
        data:{facid:facid, sessionid:sessionid,action:"getFacultyCourses"},
        beforeSend:function(e)
        {

        },
        success:function(rv)
        {
            // alert(JSON.stringify(rv));
            let x=getCourseCardHTML(rv);
            $("#classlistarea").html(x);
        },
        error:function(e)
        {

        }
    });

}

function getClassDetailsAreaHTML(classobject){
    let dobj=new Date();
    let ondate=`2025-09-01`;
    let year=dobj.getFullYear();
    let month=dobj.getMonth()+1;//return 0-12
    if(month<10){
        month="0"+month;
    }
    let day=dobj.getDate();//return 1-31
    if(day<10){
        day="0"+day;
    }
    ondate=year+"-"+month+"-"+day;
    // alert(ondate);
    let x=`<div class="classdetails">
                <div class="code-area">${classobject['code']}</div>
                <div class="title-area">${classobject['title']}</div>
                <div class="ondate-area">
                    <input type="date" value='${ondate}' id='dtpondate'>
                </div>
            </div>`;
    return x;   
}

function getStudentListHTML(studentlist){
    let x=`<div class="studentlist">
    <label>STUDENT LIST</label>
    </div>`;
    let i=0;
    for(i=0;i<studentlist.length;i++)
    {
        let cs=studentlist[i];
        let checkedState=``;
        let rowcolor='absentcolor';
        if(cs['ispresent']=='YES'){
            checkedState=`checked`;
            rowcolor='presentcolor'
        }
        //we want different color for checked and unchecked rows
        x=x+`<div class="studentdetails ${rowcolor}" id="student${cs['id']}">
                <div class="slno-area">${i+1}</div>
                <div class="rollno-area">${cs['roll_no']}</div>
                <div class="name-area">${cs['name']}</div>
                <div class="checkbox-area" data-studentid='${cs['id']}'>
                <input type="checkbox" class="cbpresent" data-studentid='${cs['id']}' ${checkedState}>
                <!--we will do it dynamically, but before that lets save few attendence-->

                </div>
            </div>`;
    }
    x=x+`<div class="reportsection">
                <button id="btnReport">REPORT</button>
            </div>
            <div id="divReport"></div>`;
            
    return x;

}

function fetchStudentList(sessionid,classid,facid,ondate){
    //make an ajax call get the data from DB
    $.ajax({
        url:"ajaxhandler/attendenceAjax.php",
        type:"POST",
        dataType:"json",
        data:{facid:facid, ondate:ondate, sessionid:sessionid, classid:classid, action:"getStudentList"},
        beforeSend:function(e)
        {

        },
        success:function(rv)
        {
            //alert(JSON.stringify(rv));
            //get the studentlist HTML
            let x= getStudentListHTML(rv);
            $("#studentlistarea").html(x);
        },
        error:function(e)
        {

        }
    });

}

function saveAttendence(studentid,courseid,facultyid,sessionid,ondate,ispresent){
    //make an ajax call and save the attendence of the student DB
    $.ajax({
        url:"ajaxhandler/attendenceAjax.php",
        type:"POST",
        dataType:"json",
        data:{studentid:studentid,courseid:courseid,facultyid:facultyid,sessionid:sessionid,ondate:ondate,ispresent:ispresent, action:"saveAttendence"},
        beforeSend:function(e)
        {

        },
        success:function(rv)
        {
            if(ispresent=="YES"){
                $("#student"+studentid).removeClass('absentcolor');
                $("#student"+studentid).addClass('presentcolor');
            }
            else{
                $("#student"+studentid).removeClass('presentcolor');
                $("#student"+studentid).addClass('absentcolor');
            }
            //alert(JSON.stringify(rv));
            // save the attendence now lets view them
        },
        error:function(e)
        {
            alert("OPPS!");
        }
    });
}

function downloadCSV(sessionid,classid,facid){
    //make an ajax call to fetch from server
    $.ajax({
        url:"ajaxhandler/attendenceAjax.php",
        type:"POST",
        dataType:"json",
        data:{sessionid:sessionid,classid:classid,facid:facid,action:"downloadReport"},
        beforeSend:function(e)
        {

        },
        success:function(rv)
        {
            //alert(JSON.stringify(rv));
            //lets download the file
            let x=`
            <object data=${rv['filename']} type="text/html" target="_parent"></object>
            `;
            $("#divReport").html(x);
        },
        error:function(e)
        {
            alert("OPPS!"); 
        }
    });

}

$(function(e){
    $(document).on("click","#btnLogout",function(ee){
        $.ajax(
            {
                url:"ajaxhandler/logoutAjax.php",
                type:"POST",
                dataType:"json",
                data:{id:1},
                beforeSend:function(e){
                    
                },
                success:function(e){
                    document.location.replace("login.php");
                },
                error:function(e){
                    alert("something went wrong!");
                }
            }
        )
    });
    loadSession();
    $(document).on("change","#ddlclass",function(e)
    {   
        $("#classlistarea").html(``);
        $("#classdetailsarea").html(``);
        $("#studentlistarea").html(``);
        let si=$("#ddlclass").val();
        if(si!=-1)
        {
            // alert(si);
            let sessionid =si;
            let facid=$("#hiddenFacID").val();
            fetchFacultyCourses(facid,sessionid);
        }
    });
    $(document).on("click",".classcard",function(e){
        let classobject=$(this).data('classobject');
        //remember the classid
        $("#hiddenSelectedCourseID").val(classobject['id']);
        //alert(JSON.stringify(classobject));
        let x= getClassDetailsAreaHTML(classobject);
        $("#classdetailsarea").html(x);

        //now fill the studentlist
        //for session and course
        let sessionid=$("#ddlclass").val();
        let classid = classobject['id'];
        let facid =$("#hiddenFacID").val();
        let ondate =$("#dtpondate").val();
        if(sessionid!=-1){
            //here want to fetch the studentlist along with the attendence on current date for that we have to pass facid and ondate to the following function
            fetchStudentList(sessionid,classid,facid,ondate);
        }
    });
    $(document).on("click",".cbpresent",function(e){
        
        let ispresent=this.checked; 
        //ispresent is a boolean value , convert it to YES NO
        //alert("OK");
        if(ispresent){
            ispresent="YES";
        }
        else{
            ispresent="NO";
        }
        //alert(ispresent);

        //if i want to save the the attendence need to know studentid, ispresent,courseid,facultyid, sessionid
        //date
        let studentid=$(this).data('studentid');
        let courseid=$("#hiddenSelectedCourseID").val();
        let facultyid=$("#hiddenFacID").val();
        let sessionid=$("#ddlclass").val();
        let ondate=$("#dtpondate").val();
        //alert(studentid+" "+courseid+" "+facultyid+" "+sessionid+" "+ondate);
        saveAttendence(studentid,courseid,facultyid,sessionid,ondate,ispresent);
    });
    $(document).on("change","#dtpondate", function(e){
        alert($("#dtpondate").val());
        //now load the studentlist on this day
        let sessionid=$("#ddlclass").val();
        let classid =$("#hiddenSelectedCourseID").val();
        let facid =$("#hiddenFacID").val();
        let ondate =$("#dtpondate").val();
        if(sessionid!=-1){
            //here want to fetch the studentlist along with the attendence on current date for that we have to pass facid and ondate to the following function
            fetchStudentList(sessionid,classid,facid,ondate);
        }
    });
    $(document).on("click","#btnReport",function(){
        alert("CLICKED");
        //send the session course gaculty to the server
        //and get the csv file name in return
        //server will create the csv file which will contain the report
        let sessionid=$("#ddlclass").val();
        let classid =$("#hiddenSelectedCourseID").val();
        let facid =$("#hiddenFacID").val();
        downloadCSV(sessionid,classid,facid);
    });
});