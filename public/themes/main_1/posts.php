<?php 
use Cls\Front\DB;
use Core\Img;
use Cls\Comm;
use Model\Post;
$this->layout('main');

?>
 

<?php $this->start('body');?>
<div class='am-container top' >
	<?php $this->extend('_posts');?>
</div>
 
<?php $this->end();?>

