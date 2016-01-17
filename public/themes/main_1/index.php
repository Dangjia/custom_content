<?php 
use Cls\Front\DB;
use Core\Img;
use Cls\Comm;
use Model\Post;
$this->layout('main');

$v = theme_get_post('home');

?>
<?php $this->start('body');?>

<div class="get">
  <div class="am-g">
    <div class="am-u-lg-12">
      <h1 class=""><?php echo Comm::config('home_index')?:'config home_index key';?></h1>

      <p>
        <?php echo Comm::config('home_index_value')?:'config home_index_value key';?>
      </p>

      
    </div>
  </div>
</div>

<div class='am-container top' >
		 
        
</div> 

 
 
<?php $this->end();?>

