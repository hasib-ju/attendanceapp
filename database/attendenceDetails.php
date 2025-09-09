<?php 
$path=$_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendenceapp/database/database.php";
class attendenceDetails{
    public function saveAttendence($dbo,$session,$course,$fac,$student,$ondate,$status){
    $rv=[-1];
    $c="insert into attendence_details
    (session_id,course_id,faculty_id,student_id,on_date,status)
    values
    (:session_id,:course_id,:faculty_id,:student_id,:on_date,:status)"; 
    $s=$dbo->conn->prepare($c);
    try{
        $s->execute([":session_id"=>$session,":course_id"=>$course,":faculty_id"=>$fac,":student_id"=>$student,":on_date"=>$ondate,":status"=>$status]);
        $s->execute();
        $rv=[1];
    }
    catch(Exception $e){
        //$rv=[$e->getmessage()];
        //it might happen the entry is there we just have to set re set status
    $c="update attendence_details set status=:status
    where 
    session_id=:session_id and course_id=:course_id and faculty_id=:faculty_id and student_id=:student_id and on_date=:on_date";
    $s=$dbo->conn->prepare($c);
    try{
        $s->execute([":session_id"=>$session,":course_id"=>$course,":faculty_id"=>$fac,":student_id"=>$student,":on_date"=>$ondate,":status"=>$status]);
        $s->execute();
        $rv=[1]; 
    }
    catch(Exception $ee){
        $rv=[$e->getmessage()];
    }
    }
    return $rv;
    }

    public function getpresentListOfAClassByAFacOnDate($dbo,$session,$course,$fac,$ondate)
    {   
        $rv=[];
        $c="select student_id from attendence_details
        where session_id=:session_id and course_id=:course_id and faculty_id=:faculty_id and on_date=:on_date and status='YES'";
        $s=$dbo->conn->prepare($c);
        try{
            $s->execute([":session_id"=>$session,":course_id"=>$course,":faculty_id"=>$fac,":on_date"=>$ondate]);
            $rv=$s->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){

        }
        return $rv;
    }

    public function getAttendenceReport($dbo,$session,$course,$fac)
    {   
        $report=[];
        $sessionName='';
        $facname='';
        $courseName='';
        //get session faculty and course name
        $c="select * from session_details where id=:id";
        $s=$dbo->conn->prepare($c);
        try{
            $s->execute([":id"=>$session]);
            $sd=$s->fetchAll(PDO::FETCH_ASSOC)[0];
            $sessionName=$sd['year']." ".$sd['term'];
        }
        catch(Exception $e){

        }

        $c="select * from faculty_details where id=:id";
        $s=$dbo->conn->prepare($c);
        try{
            $s->execute([":id"=>$fac]);
            $sd=$s->fetchAll(PDO::FETCH_ASSOC)[0];
            $facname=$sd['name'];
        }
        catch(Exception $e){

        }

        $c="select * from course_details where id=:id";
        $s=$dbo->conn->prepare($c);
        try{
            $s->execute([":id"=>$course]);
            $sd=$s->fetchAll(PDO::FETCH_ASSOC)[0];
            $courseName=$sd['code']."-".$sd['title'];
        }
        catch(Exception $e){

        }

        array_push($report,["Session:",$sessionName]);
        array_push($report,["Course:",$courseName]);
        array_push($report,["Faculty:",$facname]);

        //first get the total number of classes by the faculty
        $total =0;
        $start='';
        $end='';
        $c="SELECT DISTINCT on_date FROM attendence_details WHERE session_id=:session_id AND course_id=:course_id AND faculty_id=:faculty_id order by on_date";
        $s=$dbo->conn->prepare($c);
        try{
            $s->execute([":session_id"=>$session,":course_id"=>$course,":faculty_id"=>$fac]);
            $rv=$s->fetchAll(PDO::FETCH_ASSOC);
            $total=count($rv);
            if($total>0)
            {
                $start=$rv[0]['on_date'];
                $end=$rv[$total-1]['on_date'];
            }
        }
        catch(Exception $ee){

        }
        
        array_push($report,["total",$total]);
        array_push($report,["start",$start]);
        array_push($report,["end",$end]);
        
        //get the number of attended classes for each registered student


        $rv=[];
        $c="SELECT rsd.id, rsd.roll_no, rsd.name,COUNT(ad.on_date) as attended FROM (SELECT sd.id, sd.roll_no, sd.name, crd.session_id, crd.course_id FROM student_details as sd, course_registration as crd WHERE sd.id=crd.student_id AND crd.session_id=:session_id AND crd.course_id=:course_id) AS rsd LEFT JOIN attendence_details as ad ON rsd.id=ad.student_id AND rsd.session_id=ad.session_id AND rsd.course_id=ad.course_id AND status='YES' and ad.faculty_id=:faculty_id GROUP BY rsd.id";
        $s=$dbo->conn->prepare($c);
        try{
            $s->execute([":session_id"=>$session,":course_id"=>$course,":faculty_id"=>$fac]);
            $rv=$s->fetchAll(PDO::FETCH_ASSOC);
        
        }
        catch(Exception $ee){

        }
        //compute the percent
        for($i=0;$i<count($rv);$i++)
        {
            $rv[$i]['percent']=0.00;
            if($total>0)
            {
                $rv[$i]['percent']=round($rv[$i]['attended']/$total*100.0,2);
            }
        }
        array_push($report,["slno","rollno","name","attended","percent"]);
        $report=array_merge($report,$rv);
        

        //return the result
        return $report;

    }
    
}

?>