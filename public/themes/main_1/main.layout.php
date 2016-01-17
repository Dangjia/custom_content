<?php $t1 = microtime(true);
use Cls\Comm;
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo Comm::config('front_title').$title;?></title>
		<meta name="description" content="起合太极，吴式太极">
		<meta name="site" content="<?php echo host();?>" />
		
		<meta name="description" content="起合太极，吴式太极" />
		
		<link rel="shortcut icon" href="<?php echo url('favicon.png'); ?>">
		<link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css">
		<link rel="stylesheet" href="<?php echo theme_url('style.css');?>">
	    <meta name="viewport" content="width=device-width">
	    <meta name="generator" content="CMS">
	</head>
	<body>
	
	 
        <?php $this->extend('inc/header');?>
        <?php echo $this->view['body'];?>
	  
   

    
        
        
    <script src="<?php echo url('misc/jquery.js'); ?>"></script>
    <script src="http://cdn.amazeui.org/amazeui/2.5.0/js/amazeui.js"></script>
    <?php echo $this->view['footer'];?>    
        
    </body>
</html>
<?php 
    if(!is_ajax()){
    	$t2 = microtime(true);
    	echo "\n<!-- render page:".round($t2-$t1,5)." s -->";
    }
?>  