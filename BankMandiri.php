<style>

/* Bagian untuk tabel */	
table.tftable {
font-size:12px;
color:#333333;
border-width: 1px;
border-color:#000000;
border-collapse: collapse;

}

table.tftable th {
font-size:12px;
background-color:#CCCCCC;
border-width: 1px;
padding: 3px;
border-style: solid;
border-color: #999999;
text-align:center;

}
table.tftable tr {
background-color:#FFFFFF;
}
table.tftable td {
font-size:11px;
border-width: 1px;
padding: 2px;
border-style: solid;
border-color: #999999;
background-color:#FFFFFF;


}

#tfhover{
    border-collapse:collapse;
}
#tfhover tr {
    background-color:transparent;
}
#tfhover tr:hover td  {
  background-color:#FFFF33;
}
#tfhover tr td.link{
    background-color:transparent;
}

</style>
<?php

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


    $url 	= fungsiCurl('http://www.bankmandiri.co.id/resource/kurs.asp');
    $pecah 	= explode('<table class="tbl-view" cellpadding="0" cellspacing="0" border="0" width="100%">', $url);
    $pecah2 = explode ('</table>',$pecah[1]);
    $pecah3 = explode ('<th>&nbsp;</th>', $pecah2[0]);
    $pecah4 = explode ('<td>&nbsp;&nbsp;</td>',$pecah3[2]);

    $pecah17 = explode ('<td>&nbsp;</td>',$pecah2[1]);
    $pecah18 = explode (" ",$pecah2[1]);

    $table = '<table border="1" id="tfhover" class="table table-hover" >';
    $table .= '<tr><th colspan=4><div align=center>Nilai Tukar Rupiah (IDR) Sumber : 
    <a href="http://www.bankmandiri.co.id/resource/kurs.asp" target="_blank">www.bankmandiri.co.id</a></br>
    Last update : '.$pecah18[13].'-'.$pecah18[14].'-'.$pecah18[15].' Pukul: '.$pecah18[16].'&nbsp;'.$pecah18[17].'</div></th></tr>
        <tr>
            <th width=120>Description</th>
            <th width=50><div align=center>Symbol</div></th>
            <th width=80><div align=center>Buy</div></th>
            <th width=80><div align=center>Sale</div></th> 
        </tr>
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
    $table .= '</table>';
    echo $table;

    function table_to_query(){

        return table_to_query();

    }


?>
