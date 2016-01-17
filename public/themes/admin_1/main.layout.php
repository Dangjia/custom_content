<?php
use Cls\Comm;
$t1 = microtime(true);
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo Cls\Comm::config('admin_title')?:"admin_title at admin";?></title>
		<meta name="description" content="">
		
		 <link rel="stylesheet" href="<?php echo url('misc/bootstrap4/css/bootstrap.css');?>">
    
    <link rel="stylesheet" href="<?php echo url('misc/Font-Awesome/css/font-awesome.css');?>">
    
		<link rel="stylesheet" href="<?php echo theme_url('/css/styles.css');?>">
	<link rel="stylesheet" href="<?php echo theme_url('/css/app.css');?>">
	    <meta name="viewport" content="width=device-width">
	    <meta name="generator" content="CMS">
			
	</head>
	<body >
	
	    
<div class="container-fluid" id="main">
    <div class="row row-offcanvas row-offcanvas-left">
        <div class="col-md-3 col-lg-2 sidebar-offcanvas" id="sidebar" role="navigation">
            <ul class="nav nav-pills nav-stacked">
            <?php 
      
		      $menu = [
		      	'系统配置'=>'/admin/config/index|admin/config/index,admin/config/view',
		      	'日志'=>'/admin/log/index|admin/log',
		      	'数据备份恢复'=>'/mongo/admin/index|mongo/admin',
		      		
		      	//	
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
		      <li class="nav-item <?php echo $act;?>">
                <a class="nav-link" href="<?php echo $murl;?>"><?php echo $label;?> </a>
             </li>
			  <?php }?> 
              
	  
               
            </ul>
        </div>
        <!--/col-->

        <div class="col-md-9 col-lg-10 main">
 
            <?php echo $this->view['body'];?>
        </div>
        <!--/main col-->
    </div>


	 
<footer class="container-fluid">


<p   style="float: right;"> ©<?php echo date('Y'); ?> Company</p>
    
	    <form id='choiceTheme2' action="" style="width: 200px;float: right;" method="get">
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
   
</footer>

</div>

        
        <script src="<?php echo url('/misc/jquery.js'); ?>"></script>
        <script src="<?php echo url('/misc/jquery.form.js'); ?>"></script>
        <script src="<?php echo url('/misc/bootstrap4/js/bootstrap.js'); ?>"></script>
        
        
        
        <script src="<?php echo url('/misc/app.js'); ?>"></script>
        <script src="<?php echo theme_url('/js/js.js'); ?>"></script>
        
        <?php
        widget('BootstrapSwitch');
        widget('Select2',[
        	'option'=>[
        		 
        	],
        ]);
        ?>
        <?php widget_render();?>
        <?php echo $this->view['footer'];?>
        
        
      
    </body>
    
</html>
<?php 
    if(!is_ajax()){
    	$t2 = microtime(true);
    	echo "\n<!-- render page:".round($t2-$t1,5)." s -->";
    }
?>  