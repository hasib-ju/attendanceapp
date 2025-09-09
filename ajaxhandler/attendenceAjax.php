<?php 
$path=$_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendenceapp/database/database.php";
require_once $path."/attendenceapp/database/sessionDetails.php";
require_once $path."/attendenceapp/database/facultyDetails.php";
require_once $path."/attendenceapp/database/courseRegistrationDetails.php";
require_once $path."/attendenceapp/database/attendenceDetails.php";

function createCSVReport($list,$filename)
{   
    $error=0;
    $path=$_SERVER['DOCUMENT_ROOT'];
    $finalFileName=$path.$filename;
    try{
        $fp=fopen($finalFileName,"w");
        foreach($list as $line){
            fputcsv($fp,$line);
        }
    }
    catch(Exception $e){
        $error=1;
    }

}
if (isset($_REQUEST['action']))
{
    $action=$_REQUEST['action'];
    if($action=="getSession")
    {
        //fetch the session from DB
        //and return to client
        $dbo=new Database();
        $sobj=new sessionDetails();
        $rv=$sobj->getSessions($dbo);
        //getSessions
        //$rv=["2025 SPRING", "2025 AUTUMN"];
        echo json_encode($rv);
    }
    //data:{facid:facid, sessionid:sessionid,action:"getFacultyCourses"}
    if($action=="getFacultyCourses")
    {   
        //fetch the courses taken by fac in sess
        $facid=$_POST['facid'];
        $sessionid=$_POST['sessionid'];
        $dbo=new Database();
        $fo=new faculty_details();
        $rv=$fo->getCoursesInASession($dbo,$sessionid,$facid);
        //$rv=[];
        echo json_encode($rv);
    }
    //data:{facid;facid, ondate:ondate sessionid:sessionid, classid:classid, action:"getStudentList"},
    if($action=="getStudentList")
    {   
        //fetch the courses taken by fac in sess
        $classid=$_POST['classid'];
        $sessionid=$_POST['sessionid'];
        $facid=$_POST['facid'];
        $ondate=$_POST['ondate'];
        $dbo=new Database();
        $crgo=new courseRegistrationDetails();
        $allstudents=$crgo->getRegisteredStudents($dbo,$sessionid,$classid);
        //lets get the attendence of these students on that day by the facid
        $ado=new attendenceDetails();
        $presentStudents=$ado->getpresentListOfAClassByAFacOnDate($dbo,$sessionid,$classid,$facid,$ondate);

        //lets iterate offer all students and mark them present if in presentlist

        for($i=0;$i<count($allstudents);$i++){
            $allstudents[$i]['ispresent']='NO';//by default no
            for($j=0;$j<count($presentStudents);$j++){
                if($allstudents[$i]['id']==$presentStudents[$j]['student_id']){
                     $allstudents[$i]['ispresent']='YES';
                     break;
                }
            }
        }
        //$rv=[];
        echo json_encode($allstudents);
    }
    // data:{studentid:studentid,courseid:courseid,
    // facultyid:facultyid,sessionid:sessionid,
    // ondate:ondate,action:"saveAttendence"},
    if($action=="saveAttendence")
    {   
        //fetch the courses taken by fac in sess
        $courseid=$_POST['courseid'];
        $sessionid=$_POST['sessionid'];
        $studentid=$_POST['studentid'];
        $facultyid=$_POST['facultyid'];
        $ondate=$_POST['ondate'];
        $status=$_POST['ispresent'];
        $dbo=new Database();
        $ado=new attendenceDetails();
        $rv=$ado->saveAttendence($dbo,$sessionid,$courseid,$facultyid,$studentid,$ondate,$status);
        //$rv=[];
        echo json_encode($rv);
    }
   // data:{sessionid:sessionid,classid:classid,facid:facid,action:"downloadReport"},
   if($action=="downloadReport")
    {   
        //fetch the courses taken by fac in sess
        $courseid=$_POST['classid'];
        $sessionid=$_POST['sessionid'];
        $facultyid=$_POST['facid'];
        $dbo=new Database();
        $ado=new attendenceDetails();
        //$rv=$ado->saveAttendence($dbo,$sessionid,$courseid,$facultyid,$studentid,$ondate,$status);
        //$rv=[];
        //lets create a dummy csv
        // we need an array of arrays each array is a line
        $list=[
            [1,"MCJ21000",20.00],
            [2,"BCT21000",30.00],
            [3,"BTT21000",40.00]   
        ];
        $list=$ado->getAttendenceReport($dbo,$sessionid,$courseid,$facultyid);
        //now this list we have to generate the actual one
        $filename="/attendenceapp/report.csv";
        $rv=["filename"=>$filename];
        createCSVReport($list,$filename);
        echo json_encode($rv);
    }
}

?>