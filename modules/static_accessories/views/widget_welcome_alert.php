<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type ="text/javascript">
    var content  = '<?php echo $content;?>';
    var site_url = '<?php echo site_url()?>';

    $(document).ready(function(){        

        function ___alignModalToCenterOfScreen(){
            var modalDialog = $('#___modal_welcome_alert').find(".modal-dialog");        
            // Applying the top margin on modal dialog to align it vertically center
            modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        // Align modal when it is displayed
        $("#___modal_welcome_alert.modal").on("shown.bs.modal",___alignModalToCenterOfScreen);    
        // Align modal when user resize the window
        $(window).on("resize", function(){
            $("#___modal_welcome_alert .modal:visible").each(___alignModalToCenterOfScreen);
        }); 

        __load_welcome_alert();

    });

    $(window).resize(function(){
    
        __load_welcome_alert();        

    });


    function __load_welcome_alert(){

        $.ajax({
            url : site_url+"static_accessories/static_accessories_widget/welcome_alert_message/",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {  
                if(!data.is_read_welcome_alert){
                    $('#___modal_welcome_alert .modal-title').html(data.title);
                    $('#___modal_welcome_alert .modal-body').html(content+data.content);
                    $('#___modal_welcome_alert').modal({backdrop: 'static'});
                    $('#___modal_welcome_alert').modal('show');
                }               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                
            }
        });           
    }

    function __load_already_read(){

        $.ajax({
            url : site_url+"static_accessories/static_accessories_widget/welcome_alert_already_read/",
            type: "post",           
            dataType: "JSON",
            success: function(data)
            {
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                
            }
        });        
        
    }

</script>

<div class="modal" id="___modal_welcome_alert" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="__load_already_read()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-right" onclick="__load_already_read()" data-dismiss="modal"><i class="fa fa-close"></i> {{ language:Close }}</button>
            </div>
        </div>
    </div>
</div>