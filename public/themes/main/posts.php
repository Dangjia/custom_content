<?php 
use Cls\Front\DB;
use Core\Img;
use Cls\Comm;
use Model\Post;
$this->layout('main');

?>
 

<?php $this->start('body');?>

	<?php $this->extend('_posts');?>
 
 
<?php $this->end();?>

