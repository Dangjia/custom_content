<?php 
use Cls\Comm;
Comm::set_admin_theme_css();
?>
<footer id="bottom" class="container-fluid container" style="margin-top:30px;">
                <small>&copy; <?php echo date('Y'); ?> . All rights reserved.</small>

                <ul role="navigation">

                </ul>
</footer>

        

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



<div style=""  class="container-fluid container" >
<form id='choiceTheme' action="" method="get">
	<small>选择主题颜色&nbsp;</small>
	<select name="AdminThemeTryChangeCSS" id="AdminThemeTryChangeCSS">
		<?php 
		$list = file_find(__DIR__.'/../css');
		foreach($list['file'] as $v){
			$v = file_name($v);
			if(strpos($v,'.css')!==false && $v!='style.css'){
				$v = str_replace('.bootstrap.min.css','',$v);
				$css[] = $v;
			}
		}
		?>
		<?php foreach($css as $v){?>
			<option <?php if($v==Comm::config('admin_bootstrap_css')){?> selected<?php }?> value="<?php echo $v;?>"><?php echo $v;?></option>
		<?php }?>
		
	</select>
</form>

<form id='choiceTheme2' action="" method="get">
	<small>选择主题&nbsp;</small>
	<select name="AdminThemeTryChange" id="AdminThemeTryChange">
		<?php 
				$css = config('app.admin_theme');
		?>
		<?php foreach($css as $v){?>
			<option <?php if($v==Comm::config('admin_theme')){?> selected<?php }?> value="<?php echo $v;?>"><?php echo $v;?></option>
		<?php }?>
		
	</select>
</form>

<br>
</div>