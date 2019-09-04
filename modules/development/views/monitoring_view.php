<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
echo $asset->compile_js();

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
    return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}
echo preg_replace_callback('/(<option[^<>]*>)(.*?)(<\/option>)/si', '__ommit_nbsp', $output);
?>

<script type="text/javascript">

var save_method;
var table;
var primary_key;
var base_url = '<?php echo base_url();?>';

$(document).ready(function(){    

    /*
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    */

    /*
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    */

});


function detail_pa(id){
    save_method = 'update';
    primary_key = id;
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('development/monitoring/plan_detail/')?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {	

        	var trHTML_1 = '';
        	var no = 1;
            var total_a = 0;
          	$.each(data.tab1, function (key,value) {
             	trHTML_1 += 
                '<tr>'+
                '<td class="text-center">'+no+'</td>'+
                '<td class="text-left">'+value.Description+'</td>'+
                '<td class="text-center">'+value.Bobot_A+'</td>'+
                '<td class="text-center">'+numberWithCommas(value.Plan_B)+'</td>'+
                '<td class="text-center">'+value.Achieve +'</td>'+
                '</tr>';
               no++;

               total_a += Number(value.Bobot_A);
          	});

            trHTML_1 += 
                '<tr>'+
                '<td class="text-center" colspan="2">Total</td>'+
                '<td class="text-center">'+total_a+'</td>'+                          
                '<td class="text-center" colspan="2"></td>'+
                '</tr>';


            $('#body_1').html(trHTML_1);


            var trHTML_2 = '';
        	var no = 1;
            var total_b = 0;
          	$.each(data.tab2, function (key,value) {
             	trHTML_2 += 
                '<tr>'+
                '<td class="text-center">'+no+'</td>'+
                '<td class="text-left">'+value.Description+'</td>'+
                '<td class="text-center">'+value.Bobot_A+'</td>'+
                '<td class="text-center">'+value.Achieve +'</td>'+
                '</tr>';
               no++;
               total_b += Number(value.Bobot_A);     
          	});

            trHTML_2 += 
                '<tr>'+
                '<td class="text-center" colspan="2">Total</td>'+
                '<td class="text-center">'+total_b+'</td>'+                          
                '<td class="text-center" colspan="1"></td>'+
                '</tr>';

            $('#body_2').html(trHTML_2);

            if (data.total_managing_people <= 0){
                $("#tab33").hide();
            }
            else{
                $("#tab33").show();
            }

            var trHTML_3 = '';
            var no = 1;
            var total_c = 0;
            $.each(data.tab3, function (key,value) {
                trHTML_3 += 
                '<tr>'+
                '<td class="text-center">'+no+'</td>'+
                '<td class="text-left">'+value.Description+'</td>'+
                '<td class="text-center">'+value.Bobot_A+'</td>'+
                '<td class="text-center">'+value.Achieve +'</td>'+
                '</tr>';
               no++;
               total_c += Number(value.Bobot_A);     
            });

             trHTML_3 += 
                '<tr>'+
                '<td class="text-center" colspan="2">Total</td>'+
                '<td class="text-center">'+total_c+'</td>'+                          
                '<td class="text-center" colspan="1"></td>'+
                '</tr>';

            $('#body_3').html(trHTML_3);

            $('#modal_form').modal({backdrop: 'static'});
            $('#modal_form').modal('show');            

            $('.modal-title').text(data.cTitle+' #'+data.KPIID);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(".");
}



</script>


<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center">PLAN</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="KPIID"/> 
                    <div class="form-body">

	                    <ul class="nav nav-tabs">
					    	<li class="active"><a data-toggle="tab" href="#tab1">A. RESULT</a></li>
					    	<li><a data-toggle="tab" href="#tab2">BI. PROCESS & CORE VALUES</a></li>
                            <li id="tab33"><a data-toggle="tab" href="#tab3">BII. MANAGING PEOPLE</a></li>
					  	</ul>
				  		<div class="tab-content">
						    <div id="tab1" class="tab-pane fade in active">

							    <div class="table-responsive" style="margin-top:20px;">
						            <table id="table1" class="table table-vcenter table-responsive table-condensed table-bordered table-striped table-hover display">
						                <thead>
						                    <tr>
						                        <th class="text-center" width="5%">No</th>
						                        <th class="text-center">Activity Plan</th>
                                                <th class="text-center">Bobot (%)</th>
                                                <th class="text-center">Plan</th>						                      
						                        <th class="text-center" width="10%">% Achievement</th>						         
						                    </tr>
						                </thead>
						                <tbody id="body_1">

						                </tbody>            
						            </table>
						        </div>						    
						      
						    </div>
						    <div id="tab2" class="tab-pane fade">						      
						      	<div class="table-responsive" style="margin-top:20px;">
						            <table id="table1" class="table table-vcenter table-responsive table-condensed table-bordered table-striped table-hover display">
						                <thead>
						                    <tr>
						                        <th class="text-center" width="5%">No</th>
						                        <th class="text-center">Activity Plan</th>
                                                <th class="text-center">Bobot (%)</th>						                      
						                        <th class="text-center" width="25%">% Achievement</th>
						                    </tr>
						                </thead>
						                <tbody id="body_2">

						                </tbody>             
						            </table>
						        </div>
						    </div>

                            <div id="tab3" class="tab-pane fade">                             
                                <div class="table-responsive" style="margin-top:20px;">
                                    <table id="table1" class="table table-vcenter table-responsive table-condensed table-bordered table-striped table-hover display">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="5%">No</th>
                                                <th class="text-center">Activity Plan</th>
                                                <th class="text-center">Bobot (%)</th>                                            
                                                <th class="text-center" width="25%">% Achievement</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_3">

                                        </tbody>             
                                    </table>
                                </div>
                            </div>          

				  		</div>     

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.container {
  width: 100%;
}
</style>