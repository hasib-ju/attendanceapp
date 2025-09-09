<?php
$path =$_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendenceapp/database/database.php";
function cleartable($dbo,$tabname)
{
    $c="delete from :tabname";
    $s=$dbo->conn->prepare($c);
    try
    {   
        $s->execute([":tabname"=>$tabname]);
    }
    catch(PDOException $oo)
    {

    }
}
$dbo =new Database();

$c= "create table student_details(
    id int auto_increment primary key,
    roll_no varchar(20) unique,
    name varchar(50)
)";
$s=$dbo->conn->prepare($c);
try{
    $s->execute();
    echo("<br>student_details created");
}
catch(PDOException $o){
    echo("<br>student_details not created");
}

$c = "create table course_details(

    id int auto_increment primary key,
    code varchar(25) unique,
    title varchar(25),
    credit int
)";
$s = $dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>course_details created");
}
catch(PDOException $o){
    echo("<br>course_details not created");
}


$c = "create table faculty_details(
    id int auto_increment primary key,
    user_name varchar(20) unique,
    name varchar(100),
    password varchar(50)
)";

$s= $dbo->conn->prepare($c);
try{
    $s->execute();
    echo("<br>faculty_details created");
}
catch(PDOException $o){
    echo("<br>faculty_details not created");
}


$c = "create table session_details(
    id int auto_increment primary key,
    year int,
    term varchar(50),
    unique(year,term)
)"; 

$s= $dbo->conn->prepare($c);

try{
    $s->execute();
    echo("<br>session_details created");
}

catch(PDOException $o){
    echo("<br>session_details not created");
}

$c = "create table course_registration(
    student_id int,
    course_id int,
    session_id int,
    primary key(student_id,course_id,session_id)
)";

$s =$dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br> course_registration created");
} catch (PDOException $o) {
    echo("<br>course_registration not created");
}


$c = "create table course_allotment(
    faculty_id int,
    course_id int,
    session_id int,
    primary key(faculty_id,course_id,session_id)
)";

$s =$dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br> course_allotment created");
} catch (PDOException $o) {
    echo("<br>course_allotment not created");
}

$c = "create table attendence_details(
    faculty_id int,
    course_id int,
    session_id int,
    student_id int,
    on_date date,
    status varchar(10),
    primary key(faculty_id,course_id,session_id,student_id,on_date)
)";

$s =$dbo->conn->prepare($c);
try {
    $s->execute();
    echo("<br>attendence_details created");
} catch (PDOException $o) {
    echo("<br>attendence_details not created");
}

$c = "insert into student_details
(id,roll_no,name)
values
(1,'42230100561','Md Emdadul Haque'),
(2,'42230100562','Md Mizanur Rahman'),
(3,'42230100563','Arif Khan joy'),
(4,'42230100564','Rafid Al Mahmud'),
(5,'42230100565','Asif hasan'),
(6,'42230100566','Mahmudul Haque'),
(7,'42230100567','Mahbub Hossain Rifat'),
(8,'42230100568','Riad Hossain'),
(9,'42230100569','Poly Rasel'),
(10,'42230100570','Nazmul hasan papon'),
(11,'42230100571','Shahriar sumon'),
(12,'42230100572','Hafiz rahman'),
(13,'42230100573','Nayem miah'),
(14,'42230100574','Mozammel haque'),
(15,'42230100575','Sakib AL Hasan'),
(16,'42230100576','Farzana akhter'),
(17,'42230100577','Nadim Mahmud'),
(18,'42230100578','Ummul Oara'),
(19,'42230100579','Arafat nayem'),
(20,'42230100580','Abu Rayhan'),
(21,'42230100581','Johirul islam'),
(22,'42230100582','Nahida sultana'),
(23,'42230100583','Zahid Hossain'),
(24,'42230100584','Md Uzzal'),
(25,'42230100585','Aminur Atik')
";

$s = $dbo->conn->prepare($c);
try {
  $s->execute();
} catch (PDOException $o) {
  echo ("<br>duplicate entry");
}

$c = "insert into faculty_details
(id,user_name,password,name)
values
(1,'tahsin','123','Tahsin Rahman'),
(2,'sanjida','123','Sanjida Akter'),
(3,'avishek','123','Avishek Das'),
(4,'promit','123','Promit Biswas'),
(5,'sezan','123','sezan Mahmud saikat'),
(6,'doha','123','Md samsudoha alam')";

$s = $dbo->conn->prepare($c);
try {
  $s->execute();
} catch (PDOException $o) {
  echo ("<br>duplicate entry");
}


$c = "insert into session_details
(id,year,term)
values
(1,2025,'SPRING SEMESTER'),
(2,2025,'AUTUMN SEMESTER')";


$s = $dbo->conn->prepare($c);
try {
  $s->execute();
} catch (PDOException $o) {
  echo ("<br>duplicate entry");
}

$c = "insert into course_details
(id,title,code,credit)
values
  (1,'VLSI Design','CSE321',3),
  (2,'Multimedia and graphics','CSE215',3),
  (3,'VLSI Design and Lab work','CSE112',1),
  (4,'Software development','CSE670',1),
  (5,'THEORY OF COMPUTATION ','CSE432',3),
  (6,'Multimedia Lab work','CSE673',1)";


  $s = $dbo->conn->prepare($c);
try {
  $s->execute();
} catch (PDOException $o) {
  echo ("<br>duplicate entry");
}

//if any records already there in a table delete them
cleartable($dbo,"course_registration");


$c = "insert into course_registration(student_id,course_id,session_id)
    values(:sid,:cid,:sessid)";
    $s = $dbo->conn->prepare($c);
//iterate all over the 5 students
//for each of them choose 3 random course from 1 to 6

for($i=1;$i<=25;$i++)
{
    for($j=0;$j<3;$j++)
    {
        $cid =rand(1,6);
        //insert the selected course into course regeistration table for
        //session 1 and student id $i

        try
        {
            $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>1]);
        }
        catch(PDOException $pe)
        {

        }

        //repeat for session 2

        $cid =rand(1,6);
        //insert the selected course into course regeistration table for
        //session 1 and student id $i

        try
        {
            $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>2]);
        }
        catch(PDOException $pe)
        {

        }
    }
}


//if any records already there in a table delete them
cleartable($dbo,"course_allotment");


$c = "insert into course_allotment(faculty_id,course_id,session_id)
    values(:fid,:cid,:sessid)";
    $s= $dbo->conn->prepare($c);
//iterate all over the 6 teachers
//for each of them choose 2 random course from 1 to 6

for($i=1;$i<=6;$i++)
{
    for($j=0;$j<2;$j++)
    {
        $cid =rand(1,6);
        //insert the selected course into course_allotment table for
        //session 1 and fac_id $i

        try
        {
            $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>1]);
        }
        catch(PDOException $pe)
        {

        }

        //repeat for session 2

        $cid =rand(1,6);
        //insert the selected course into course_allotment table for
        //session 1 and student id $i

        try
        {
            $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>2]);
        }
        catch(PDOException $pe)
        {

        }
    }
}
?>

