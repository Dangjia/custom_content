<?php $t1 = microtime(true);
use Cls\Comm;
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo Comm::config('front_title').$title;?></title>
		<meta name="description" content="">
		
		<link rel="shortcut icon" href="<?php echo url('favicon.png'); ?>">


		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
		<link rel="stylesheet" href="<?php echo theme_url('style.css');?>">
	    <meta name="viewport" content="width=device-width">
	    <meta name="generator" content="CMS">
	</head>
	<body>
	
	<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <?php $this->extend('inc/header');?>
    </div>

    <div id="main">
        <?php echo $this->view['body'];?>
    </div>
</div>

	
	  
   

    
        
        
    <script src="<?php echo url('misc/jquery.js'); ?>"></script>
    <script src="<?php echo theme_url('script.js'); ?>"></script>
    <?php echo $this->view['footer'];?>    
        
    </body>
</html>
<?php 
    if(!is_ajax()){
    	$t2 = microtime(true);
    	echo "\n<!-- render page:".round($t2-$t1,5)." s -->";
    }
?>  