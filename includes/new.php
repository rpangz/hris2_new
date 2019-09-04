<?php

$hostName = '172.17.0.16';
$userName = 'operator';
$passWord = '$M15.apps@admin16';
$dataBase = 'hris2';


mysql_connect($hostName, $userName, $passWord);
mysql_select_db($dataBase);

$result = mysql_query("SELECT * FROM `tbl_profile_certification` WHERE CertNIK='4833' ORDER BY CertId ASC");


        $total  = mysql_num_rows($result);

        //$mama = mysql_query("show index from tbl_profile_certification_temp where Key_name = 'PRIMARY'");
        //$data2 = mysql_fetch_array($mama)

    //echo $data2['Column_name'];
        $i = 0;



      // while ($wbx = mysql_fetch_assoc($result, MYSQL_ASSOC)){
        $no=1;
        while($data = mysql_fetch_array($result)){
          if ($data['Key'] == 'PRI'){

            echo $data['Key'];
        }


          $lines[$data['Key']] = $data['Field']; 


          $id = $data['CertId'];
          $table_name_ori  = 'tbl_profile_certification';
          $table_name_temp = 'tbl_profile_certification_temp';
          $nik             = 4833;
          $primary_column  = 'CertId';

          //add_rows($id,$table_name_ori,$table_name_temp,$nik,$primary_column);
         

          
          $no++;               

      }

      echo $PRIKEYID = $lines['PRI'];  

function add_rows($id,$table_name_ori,$table_name_temp,$nik,$primary_column){

$sql = mysql_query("SELECT * FROM $table_name_ori WHERE $primary_column ='$id'");

                  while ($row = mysql_fetch_assoc($sql)){
                      foreach ($row as $field => $value){

                        if ($field != "$primary_column"){
                          $fields .= "$field, ";
                          $values .= "'$value', ";
                        }
                      }
                  
                  $fields = preg_replace('/, $/', '', $fields);
                  $values = preg_replace('/, $/', '', $values);

                    

                    $sql = "INSERT INTO $table_name_temp ($fields) VALUES ($values)";
                    mysql_query($sql);

                                    

                  }

}

/*
foreach($insert_records as $insert_record){       
            $data = array();
            foreach($insert_record['data'] as $key=>$value){               
                if(in_array($key, $set_column_names)){
                    $data[$key] = implode(',', $value);
                }else if(in_array($key, $real_column_names)){
                    $data[$key] = $value;
                }
            }
            $data['TechnicalSkillNIK'] = $primary_key;

            //$this->db->insert($this->cms_complete_table_name('profile_technicalskill'), $data);
            //$detail_primary_key = $this->db->insert_id(); 

            }      

*/



$res = mysql_query("SHOW COLUMNS FROM tbl_profile_certification");

//$row = mysql_fetch_assoc($res);

//echo 'Field with primary key = '.$row['Field'];


      
$qColumnNames = mysql_query("SHOW COLUMNS FROM tbl_profile_certification");
$numColumns = mysql_num_rows($qColumnNames);
$x = 0;
while ($x < $numColumns)
{
    $colname = mysql_fetch_row($qColumnNames);
    $col[$x] = $colname[0];
    $x++;
}

//print_r($col);

$array = array_values($col);
echo $array[1]; //bin

?>