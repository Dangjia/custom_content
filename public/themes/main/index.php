<?php 
use Cls\Front\DB;
use Core\Img;
use Cls\Comm;
use Model\Post;
$this->layout('main');

$v = theme_get_post('home');

?>
<?php $this->start('body');?>


		<div class="header">
            <h1><?php echo $v->title;?></h1>
            <h2><?php echo $v->title2;?></h2>
        </div>

        <div class="content">
            <?php echo $v->body;?>
        </div>
        
  

 
 
<?php $this->end();?>

