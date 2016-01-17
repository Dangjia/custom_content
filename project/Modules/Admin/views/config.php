<?php 
$this->layout('main');
$url = 'admin/config';
?>
<?php 

$this->start('body');
$this->extend('inc/header');
$par = ['s'=>$_GET['s']];

?>

<div class="container">
     <h1>系统配置</h1>
     
     <?php if($list==1){?>
     <table class="table">
      <caption>管理菜单(<?php echo $count;?>). 
      	<span class='pull-right'>
      		<a href="<?php echo url($url.'/view');?>" class="button">
	          添加
	        </a>
	         
	      </span>
	  </caption>
      <thead>
        <tr>
          <th>配置KEY</th>
          <th>值</th>
          <th>时间</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($datas as $data){?>
        <tr>
          <th scope="row"><?php echo strip_tags($data->title);?></th>
          <td><?php echo $data->value;?></td>
          <td><?php echo date('Y-m-d H',$data->created->sec);?></td>
          <td class='pull-right'>
          
          	<a href="<?php echo url($url.'/status',['id'=>(string)$data->_id]+$par);?>" class="button">
	         	<?php 
	         		switch ($data->status){
	         			case 1:
	         				echo '<span class="glyphicon glyphicon-ok"></span>';
	         				break;
	         			default:
	         				echo '<span class="glyphicon glyphicon-remove" style="color:red;"></span>';
	         				break;
	         		}
	         	?> 
	        </a>
	        
	        
          	<a href="<?php echo url($url.'/view',['id'=>(string)$data->_id]);?>" class="fa fa-pencil">
	          
	        </a>
	        
	        <a href="<?php echo url($url.'/remove',['id'=>(string)$data->_id]);?>" class="remove fa fa-remove">
	          
	        </a>
	        
	        
          </td>
        </tr>
       <?php }?> 
      </tbody>
    </table>
    <?php echo $page;?>
    <?php }?>
    
   <?php if($view==1){?>
     <form method="POST" class='ajaxform'  enctype="multipart/form-data">
	  <div class="form-group">
	    <label >配置名</label>
	    <input type="input" class="form-control"  value="<?php echo $data->title;?>" name='title' >
	  </div>
	  
	  
	  <div class="form-group">
	    <label >配置值</label>
	    <textarea type="input" class="form-control" id='value'   name='value' ><?php echo $data->value;?></textarea>
	  </div>
	  
	  <br style="clear:both;">
	  <div class="form-group">
	    <label>状态</label>
	    
	    <?php $status = [
	    	1=>'启用',
	    	0=>'禁用',
	    ];?>
	    <p>
	    <select name="status" class="select">
	    <?php 
	    $true = false;
	    foreach($status as $k=>$v){?>
	    	<option value=<?php echo $k;?> <?php if($true===false && ($data->status==$k || !$_GET['id']) ) { $true = true;?>selected<?php }?> >
	    		<?php echo $v;?>
	    	</option>
	    <?php }?>
	    </select>
	    </p>
	  </div>
	   
	  <button type="submit" id='submit' class="btn btn-success">保存</button>
	</form>
<?php }?>



</div>
     

<?php 
widget('Redactor',[
	'ele'=>'#value',	
]);
$this->extend('inc/footer');
$this->end();
?>



 
