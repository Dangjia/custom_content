<nav class="navbar navbar-inverse">
  <div class="container-fluid container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo url('admin/config/index');?>">
      <?php echo Cls\Comm::config('admin_title')?:"admin_title at admin";?>
      </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
      <?php 
      
      $menu = [
      	'文章'=>'/post/admin/index|post/admin/index,post/admin/view',
      	'分类'=>'/post/type/index|post/type/index,post/type/view',
      	'菜单'=>'/menu/admin/index|menu/admin',
      	'用户'=>'/admin/user/index|admin/user',
      ];
      $uri = substr($_SERVER['REQUEST_URI'],1);
      foreach ($menu as $label=>$v){
      	$ar = explode('|',$v);
      	$murl = $ar[0];
      	$select = explode(',',$ar[1]);
      	if(!$select[0]){
      		$select = [''];
      	}
      	unset($act);
      	foreach($select as $v1){
      		if(!$v1 && !$uri){
      			$act = "class='active'";
      			continue;
      		}
      		if($v1 && strpos($uri,$v1)!==false){
      			$act = "class='active'";
      		}
      	}
      ?>
        <li <?php echo $act;?> ><a href="<?php echo $murl;?>"><?php echo $label;?></a></li>
	  <?php }?>         
	  
	  <li class="dropdown">
		  <a  style="cursor:pointer"  id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    扩展
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
		     <?php 
      
		      $menu = [
		      	'系统配置'=>'/admin/config/index|admin/config/index,admin/config/view',
		      	'日志'=>'/admin/log/index|admin/log',
		      	//'插件'=>'/admin/plugin/index|admin/plugin',
		      	//'视图块'=>'/admin/block/index|admin/block',
		      	//'CDN'=>'/cdn/admin/index|cdn/admin',
		      ]+Cls\Comm::admin_content_menu();
		      $uri = substr($_SERVER['REQUEST_URI'],1);
		      foreach ($menu as $label=>$v){
		      	$ar = explode('|',$v);
		      	$murl = $ar[0];
		      	$select = explode(',',$ar[1]);
		      	if(!$select[0]){
		      		$select = [''];
		      	}
		      	unset($act);
		      	foreach($select as $v1){
		      		if(!$v1 && !$uri){
		      			$act = "class='active'";
		      			continue;
		      		}
		      		if($v1 && strpos($uri,$v1)!==false){
		      			$act = "class='active'";
		      		}
		      	}
		      ?>
		        <li <?php echo $act;?> ><a href="<?php echo $murl;?>"><?php echo $label;?></a></li>
			  <?php }?>   
		  </ul>
		</li>
		

      </ul>
       
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo url('admin/logout/index');?>">退出</a></li>
      </ul>
    </div>
  </div>
</nav>


<?php if(has_flash('success')){?>
<div class="page_message page_mess_ok flash"><?php echo flash('success');?></div>
<?php }?>
		

