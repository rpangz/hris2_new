<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start();

$asset = new CMS_Asset();
foreach($css_files as $file){
    $asset->add_css($file);
}
//echo $asset->compile_css();

foreach($js_files as $file){
    $asset->add_js($file);
}
//echo $asset->compile_js();

// For every content of option tag, this will replace '&nbsp;' with ' '
function __ommit_nbsp($matches){
  //return $matches[1].str_replace('&nbsp;', ' ', $matches[2]).$matches[3];
}

if(isset($_POST['id'])){

    echo $_POST['id'];
    $id = $_POST['id'];

}
else{


?>



 <div class="col-md-4">
            <table class="table">
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
                <!--pada prakteknya looping dari database-->
                <tr>
                    <td>Hari</td>
                    <td>Jakarta</td>
                    <td><a href="#" class="edit-record" data-id="1">Show</a></td>
                </tr>
                <tr>
                    <td>Hera</td>
                    <td>Bekasi</td>
                    <td><a href="#" class="edit-record" data-id="2">Show</a></td>
                </tr>
            </table>
        </div>
<?php } ?>
<!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="simpan btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


<script src="http://172.17.0.16/hris2/assets/jquery/jquery-1.11.2.min.js"></script>
<script src="http://172.17.0.16/hris2/assets/bootstrap/js/bootstrap.js"></script>

<script type="text/javascript">
        $(function(){
            $(document).on('click','.edit-record',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('http://172.17.0.16/hris2/karyawan/frmTasks2/',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
    </script>


