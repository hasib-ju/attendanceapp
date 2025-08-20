<?php
$path =$_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendenceapp/database/database.php";
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
    code varchar(20) unique,
    title varchar(20),
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
(1,'42230100567','Md Emdadul Haque'),
(2,'42230100568','Md Mizanur Rahman'),
(3,'42230100656','Arif Khan joy'),
(4,'42230100557','Rafid Al Mahmud'),
(5,'CSB21005','Asif hasan')
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
(5,'mriganka','123','Mriganka Sekhar'),
(6,'manooj','123','Manooj Hazarika')";

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
  (1,'VLSI Design','CO321',3),
  (2,'Multimedia and graphics','CO215',3),
  (3,'VLSI Design and Lab work','CS112',1),
  (4,'Software development','CS670',1),
  (5,'THEORY OF COMPUTATION ','CO432',3),
  (6,'Multimedia Lab work','CS673',1)";


  $s = $dbo->conn->prepare($c);
try {
  $s->execute();
} catch (PDOException $o) {
  echo ("<br>duplicate entry");
}

?>

