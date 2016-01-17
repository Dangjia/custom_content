<?php 
$this->layout('main');
?>
<?php 

$this->start('body');
$this->extend('inc/header');
$par = ['s'=>$_GET['s']];

?>

<div class="container">
     
     <h1>文章</h1>
     <?php if($list==1){?>

     <table class="table">
      <caption>管理文章(<?php echo $count;?>). 
      
      	
				
      	<span class='pull-right'>
      	
      		
			 <form class="form-inline" method='get' style="margin:0px;padding:0px;display:inline;margin-right:30px;">
				  <div class="form-group">
				    <input type="text" name='q' value="<?php echo $_GET['q']?>" class="form-control"  placeholder="">
				  </div>
				  
				  <button type="submit" class="btn btn-default">搜索</button>
		</form>	
				
      		<a href="<?php echo url('post/admin/view');?>" class="button">
	          添加
	        </a>
	        
	        <a href="<?php echo url('post/admin/index');?>" class="button">
	          所有
	        </a>
	        
	        <a href="<?php echo url('post/admin/index',['s'=>1]);?>" class="button">
	          通过
	        </a>
	        
	        <a href="<?php echo url('post/admin/index',['s'=>0]);?>" class="button">
	          禁用
	        </a>
	      </span>
	  </caption>
      <thead>
        <tr>
          <th>标题</th>
          <th>内容</th>
          <th>时间</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($datas as $data){?>
        <tr>
          <th title="<?php echo $data->title;?>"><?php echo Cls\Str::cut(strip_tags($data->title),20);?></th>
          <td>
          <?php if($data->file[0]){?>
          	<span class="glyphicon glyphicon-picture" ></span>
          <?php }?>
          <?php echo Cls\Str::cut(strip_tags($data->body),20);?></td>
          <td><?php echo date('Y-m-d H',$data->created->sec);?></td>
          <td class='pull-right'>
          
          	<a href="<?php echo url('post/admin/status',['id'=>(string)$data->_id]+$par);?>" class="button">
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
	        
	        
          	<a href="<?php echo url('post/admin/view',['id'=>(string)$data->_id]);?>" class="fa fa-pencil">
	          
	        </a>
	        
	        <a href="<?php echo url('post/admin/remove',['id'=>(string)$data->_id]);?>" class="remove fa fa-remove">
	          
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
	    <label >标题</label>
	    <input type="input" class="form-control"  value="<?php echo $data->title;?>" name='title' >
	  </div>
	  <div class="form-group">
	    <label>分类</label>
		<p>
		    <select name='category' class=" select form-control" >
		    	<?php echo $category;?>
		    </select>
	    </p>
	  </div>
	  <div class="form-group">
	    <label >主体内容</label>
	    <textarea id='body'    class="form-control" name='body'  ><?php echo $data->body;?></textarea>
	  </div>
	  
	  <div class="form-group">
	    <label >url</label>
	    <input type="input" class="form-control"  value="<?php echo $data->slug;?>" name='slug' >
	  </div>
	
	  <div class="form-group">
	    <label>附件</label>
	  	<?php 
	  	widget('JUI');
	  	widget('Plupload',[
	  			'ele'=>'file',
	  			'option'=>[
		  			'CKEDITOR'=>'body',
					'maxSize'=>'30',
	  				'class'=>'upload',
	  				'count'=>100,
	  				'data'=>$data->file,
		  		]			
		]);
	  	?>
		<?php widget('ckeditor',['ele'=>'body']);?>       
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
$this->extend('inc/footer');
$this->end();
?>



 
