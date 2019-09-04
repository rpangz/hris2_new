<?php 
$hostName = '172.17.0.16';
$userName = 'operator';
$passWord = '$M15.apps@admin16';
$dataBase = 'hris2';

/*
$query = "SELECT CertNIK FROM tbl_profile_certification_temp LIMIT 1";
//$result = mysql_fetch_array($query); 

$result = mysql_query($query);

$result_array = array();
while($row = mysql_fetch_assoc($result)){
    $result_array['dom'] = $row['CertNIK'];
}

print_r($result_array);
*/
/*

$before = array('1', '1', '0', '0', '1', '0' ) ;
    $after =  array('0', '0', 'A', '0', '1', '0' ) ;

    $new_array= array_diff_assoc($before,$after);

    print_r ($new_array) ;




$query 		= mysql_query('SELECT * from tbl_profile_certification_temp');
$emparray 	= array();
    while($row =mysql_fetch_array($query)){
        $emparray[] = $row;
    }

    echo $emparray;

*/

    $tb_dummy = array(
			array('profile_workexperience','WorkExpStatus','WorkExpApv','WorkExpProcessId'),
			array('profile_education','EduStatus','EduApv','EduProcessId'),
			array('profile_training','TrainingStatus','TrainingApv','TrainingProcessId'),
			array('profile_technicalskill','TechnicalSkillStatus','TechnicalSkillApv','TechnicalSkillProcessId'),
			array('profile_certification','CertStatus','CertApv','CertProcessId'),
			array('profile_projecthistory','ProjectStatus','ProjectApv','ProjectProcessId'),
			array('profile_files','file_status','file_apv','file_process_id')
        );


   for ($row = 0; $row <  7; $row++) {
   //echo "<p><b>Table Name $row: ".$tb_dummy[$row][1]."</b></p>";

   		echo $table_name_ori     = $tb_dummy[$row][0].',';
   		echo $Status 			= $tb_dummy[$row][1].',';
        echo $Approval 			= $tb_dummy[$row][2].',';
        echo $ProcessId 		= $tb_dummy[$row][3].'<br/>';

  
}

// /echo $arrayvalue[0][0];
/*
  $cars = array
   (
   array("Volvo",22,18),
   array("BMW",15,13),
   array("Saab",5,2),
   array("Land Rover",17,15)
   );
  
echo $cars[0][0].": In stock: ".$cars[0][1].", sold: ".$cars[0][2].".<br>";
echo $cars[1][0].": In stock: ".$cars[1][1].", sold: ".$cars[1][2].".<br>";
echo $cars[2][0].": In stock: ".$cars[2][1].", sold: ".$cars[2][2].".<br>";
echo $cars[3][0].": In stock: ".$cars[3][1].", sold: ".$cars[3][2].".<br>";


$cars = array
   (
   array("Volvo",22,18),
   array("BMW",15,13),
   array("Saab",5,2),
   array("Land Rover",17,15)
   );
    
for ($row = 0; $row <  4; $row++) {
   echo "<p><b>Row number $row</b></p>";
   echo "<ul>";
   for ($col = 0; $col <  3; $col++) {
     //echo "<li>".$cars[$row][$col]."</li>";
   }

   echo "<li>".$cars[$row][1]."</li>";
   echo "</ul>";
}
*/
?>