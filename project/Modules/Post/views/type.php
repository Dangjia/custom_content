<?php 
use Model\Menu;
$datas = Menu::tableTree($datas);
$this->layout('main');

$this->start('body');
$this->extend('inc/header');
$par = ['s'=>$_GET['s']];

?>

<div class="container">
     <h1>分类</h1>
     <?php if($list==1){?>
     <table class="table">
      <caption>管理分类(<?php echo $count;?>). 
      	<span class='pull-right'>
      		<a href="<?php echo url('post/type/view');?>" class="button">
	          添加
	        </a>
	        
	      </span>
	  </caption>
      <thead>
        <tr>
          <th>标识</th>
          <th>标题</th>
          <th>时间</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($datas as $data){?>
        <tr>
          <td><?php echo $data->slug;?></td>
          <td><?php echo strip_tags($data->title);?></td>
          <td><?php echo date('Y-m-d H',$data->created->sec);?></td>
          <td class='pull-right'>
          
          	<a href="<?php echo url('post/type/status',['id'=>(string)$data->_id]+$par);?>" class="button">
	         	<?php 
	         		switch ($data->status){
	         			case 1:
	         				echo '<span class="fa fa-check"></span>';
	         				break;
	         			default:
	         				echo '<span class="fa fa-close" style="color:red;"></span>';
	         				break;
	         		}
	         	?> 
	        </a>
	        
	        
          	<a href="<?php echo url('post/type/view',['id'=>(string)$data->_id]);?>" class="fa fa-pencil">
	          
	        </a>
	        
	        <a href="<?php echo url('post/type/remove',['id'=>(string)$data->_id]);?>" class="remove fa fa-remove">
	          
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
	    <label >分类名</label>
	    <input type="input" class="form-control"  value="<?php echo $data->title;?>" name='title' >
	  </div>
	  <div class="form-group">
	    <label >唯一标识</label>
	    <input type="input" class="form-control"  value="<?php echo $data->slug;?>" name='slug' >
	  </div>
	  <?php if($category){?>
	  <div class="form-group">
	    <label >上一层分类</label>
		<p>
		    <select name='pid' class="select form-control">
		    	<?php echo $category;?>
		    </select>
	    </p>
	  </div>
	  <?php }?>
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
$this->extend('inc/footer');
$this->end();
?>



 
