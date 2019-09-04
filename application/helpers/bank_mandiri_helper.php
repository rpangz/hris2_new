<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(0);
// isi mandiri.php
function fungsiCurl($url){
    $data = curl_init();	
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_URL, $url);
         curl_setopt($data, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
     $hasil = curl_exec($data);
     curl_close($data);
     return $hasil;
}

function table_to_query(){

    $url 	= fungsiCurl('http://www.bankmandiri.co.id/resource/kurs.asp');
    $pecah 	= explode ('<table class="tbl-view" cellpadding="0" cellspacing="0" border="0" width="100%">', $url);
    $pecah2 = explode ('</table>', $pecah[1]);
    $pecah3 = explode ('<th>&nbsp;</th>', $pecah2[0]);
    $pecah4 = explode ('<td>&nbsp;&nbsp;</td>', $pecah3[2]);

    $pecah17 = explode ('<td>&nbsp;</td>',$pecah2[1]);
$pecah18 = explode (" ",$pecah2[1]);
$table = '<table width="100%" border="0" id="tfhover" class="table table-hover table-striped table-bordered" >';
    $table .= '<thead><tr><th colspan="4"><div align="center">Nilai Tukar Rupiah (IDR) Sumber : 
    <a href="http://www.bankmandiri.co.id/resource/kurs.asp" target="_blank">www.bankmandiri.co.id</a>
    Last update : '.$pecah18[13].'-'.$pecah18[14].'-'.$pecah18[15].' Pukul: '.$pecah18[16].'&nbsp;'.$pecah18[17].'</div></th></tr>
        <tr>
            <th width="40%" class="text-left">Description</th>
            <th width="20%" class="text-left">Symbol</th>
            <th width="20%" class="text-right">Buy</th>
            <th width="20%" class="text-right">Sale</th> 
        </tr></thead><tbody>
        ';


    $table .= $pecah4[0];
    $table .= $pecah4[1];
    $table .= $pecah4[2];
    $table .= $pecah4[3];
    $table .= $pecah4[4];
    $table .= $pecah4[5];
    $table .= $pecah4[6];
    $table .= $pecah4[7];
    $table .= $pecah4[8];
    $table .= $pecah4[9];
    $table .= $pecah4[10];
    $table .= $pecah4[11];
    $table .= $pecah4[12];
    $table .= $pecah4[13];
    $table .= $pecah4[14];
    $table .= $pecah4[15];
    $table .= $pecah4[16];
    $table .= $pecah4[17];
    $table .= $pecah4[18];
    $table .= $pecah4[19];
    $table .= $pecah4[20];
    $table .= $pecah4[21];
    $table .= $pecah4[28];
    $table .= $pecah4[29];
    $table .= '</tbody></table>';
    
    //return $table;

    //preg_match_all('/<td>(\s*?)(.*?)(\s*?)(.*?)(\s*?)<\/td>/', $table, $matches);

//$a = "<table>\n";
//$a = "";
/*
$array = array();



		foreach($matches[0] as $row):
            $array[] = array("Description" => $row, "Symbol" =>$row);
        endforeach;
        
        echo json_encode($array);
        exit;

*/

//$a .= '</table>';


//return $arr;

$dom = new DOMDocument();
$dom->loadHTML($table);

	// Initialize arrays
	$thArray = $tdArray = $array = array();

	// Get all Table Headers and throw them in an array
	$th = $dom->getElementsByTagName('tbody');
	foreach ( $th as $th ) {
		$thArray[] = $th->nodeValue;
	}
	// count the array for future comparison
	$count = count($thArray);
	
	/* Example:
		Array
		(
			[0] => Unit Type
			[1] => Availability
			[2] => Rates
		)
	*/

	// Get all the Table Cells, but if it matches the same count as the Table Header array, create a new array row
	$td = $dom->getElementsByTagName('td');
	$i = 0;
	foreach( $td as $td ) {
		if(count($tdArray[$i]) != $count) {
			$tdArray[$i][] = $td->nodeValue;
		} else {
			$i++;
			$tdArray[$i][] = $td->nodeValue;
		}
	}

	/* Example
		Array
		(
			[0] => Array
				(
				    [0] => One Bedroom
				    [1] => Call for Availability
				    [2] => hello
				)

			[1] => Array
				(
				    [0] => One Living Room
				    [1] => Call not for Availability
				    [2] => hello
				)

			[2] => Array
				(
				    [0] => Two Bedrooms
				    [1] => Not Availabile
				    [2] => Good Bye
				)

		)
	*/	

	// Make a new array based from the tdArray, to match with the thArray's keys 
	for( $j = 0; $j < sizeof($thArray); ++$j) {
		foreach( $tdArray as $k=>$v ) {
			$array[$j][] = $v[$j];
		}
	}
	
	/* Example:
		Array
		(
			[0] => Array
				(
				    [0] => One Bedroom
				    [1] => One Living Room
				    [2] => Two Bedrooms
				)

			[1] => Array
				(
				    [0] => Call for Availability
				    [1] => Call not for Availability
				    [2] => Not Availabile
				)

			[2] => Array
				(
				    [0] => hello
				    [1] => hello
				    [2] => Good Bye
				)

		)
	*/	

	//echo '<pre>';
		//print_r(array_combine($thArray, $array));
	//echo '</pre>';

	    


		foreach($array as $row):
            //$array = $row[15];

        	$array = array("Description" => $row[0], "Symbol" => $row[1]);

        endforeach;     
        
        echo json_encode($array);
        exit;


        
  
       



}