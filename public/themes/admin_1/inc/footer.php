<?php 
use Cls\Comm;
Comm::set_admin_theme_css();
?>

        

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭窗口</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="myModalRemove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">确认删除？</h4>
      </div>
      <div class="modal-body  alert-danger">
         删除数据将不可恢复,请慎重!!!
      </div>
      <div class="modal-footer">
      <a id='myModalRemoveLink' class="btn btn-default" >
      	 	 确认删除 
      </a>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭窗口</button>
        
      </div>
    </div>
  </div>
</div>



 