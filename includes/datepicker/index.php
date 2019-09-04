
            
	    <link rel="stylesheet" href="css/datepicker.css">
	    
	    
	    <style>
		.datepicker{z-index:1151;}
	    </style>
	    <script>
		$(function(){
		    $("#tanggal").datepicker({
			format:'yyyy/dd/mm'
		    });
                });
	    </script>
        
                
                
                <!-- modal-->
                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    
                    <div class="modal-body">
                        <label>Tanggal</label>
                        <input type="text" id="tanggal">
                    </div>
                </div>
           
            
            <!--javascript here-->
            <script src="js/bootstrap-modal.js"></script>
            <script src="js/bootstrap-transition.js"></script>
            <script src="js/bootstrap-datepicker.js"></script>
