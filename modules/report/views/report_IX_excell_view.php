<style type="text/css">
      table.ReportTable {
      font-family: "Times New Roman", Times, serif;
      border: 2px solid #A40808;
      background-color: #EEE7DB;
      width: 100%;
      text-align: left;
      border-collapse: collapse;
    }
    table.ReportTable td, table.ReportTable th {
      border: 1px solid #AAAAAA;
      padding: 3px 2px;
    }
    table.ReportTable tbody td {
      font-size: 14px;
    }
    table.ReportTable thead {
      background: #A40808;
    }
    table.ReportTable thead th {
      font-size: 15px;
      font-weight: bold;
      color: black;
      text-align: center;
      border: 2px solid #A40808;      
    }
    table.ReportTable thead th:first-child {
      border-left: none;
    }

</style>
<?php 

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namaexcell.".xls");

echo $htmldata;
?>