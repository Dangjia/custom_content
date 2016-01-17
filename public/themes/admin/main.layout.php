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
		 <link rel="stylesheet" href="<?php echo url('misc/Font-Awesome/css/font-awesome.css');?>">
		<link rel="stylesheet" href="<?php echo theme_url('/css/'.(Comm::config('admin_bootstrap_css')?:'cerulean').'.bootstrap.min.css'); ?>">
		<link rel="shortcut icon" href="<?php echo url('favicon.png'); ?>">
		<link rel="stylesheet" href="<?php echo theme_url('/css/style.css');?>">
	    <meta name="viewport" content="width=device-width">
	    <meta name="generator" content="CMS">
	</head>
	<body >
	
	    <?php echo $this->view['body'];?>
        
        <script src="<?php echo url('/misc/jquery.js'); ?>"></script>
        <script src="<?php echo url('/misc/jquery.form.js'); ?>"></script>
        <script src="<?php echo url('/misc/bootstrap/js/bootstrap.js'); ?>"></script>
        
        
        
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