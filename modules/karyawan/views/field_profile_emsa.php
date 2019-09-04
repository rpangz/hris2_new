<?php
    $record_index = 0;
    $Max =4;
    $softwarestd    = $options[softwarestd];
    $softwarenonstd = $options[softwarenonstd];
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'); ?>" />
<style type="text/css">
    
    #md_table_citizen {
        /*width:100%;*/
    }

    #md_table_citizen input[type="text"]{
        max-width:600px;
    }

    #md_table_citizen .chzn-drop input[type="text"]{
        max-width:240px;
    }
    #md_table_citizen th:last-child, #md_table_citizen td:last-child{
        width: 60px;
    }

    #md_field_citizen_col_MemberStatus{
        width:10px;
       
    }


    table.comicGreen {
      font-family: "Times New Roman", cursive, sans-serif;
      border: 2px solid #4F7849;
      background-color: #EEEEEE;

      text-align: left;
      border-collapse: collapse;
    }
    table.comicGreen td, table.comicGreen th {
      border: 1px solid #4F7849;
      padding: 3px 2px;
    }
    table.comicGreen tbody td {
      font-size: 13px;
      font-weight: bold;
      color: #4F7849;
    }
    table.comicGreen thead {
      background: #4F7849;
      background: -moz-linear-gradient(top, #7b9a76 0%, #60855b 66%, #4F7849 100%);
      background: -webkit-linear-gradient(top, #7b9a76 0%, #60855b 66%, #4F7849 100%);
      background: linear-gradient(to bottom, #7b9a76 0%, #60855b 66%, #4F7849 100%);
      border-bottom: 1px solid #444444;
    }
    table.comicGreen thead th {
      font-size: 14px;
      font-weight: bold;
      color: #FFFFFF;
      text-align: center;
      border-left: 2px solid #D0E4F5;
    }
    table.comicGreen thead th:first-child {
      border-left: none;
    }
    

</style>

<b> HARDWARE : </b>
<div id="md_table_citizen_container">
        <table class="comicGreen">
            <thead>
                <tr>
                    <th style="width:15%;">New Tagging</th>
                    <th style="width:15%;">Old Tagging</th>
                    <th style="width:35%;">Brand Name</th>
                    <th style="width:30%;">Spesification</th>                                                    
                </tr>
            </thead>                    
            <tbody>
                <tr>
                    <td><?php echo $options[Tagging]; ?></td>
                    <td><?php echo $options[TaggingOld]; ?></td>
                    <td><?php echo $options[Item]; ?></td>
                    <td><?php echo $options[Spesification]; ?></td>
                </tr>                    
            </tbody>
        </table>
        <br>

        <b> SOFTWARE : </b>
        <div style="box-shadow: 10px 10px 5px grey;background-color:LightSalmon; padding: 10px">                  
          <tr>
            <td>
            <u><b>Software Standard : </b></u>
            <li>
               <?php
                if(count($softwarestd)==0) {
                    echo "<ul> - NO DATA - </ul>";
                } else {
                    foreach ($softwarestd as $row)
                    {
                       echo "<ul> - ".$row."</ul>"; 
                    }    
                }            
                ?> 
            </li>
            </td>
          </tr>
          <br>
          <tr>
            <td>
            <u><b>Software Non Standard : </b></u>
            <li>
                <?php
                if(count($softwarenonstd)==0) {
                    echo "<ul> - NO DATA - </ul>";
                } else {
                    foreach ($softwarenonstd as $row)
                    {
                       echo "<ul> - ".$row."</ul>"; 
                    }    
                }            
                ?>                
            </li>
            </td>
          </tr>

        </div>


    <br />

</div>

